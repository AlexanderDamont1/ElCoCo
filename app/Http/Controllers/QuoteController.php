<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use App\Models\QuoteItem;
use App\Models\QuoteBlock;
use App\Models\QuoteReply;
use App\Models\QuoteBlockCategory;
use App\Services\QuotePdfService;
use App\Mail\QuoteReplyMail;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class QuoteController extends Controller
{
    // =========================================================================
    // Cotizador público (SPA)
    // =========================================================================

    public function builder()
    {
        $categories = QuoteBlockCategory::with([
            'blocks' => fn ($q) => $q->active()->ordered(),
        ])->active()->ordered()->get();

        return view('quotes.builder', compact('categories'));
    }

    public function apiBlocks()
    {
        $categories = QuoteBlockCategory::with([
            'blocks' => fn ($q) => $q->active()->ordered(),
        ])->active()->ordered()->get()
        ->map(fn ($category) => [
            'id'          => $category->id,
            'name'        => $category->name,
            'description' => $category->description,
            'expanded'    => true,
            'blocks'      => $category->blocks->map(fn ($block) => [
                'id'            => $block->id,
                'name'          => $block->name,
                'description'   => $block->description,
                'category_id'   => $block->category_id,
                'base_price'    => (float) $block->base_price,
                'default_hours' => $block->default_hours,
                'config'        => $block->config ?: (object) [],
                'order'         => $block->order,
            ]),
        ]);

        return response()->json(['success' => true, 'categories' => $categories]);
    }

    // =========================================================================
    // Guardar borrador (sin enviar)
    // =========================================================================

    public function saveDraft(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'client.name'   => 'required|string|max:255',
            'client.email'  => 'required|email|max:255',
            'blocks'        => 'required|array',
            'summary.total' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $quote = Quote::create([
            'client_name'            => $request->input('client.name'),
            'client_email'           => $request->input('client.email'),
            'client_company'         => $request->input('client.company'),
            'client_phone'           => $request->input('client.phone'),
            'additional_requirements'=> $request->input('client.additional_requirements'),
            'data'                   => $request->all(),
            'subtotal'               => $request->input('summary.subtotal', 0),
            'tax'                    => $request->input('summary.tax', 0),
            'total'                  => $request->input('summary.total', 0),
            'total_hours'            => $request->input('summary.hours', 0),
            'status'                 => 'draft',
        ]);

        $this->saveQuoteItems($quote, $request->input('blocks', []));

        return response()->json([
            'success'   => true,
            'reference' => $quote->reference,
            'message'   => 'Cotización guardada como borrador',
        ]);
    }

    // =========================================================================
    // Enviar cotización (submit público)
    // =========================================================================

    public function submit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'client.name'   => 'required|string|max:255',
            'client.email'  => 'required|email|max:255',
            'blocks'        => 'required|array|min:1',
            'summary.total' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        try {
            $quote = Quote::create([
                'client_name'            => $request->input('client.name'),
                'client_email'           => $request->input('client.email'),
                'client_company'         => $request->input('client.company'),
                'client_phone'           => $request->input('client.phone'),
                'additional_requirements'=> $request->input('client.additional_requirements'),
                'data'                   => $request->all(),
                'subtotal'               => $request->input('summary.subtotal', 0),
                'tax'                    => $request->input('summary.tax', 0),
                'total'                  => $request->input('summary.total', 0),
                'total_hours'            => $request->input('summary.hours', 0),
                'status'                 => 'sent',
                'sent_at'                => now(),
            ]);

            $this->saveQuoteItems($quote, $request->input('blocks', []));

            $pdfService  = new QuotePdfService();
            $pdfContent  = $pdfService->generate($request->all());
            $pdfPath     = 'quotes/' . $quote->reference . '.pdf';

            Storage::disk('public')->put($pdfPath, $pdfContent);
            $quote->update(['pdf_path' => $pdfPath]);

            Log::info('Cotización enviada', [
                'reference' => $quote->reference,
                'client'    => $quote->client_email,
                'total'     => $quote->total,
            ]);

            return response()->json([
                'success'   => true,
                'reference' => $quote->reference,
                'pdf_url'   => Storage::url($pdfPath),
                'message'   => 'Cotización enviada exitosamente',
            ]);

        } catch (\Exception $e) {
            Log::error('Error al enviar cotización: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al procesar la cotización. Por favor, intenta nuevamente.',
            ], 500);
        }
    }

    // =========================================================================
    // Submit con cita (público)
    // =========================================================================

    public function submitWithAppointment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'client.name'    => 'required|string|max:255',
            'client.email'   => 'required|email|max:255',
            'blocks'         => 'required|array|min:1',
            'summary.total'  => 'required|numeric',
            'meeting_date'   => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        try {
            $quote = Quote::create([
                'client_name'            => $request->input('client.name'),
                'client_email'           => $request->input('client.email'),
                'client_company'         => $request->input('client.company'),
                'client_phone'           => $request->input('client.phone'),
                'additional_requirements'=> $request->input('client.additional_requirements'),
                'data'                   => $request->all(),
                'subtotal'               => $request->input('summary.subtotal', 0),
                'tax'                    => $request->input('summary.tax', 0),
                'total'                  => $request->input('summary.total', 0),
                'total_hours'            => $request->input('summary.hours', 0),
                'status'                 => 'sent',
                'sent_at'                => now(),
            ]);

            $this->saveQuoteItems($quote, $request->input('blocks', []));

            // Guardar la cita como reply inicial
            QuoteReply::create([
                'quote_id' => $quote->id,
                'message'  => 'Cita solicitada: ' . $request->input('meeting_date'),
                'sent_at'  => $request->input('meeting_date'),
            ]);

            $pdfService = new QuotePdfService();
            $pdfContent = $pdfService->generate($request->all());
            $pdfPath    = 'quotes/' . $quote->reference . '.pdf';

            Storage::disk('public')->put($pdfPath, $pdfContent);
            $quote->update(['pdf_path' => $pdfPath]);

            return response()->json([
                'success'   => true,
                'reference' => $quote->reference,
                'pdf_url'   => Storage::url($pdfPath),
                'message'   => 'Cotización con cita enviada exitosamente',
            ]);

        } catch (\Exception $e) {
            Log::error('Error al enviar cotización con cita: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al procesar la cotización.',
            ], 500);
        }
    }

    // =========================================================================
    // Generar PDF (admin o inline)
    // =========================================================================

    public function generatePdf(Request $request, Quote $quote = null)
    {
        if ($quote) {
            $data = [
                'client' => [
                    'name'    => $quote->client_name,
                    'email'   => $quote->client_email,
                    'company' => $quote->client_company,
                    'phone'   => $quote->client_phone,
                ],
                'blocks' => $quote->items->map(fn ($item) => [
                    'name'        => $item->name,
                    'description' => $item->description,
                    'hours'       => (int)   $item->hours,
                    'base_price'  => (float) $item->unit_price,
                    'total_price' => (float) $item->total_price,
                ])->toArray(),
                'summary' => [
                    'subtotal' => (float) $quote->subtotal,
                    'tax'      => (float) $quote->tax,
                    'total'    => (float) $quote->total,
                ],
            ];
            $filename = 'cotizacion-' . $quote->reference . '.pdf';
        } else {
            $data     = $request->all();
            $filename = 'cotizacion.pdf';
        }

        $pdf = (new QuotePdfService())->generate($data);

        return response($pdf, 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    // =========================================================================
    // Admin — listado
    // =========================================================================

    public function index(Request $request)
    {
        $query = Quote::query();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('client_name',  'like', "%$q%")
                    ->orWhere('client_email', 'like', "%$q%")
                    ->orWhere('reference',    'like', "%$q%");
            });
        }

        $quotes = $query
            ->withCount('items')
            ->orderByDesc('created_at')
            ->paginate(15)
            ->withQueryString();

        return view('admin.quotes.index', compact('quotes'));
    }

    // =========================================================================
    // Admin — detalle
    // =========================================================================

    public function show(Quote $quote)
    {
        $quote->load([
            'items.block',
            'replies',
        ]);

        return view('admin.quotes.show', compact('quote'));
    }

    // =========================================================================
    // Admin — cambiar estado
    // =========================================================================

    public function updateStatus(Request $request, Quote $quote)
    {
        $request->validate([
            'status' => 'required|in:draft,sent,accepted,rejected,expired',
        ]);

        $quote->update(['status' => $request->status]);

        return redirect()
            ->route('admin.quotes.show', $quote)
            ->with('success', 'Estado actualizado correctamente');
    }

    // =========================================================================
    // Admin — responder con cita
    // =========================================================================

    public function reply(Request $request, Quote $quote)
    {
        $request->validate([
            'meeting_date' => 'required|date',
            'meet_link'    => 'nullable|url|max:500',
        ]);

        $message = $this->formatMeetingMessage($request->meeting_date, $request->meet_link);

        QuoteReply::create([
            'quote_id'   => $quote->id,
            'message'    => $message,
            'sent_at'    => $request->meeting_date,
            'meet_link'  => $request->meet_link,
            'created_by' => auth()->id(),
        ]);

        $pdfContent = $this->buildPdfFromQuote($quote);
        $pdfPath    = 'quotes/' . $quote->reference . '.pdf';
        Storage::disk('public')->put($pdfPath, $pdfContent);

        Mail::to($quote->client_email)->send(
            new QuoteReplyMail($quote, $message, $pdfPath)
        );

        return redirect()
            ->route('admin.quotes.show', $quote)
            ->with('success', 'Cita guardada y correo enviado con cotización adjunta.');
    }

    // =========================================================================
    // Helpers privados
    // =========================================================================

    private function saveQuoteItems(Quote $quote, array $blocks): void
    {
        foreach ($blocks as $block) {
            QuoteItem::create([
                'quote_id'      => $quote->id,
                'quote_block_id'=> $block['id'] ?? null,
                'name'          => $block['name'] ?? 'Sin nombre',
                'description'   => $block['description'] ?? null,
                'type'          => $block['type'] ?? 'generic',
                'quantity'      => $block['quantity'] ?? 1,
                'hours'         => $block['hours'] ?? 0,
                'unit_price'    => $block['base_price'] ?? $block['unit_price'] ?? 0,
                'total_price'   => $block['total_price'] ?? $block['totalPrice'] ?? 0,
                'data'          => $block['data'] ?? $block['config'] ?? [],
            ]);
        }
    }

    private function buildPdfFromQuote(Quote $quote): string
    {
        $quote->loadMissing('items');

        $data = [
            'client' => [
                'name'    => $quote->client_name,
                'email'   => $quote->client_email,
                'company' => $quote->client_company,
                'phone'   => $quote->client_phone,
            ],
            'blocks' => $quote->items->map(fn ($item) => [
                'name'        => $item->name,
                'description' => $item->description,
                'hours'       => (int)   $item->hours,
                'base_price'  => (float) $item->unit_price,
                'total_price' => (float) $item->total_price,
            ])->toArray(),
            'summary' => [
                'subtotal' => (float) $quote->subtotal,
                'tax'      => (float) $quote->tax,
                'total'    => (float) $quote->total,
            ],
        ];

        return Pdf::loadView('quotes.pdf.cotizacion', compact('data'))
            ->setPaper('a4')
            ->output();
    }

    private function formatMeetingMessage(string $date, ?string $link = null): string
    {
        $formatted = (new \DateTime($date))->format('d/m/Y H:i');
        $msg = "Cita agendada para el $formatted";
        if ($link) {
            $msg .= " — Enlace: $link";
        }
        return $msg;
    }
}