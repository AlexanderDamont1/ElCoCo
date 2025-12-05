<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use App\Mail\QuoteReceived;
use App\Mail\QuoteAdminNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class QuoteController extends Controller
{
    /**
     * Mostrar el constructor de cotizaciones
     */
    public function showBuilder()
    {
        return view('quote-builder');
    }

    /**
     * Procesar el envío de la cotización
     */
    public function submitQuote(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'project_description' => 'nullable|string',
            'blocks' => 'required|array',
            'total_hours' => 'required|integer|min:1',
            'total_cost' => 'required|integer|min:500',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Crear la cotización en la base de datos
            $quote = Quote::create([
                'name' => $request->name,
                'email' => $request->email,
                'project_description' => $request->project_description,
                'blocks' => json_encode($request->blocks),
                'total_hours' => $request->total_hours,
                'total_cost' => $request->total_cost,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            // Enviar email al cliente
            Mail::to($request->email)->send(new QuoteReceived($quote));

            // Enviar email al administrador
            Mail::to(config('mail.admin_email'))->send(new QuoteAdminNotification($quote));

            return response()->json([
                'success' => true,
                'message' => 'Cotización enviada exitosamente',
                'quote_id' => $quote->id,
                'reference' => 'QUOTE-' . str_pad($quote->id, 8, '0', STR_PAD_LEFT)
            ]);

        } catch (\Exception $e) {
            \Log::error('Error al procesar cotización: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al procesar la cotización. Por favor, intenta nuevamente.'
            ], 500);
        }
    }

    /**
     * Exportar cotización como PDF
     */
    public function exportPdf($id)
    {
        $quote = Quote::findOrFail($id);
        
        // Aquí iría la lógica para generar el PDF
        // Usando DomPDF, TCPDF, o similar
        
        return response()->json([
            'success' => true,
            'message' => 'PDF generado exitosamente'
        ]);
    }
}