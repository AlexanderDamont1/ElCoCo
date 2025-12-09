<?php
// app/Http/Controllers/QuoteController.php
namespace App\Http\Controllers;

use App\Models\Quote;
use App\Services\QuotePdfService;
use App\Mail\QuoteReceived;
use App\Mail\QuoteAdminNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class QuoteController extends Controller
{
    public function builder()
    {
        return view('quotes.builder');
    }

    public function apiBlocks()
    {
        $categories = \App\Models\QuoteBlockCategory::with(['blocks' => function($query) {
            $query->active()->ordered();
        }])->active()->ordered()->get();

        return response()->json([
            'categories' => $categories,
            'blocks' => $categories->flatMap->blocks
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

        $quote = Quote::create([
            'client_name' => $request->input('client.name'),
            'client_email' => $request->input('client.email'),
            'client_company' => $request->input('client.company'),
            'client_phone' => $request->input('client.phone'),
            'project_description' => $request->input('client.project_description'),
            'additional_requirements' => $request->input('client.additional_requirements'),
            'data' => $request->all(),
            'subtotal' => $request->input('summary.subtotal', 0),
            'tax' => $request->input('summary.tax', 0),
            'total' => $request->input('summary.total', 0),
            'total_hours' => $request->input('summary.hours', 0),
            'status' => 'draft'
        ]);

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
    $quotes = Quote::latest()->take($limit)->get();

    return response()->json([
        'success' => true,
        'quotes' => $quotes
    ]);
}

public function duplicateQuote($id)
{
    $original = Quote::findOrFail($id);
    $copy = $original->replicate();
    $copy->reference = $original->reference . '-COPY';
    $copy->save();

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
            'client.company' => 'required|string|max:255',
            'client.phone' => 'required|string|max:20',
            'blocks' => 'required|array|min:1',
            'summary.total' => 'required|numeric|min:100'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Guardar cotización
            $quote = Quote::create([
                'client_name' => $request->input('client.name'),
                'client_email' => $request->input('client.email'),
                'client_company' => $request->input('client.company'),
                'client_phone' => $request->input('client.phone'),
                'project_description' => $request->input('client.project_description'),
                'additional_requirements' => $request->input('client.additional_requirements'),
                'data' => $request->all(),
                'subtotal' => $request->input('summary.subtotal', 0),
                'tax' => $request->input('summary.tax', 0),
                'total' => $request->input('summary.total', 0),
                'total_hours' => $request->input('summary.hours', 0),
                'status' => 'sent',
                'sent_at' => now()
            ]);

            // Generar PDF
            $pdfService = new QuotePdfService();
            $pdfContent = $pdfService->generate($request->all());
            
            $pdfPath = 'quotes/' . $quote->reference . '.pdf';
            Storage::put('public/' . $pdfPath, $pdfContent);
            
            $quote->update(['pdf_path' => $pdfPath]);

            // Enviar emails
            Mail::to($quote->client_email)->send(new QuoteReceived($quote));
            Mail::to(config('mail.admin_email'))->send(new QuoteAdminNotification($quote));

            return response()->json([
                'success' => true,
                'reference' => $quote->reference,
                'pdf_url' => asset('storage/' . $pdfPath),
                'message' => 'Cotización enviada exitosamente'
            ]);

            

        } catch (\Exception $e) {
            \Log::error('Error submitting quote: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al procesar la cotización. Por favor, intenta nuevamente.'
            ], 500);
        }
    }
    
}
