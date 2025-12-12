<?php
// app/Http/Controllers/QuoteController.php
namespace App\Http\Controllers;

use App\Models\Quote;
use App\Models\QuoteItem; // IMPORTANTE: Agrega esta línea
use App\Models\QuoteBlock;
use App\Services\QuotePdfService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class QuoteController extends Controller
{
    public function builder()
    {
        return view('quotes.builder');
    }

    public function apiBlocks()
    {
        // Obtener categorías con sus bloques en formato para el frontend
        $categories = \App\Models\QuoteBlockCategory::with(['blocks' => function($query) {
            $query->active()->ordered();
        }])
        ->active()
        ->ordered()
        ->get()
        ->map(function($category) {
            return [
                'id' => $category->id,
                'name' => $category->name,
                'description' => $category->description,
                'expanded' => true,
                'blocks' => $category->blocks->map(function($block) {
                    return [
                        'id' => $block->id,
                        'name' => $block->name,
                        'description' => $block->description,
                        'type' => $block->type,
                        'category_id' => $block->category_id,
                        'base_price' => (float) $block->base_price,
                        'default_hours' => $block->default_hours,
                        'config' => $block->config ?: (object) [],
                        'formula' => $block->formula,
                        'validation_rules' => $block->validation_rules ?: (object) [],
                        'order' => $block->order
                    ];
                })
            ];
        });

        return response()->json([
            'success' => true,
            'categories' => $categories
        ]);
    }

    public function getBlocksByCategory($id)
    {
        return response()->json(
            QuoteBlock::byCategory($id)->active()->ordered()->get()
        );
    }

    public function saveDraft(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'client.name' => 'required|string|max:255',
            'client.email' => 'required|email|max:255',
            'blocks' => 'required|array',
            'summary.total' => 'required|numeric|min:0'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Guardar cotización (la referencia se genera automáticamente en el modelo Quote)
        $quote = Quote::create([
            'client_name' => $request->input('client.name'),
            'client_email' => $request->input('client.email'),
            'client_company' => $request->input('client.company'),
            'client_phone' => $request->input('client.phone'),
           // 'project_description' => $request->input('client.project_description'),
            'additional_requirements' => $request->input('client.additional_requirements'),
            'data' => $request->all(),
            'subtotal' => $request->input('summary.subtotal', 0),
            'tax' => $request->input('summary.tax', 0),
            'total' => $request->input('summary.total', 0),
            'total_hours' => $request->input('summary.hours', 0),
            'status' => 'draft'
        ]);

        // Guardar items de la cotización
        $this->saveQuoteItems($quote, $request->input('blocks', []));

        return response()->json([
            'success' => true,
            'reference' => $quote->reference,
            'message' => 'Cotización guardada como borrador'
        ]);
    }

    public function generatePdf(Request $request)
    {
        $pdfService = new QuotePdfService();
        $pdf = $pdfService->generate($request->all());

        return response($pdf, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="cotizacion.pdf"'
        ]);
    }

    public function getStatistics()
    {
        return response()->json([
            'total' => Quote::count(),
            'today' => Quote::whereDate('created_at', now())->count(),
            'total_value' => Quote::sum('total'),
            'average_value' => Quote::avg('total')
        ]);
    }

    public function getRecentQuotes(Request $request)
    {
        $limit = $request->input('limit', 10);
        $quotes = Quote::with('items')->latest()->take($limit)->get();

        return response()->json([
            'success' => true,
            'quotes' => $quotes
        ]);
    }

    public function duplicateQuote($id)
    {
        $original = Quote::with('items')->findOrFail($id);
        $copy = $original->replicate();
        $copy->reference = $original->reference . '-COPY';
        $copy->save();

        // Duplicar items
        foreach ($original->items as $item) {
            $itemCopy = $item->replicate();
            $itemCopy->quote_id = $copy->id;
            $itemCopy->save();
        }

        return response()->json([
            'success' => true,
            'quote' => $copy
        ]);
    }

    public function exportQuotes()
    {
        return response()->json([
            'message' => 'Export functionality pending'
        ]);
    }

    public function submit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'client.name' => 'required|string|max:255',
            'client.email' => 'required|email|max:255',
            'blocks' => 'required|array|min:1',
            'summary.total' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Guardar cotización (la referencia se genera automáticamente en el modelo Quote)
            $quote = Quote::create([
                'client_name' => $request->input('client.name'),
                'client_email' => $request->input('client.email'),
                'client_company' => $request->input('client.company'),
                'client_phone' => $request->input('client.phone'),
             //   'project_description' => $request->input('client.project_description'),
                'additional_requirements' => $request->input('client.additional_requirements'),
                'data' => $request->all(),
                'subtotal' => $request->input('summary.subtotal', 0),
                'tax' => $request->input('summary.tax', 0),
                'total' => $request->input('summary.total', 0),
                'total_hours' => $request->input('summary.hours', 0),
                'status' => 'sent',
                'sent_at' => now()
            ]);

            // Guardar items de la cotización
            $this->saveQuoteItems($quote, $request->input('blocks', []));

            // Generar PDF
            $pdfService = new QuotePdfService();
            $pdfContent = $pdfService->generate($request->all());
            
            // Guardar PDF
            $pdfPath = 'quotes/' . $quote->reference . '.pdf';
            Storage::disk('public')->put($pdfPath, $pdfContent);
            
            // Actualizar quote con ruta del PDF
            $quote->update(['pdf_path' => $pdfPath]);

            Log::info('Cotización guardada exitosamente', [
                'reference' => $quote->reference,
                'client' => $quote->client_email,
                'total' => $quote->total
            ]);

            return response()->json([
                'success' => true,
                'reference' => $quote->reference,
                'pdf_url' => Storage::url($pdfPath),
                'message' => 'Cotización enviada exitosamente'
            ]);

        } catch (\Exception $e) {
            Log::error('Error submitting quote: ' . $e->getMessage());
            Log::error('Request data: ' . json_encode($request->all()));
            
            return response()->json([
                'success' => false,
                'message' => 'Error al procesar la cotización. Por favor, intenta nuevamente.'
            ], 500);
        }
    }

    /**
     * Guardar items de la cotización en la base de datos
     * Método privado para reutilizar en saveDraft() y submit()
     */
    private function saveQuoteItems(Quote $quote, array $blocks)
    {
        foreach ($blocks as $blockData) {
            QuoteItem::create([
                'quote_id' => $quote->id,
                'quote_block_id' => $blockData['id'] ?? null,
                'name' => $blockData['name'] ?? 'Sin nombre',
                'description' => $blockData['description'] ?? null,
                'type' => $blockData['type'] ?? 'generic',
                'quantity' => $blockData['quantity'] ?? 1,
                'hours' => $blockData['hours'] ?? 0,
                'unit_price' => $blockData['base_price'] ?? $blockData['unit_price'] ?? 0,
                'total_price' => $blockData['total_price'] ?? $blockData['totalPrice'] ?? 0,
                'data' => $blockData['data'] ?? $blockData['config'] ?? []
            ]);
        }
        
        Log::info('Items guardados para cotización', [
            'quote_id' => $quote->id,
            'items_count' => count($blocks)
        ]);
    }
}