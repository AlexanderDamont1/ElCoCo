<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Quote;
use App\Models\QuoteBlock;
use App\Models\QuoteBlockCategory;
use App\Services\QuotePdfService;
use App\Mail\QuoteReceived;
use App\Mail\QuoteAdminNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;

class QuoteApiController extends Controller
{
    /**
     * Obtener todos los bloques activos con sus categorías
     */
    public function getBlocks()
    {
        // Cache por 1 hora para mejor performance
        $data = Cache::remember('quote_blocks', 3600, function() {
            $categories = QuoteBlockCategory::with(['blocks' => function($query) {
                $query->active()->ordered();
            }])->active()->ordered()->get();
            
            $blocks = $categories->flatMap->blocks;
            
            return [
                'categories' => $categories->map(function($category) {
                    return [
                        'id' => $category->id,
                        'name' => $category->name,
                        'description' => $category->description,
                        'icon' => $category->icon,
                        'color' => $category->color,
                        'expanded' => true // Por defecto expandido
                    ];
                }),
                'blocks' => $blocks->map(function($block) {
                    return [
                        'id' => $block->id,
                        'name' => $block->name,
                        'description' => $block->description,
                        'type' => $block->type,
                        'category_id' => $block->category_id,
                        'base_price' => (float) $block->base_price,
                        'default_hours' => (int) $block->default_hours,
                        'config' => $block->config ?? [],
                        'formula' => $block->formula,
                        'validation_rules' => $block->validation_rules ?? []
                    ];
                })
            ];
        });
        
        return response()->json($data);
    }
    
    /**
     * Guardar cotización como borrador
     */
    public function saveDraft(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'client.name' => 'required|string|max:255',
            'client.email' => 'required|email|max:255',
            'blocks' => 'required|array|min:1',
            'summary.total' => 'required|numeric|min:0'
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        
        try {
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
                'message' => 'Cotización guardada como borrador',
                'quote_id' => $quote->id
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error saving draft: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar la cotización'
            ], 500);
        }
    }
    
    /**
     * Generar PDF de cotización
     */
    public function generatePdf(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'client.name' => 'required|string|max:255',
            'client.email' => 'required|email|max:255',
            'blocks' => 'required|array|min:1',
            'summary.total' => 'required|numeric|min:0'
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        
        try {
            $pdfService = new QuotePdfService();
            $pdfContent = $pdfService->generate($request->all());
            
            // Crear referencia para el archivo
            $reference = 'DRAFT-' . strtoupper(uniqid());
            $filename = 'quotes/temp/' . $reference . '.pdf';
            
            // Guardar temporalmente (se borrará después de 24 horas)
            Storage::put('public/' . $filename, $pdfContent);
            
            // URL temporal válida por 24 horas
            $url = asset('storage/' . $filename);
            
            return response()->json([
                'success' => true,
                'pdf_url' => $url,
                'reference' => $reference,
                'message' => 'PDF generado exitosamente'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error generating PDF: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al generar el PDF'
            ], 500);
        }
    }
    
    /**
     * Enviar cotización formalmente
     */
    public function submitQuote(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'client.name' => 'required|string|max:255',
            'client.email' => 'required|email|max:255',
            'client.company' => 'required|string|max:255',
            'client.phone' => 'required|string|max:20',
            'blocks' => 'required|array|min:1',
            'summary.total' => 'required|numeric|min:100'
        ], [
            'summary.total.min' => 'El total debe ser al menos $100 MXN'
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        
        // Validar bloques específicos
        $validationErrors = $this->validateBlocks($request->input('blocks'));
        if (!empty($validationErrors)) {
            return response()->json([
                'success' => false,
                'errors' => ['blocks' => $validationErrors]
            ], 422);
        }
        
        try {
            // Iniciar transacción
            \DB::beginTransaction();
            
            // Crear cotización
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
            
            // Guardar PDF permanentemente
            $pdfPath = 'quotes/' . $quote->reference . '.pdf';
            Storage::put('public/' . $pdfPath, $pdfContent);
            $quote->update(['pdf_path' => $pdfPath]);
            
            // Enviar emails
            Mail::to($quote->client_email)->send(new QuoteReceived($quote));
            Mail::to(config('mail.admin_email'))->send(new QuoteAdminNotification($quote));
            
            // Registrar en logs
            \Log::info('Quote submitted', [
                'reference' => $quote->reference,
                'client' => $quote->client_email,
                'total' => $quote->total
            ]);
            
            \DB::commit();
            
            return response()->json([
                'success' => true,
                'reference' => $quote->reference,
                'pdf_url' => asset('storage/' . $pdfPath),
                'quote_id' => $quote->id,
                'message' => 'Cotización enviada exitosamente'
            ]);
            
        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::error('Error submitting quote: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al procesar la cotización. Por favor, intenta nuevamente.'
            ], 500);
        }
    }
    
    /**
     * Validar bloques según sus reglas
     */
    private function validateBlocks(array $blocks): array
    {
        $errors = [];
        
        foreach ($blocks as $index => $block) {
            // Validar secciones y sus bloques anidados
            if ($block['type'] === 'section' && isset($block['nestedBlocks'])) {
                foreach ($block['nestedBlocks'] as $nestedIndex => $nestedBlock) {
                    $blockErrors = $this->validateSingleBlock($nestedBlock, $nestedIndex);
                    if (!empty($blockErrors)) {
                        $errors["section_{$index}_block_{$nestedIndex}"] = $blockErrors;
                    }
                }
            } else {
                $blockErrors = $this->validateSingleBlock($block, $index);
                if (!empty($blockErrors)) {
                    $errors["block_{$index}"] = $blockErrors;
                }
            }
        }
        
        return $errors;
    }
    
    /**
     * Validar un solo bloque
     */
    private function validateSingleBlock(array $block, int $index): array
    {
        $errors = [];
        
        // Validar cantidad
        if (($block['quantity'] ?? 1) < 1) {
            $errors[] = 'La cantidad debe ser al menos 1';
        }
        
        // Validaciones específicas por tipo
        switch ($block['type'] ?? 'generic') {
            case 'course':
                if (($block['participants'] ?? 0) < 10) {
                    $errors[] = 'El mínimo de participantes para cursos es 10';
                }
                if (!in_array($block['modality'] ?? '', ['online', 'onsite'])) {
                    $errors[] = 'Modalidad inválida';
                }
                break;
                
            case 'software_module':
                if (!in_array($block['complexity'] ?? '', ['low', 'medium', 'high'])) {
                    $errors[] = 'Complejidad inválida';
                }
                if (($block['estimatedHours'] ?? 0) < 1) {
                    $errors[] = 'Las horas estimadas deben ser al menos 1';
                }
                break;
                
            case 'audit':
                if (!in_array($block['scope'] ?? '', ['basic', 'standard', 'comprehensive'])) {
                    $errors[] = 'Alcance inválido';
                }
                if (($block['systems'] ?? 0) < 1) {
                    $errors[] = 'Debe incluir al menos un sistema';
                }
                break;
        }
        
        return $errors;
    }
    
    /**
     * Obtener estadísticas de cotizaciones
     */
    public function getStatistics()
    {
        $cacheKey = 'quote_statistics_' . date('Y-m');
        
        $data = Cache::remember($cacheKey, 3600, function() {
            $today = now()->format('Y-m-d');
            $monthStart = now()->startOfMonth()->format('Y-m-d');
            $yearStart = now()->startOfYear()->format('Y-m-d');
            
            return [
                'total' => Quote::count(),
                'sent' => Quote::where('status', 'sent')->count(),
                'accepted' => Quote::where('status', 'accepted')->count(),
                'today' => Quote::whereDate('created_at', $today)->count(),
                'this_month' => Quote::whereDate('created_at', '>=', $monthStart)->count(),
                'this_year' => Quote::whereDate('created_at', '>=', $yearStart)->count(),
                'total_value' => Quote::sum('total'),
                'average_value' => Quote::avg('total') ?? 0,
                'top_clients' => Quote::select('client_email', 'client_name', \DB::raw('count(*) as count'), \DB::raw('sum(total) as total'))
                    ->groupBy('client_email', 'client_name')
                    ->orderBy('count', 'desc')
                    ->limit(5)
                    ->get()
            ];
        });
        
        return response()->json($data);
    }
    
    /**
     * Duplicar una cotización existente
     */
    public function duplicateQuote($id)
    {
        try {
            $original = Quote::findOrFail($id);
            
            $newQuote = $original->replicate();
            $newQuote->reference = null; // Se generará automáticamente
            $newQuote->status = 'draft';
            $newQuote->sent_at = null;
            $newQuote->pdf_path = null;
            $newQuote->save();
            
            return response()->json([
                'success' => true,
                'reference' => $newQuote->reference,
                'message' => 'Cotización duplicada exitosamente'
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Error duplicating quote: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al duplicar la cotización'
            ], 500);
        }
    }
    
    /**
     * Exportar cotizaciones a CSV
     */
    public function exportQuotes(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'nullable|in:draft,sent,accepted,rejected,expired'
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        
        try {
            $query = Quote::query();
            
            if ($request->filled('start_date')) {
                $query->whereDate('created_at', '>=', $request->input('start_date'));
            }
            
            if ($request->filled('end_date')) {
                $query->whereDate('created_at', '<=', $request->input('end_date'));
            }
            
            if ($request->filled('status')) {
                $query->where('status', $request->input('status'));
            }
            
            $quotes = $query->orderBy('created_at', 'desc')->get();
            
            $csvData = "Referencia,Cliente,Email,Empresa,Total,IVA,Subtotal,Horas,Estado,Fecha\n";
            
            foreach ($quotes as $quote) {
                $csvData .= sprintf(
                    '%s,"%s",%s,"%s",%s,%s,%s,%s,%s,%s',
                    $quote->reference,
                    $quote->client_name,
                    $quote->client_email,
                    $quote->client_company ?? 'N/A',
                    $quote->total,
                    $quote->tax,
                    $quote->subtotal,
                    $quote->total_hours,
                    $quote->status,
                    $quote->created_at->format('Y-m-d H:i:s')
                ) . "\n";
            }
            
            $filename = 'quotes_export_' . date('Y-m-d_H-i-s') . '.csv';
            
            return response($csvData, 200, [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"'
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Error exporting quotes: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al exportar las cotizaciones'
            ], 500);
        }
    }
    
    /**
     * Obtener cotizaciones recientes
     */
    public function getRecentQuotes(Request $request)
    {
        $limit = $request->input('limit', 10);
        
        $quotes = Quote::with(['user' => function($query) {
            $query->select('id', 'name', 'email');
        }])
        ->latest()
        ->limit($limit)
        ->get()
        ->map(function($quote) {
            return [
                'id' => $quote->id,
                'reference' => $quote->reference,
                'client_name' => $quote->client_name,
                'client_email' => $quote->client_email,
                'total' => $quote->total,
                'status' => $quote->status,
                'created_at' => $quote->created_at->format('d/m/Y H:i'),
                'sent_at' => $quote->sent_at ? $quote->sent_at->format('d/m/Y H:i') : null,
                'pdf_url' => $quote->pdf_url
            ];
        });
        
        return response()->json([
            'success' => true,
            'quotes' => $quotes
        ]);
    }
    
    /**
     * Calcular precio de un bloque específico
     */
    public function calculateBlockPrice(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'block_id' => 'required|exists:quote_blocks,id',
            'quantity' => 'nullable|integer|min:1',
            'parameters' => 'nullable|array'
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        
        try {
            $block = QuoteBlock::findOrFail($request->input('block_id'));
            $quantity = $request->input('quantity', 1);
            $parameters = $request->input('parameters', []);
            
            // Calcular precio según tipo y fórmula
            $price = $this->calculatePrice($block, $parameters, $quantity);
            
            return response()->json([
                'success' => true,
                'price' => $price,
                'formatted_price' => '$' . number_format($price, 2) . ' MXN',
                'unit_price' => $price / $quantity,
                'message' => 'Precio calculado exitosamente'
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Error calculating block price: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al calcular el precio'
            ], 500);
        }
    }
    
    /**
     * Calcular precio basado en bloque y parámetros
     */
    private function calculatePrice(QuoteBlock $block, array $parameters, int $quantity = 1): float
    {
        $basePrice = (float) $block->base_price;
        
        // Si hay fórmula personalizada, usarla
        if (!empty($block->formula)) {
            return $this->evaluateFormula($block->formula, array_merge($parameters, [
                'base_price' => $basePrice,
                'quantity' => $quantity
            ]));
        }
        
        // Cálculo por tipo de bloque
        switch ($block->type) {
            case 'course':
                $participants = $parameters['participants'] ?? 10;
                $modality = $parameters['modality'] ?? 'online';
                
                $pricePerParticipant = $block->config['price_per_participant'] ?? 500;
                $surcharge = $block->config['modality'][$modality]['surcharge'] ?? 0;
                
                return (($pricePerParticipant * $participants) + $surcharge) * $quantity;
                
            case 'software_module':
                $complexity = $parameters['complexity'] ?? 'medium';
                $hours = $parameters['estimatedHours'] ?? $block->default_hours;
                $integration = $parameters['requiresIntegration'] ?? false;
                
                $hourlyRate = $block->config['hourly_rate'] ?? 500;
                $complexityFactor = $block->config['complexity_levels'][$complexity]['factor'] ?? 1.0;
                $integrationHours = $integration ? ($block->config['integration_hours'] ?? 20) : 0;
                
                $totalHours = ($hours * $complexityFactor) + $integrationHours;
                
                return ($totalHours * $hourlyRate) * $quantity;
                
            case 'audit':
                $scope = $parameters['scope'] ?? 'standard';
                $systems = $parameters['systems'] ?? 1;
                
                $scopeFactor = $block->config['scope_levels'][$scope]['factor'] ?? 1.0;
                $costPerSystem = $block->config['cost_per_system'] ?? 1000;
                
                return (($basePrice * $scopeFactor) + ($costPerSystem * $systems)) * $quantity;
                
            default:
                return $basePrice * $quantity;
        }
    }
    
    /**
     * Evaluar fórmula matemática de forma segura
     */
    private function evaluateFormula(string $formula, array $variables): float
    {
        // Reemplazar variables en la fórmula
        foreach ($variables as $key => $value) {
            $formula = str_replace('{' . $key . '}', (string) $value, $formula);
        }
        
        // Validar que solo contenga caracteres seguros
        if (!preg_match('/^[0-9+\-*\/()\s\.]+$/', $formula)) {
            throw new \Exception('Fórmula inválida');
        }
        
        // Evaluar la fórmula de forma segura
        try {
            $result = eval('return ' . $formula . ';');
            return (float) $result;
        } catch (\Throwable $e) {
            throw new \Exception('Error al evaluar la fórmula: ' . $e->getMessage());
        }
    }
    
    /**
     * Obtener bloques por categoría
     */
    public function getBlocksByCategory($categoryId)
    {
        $blocks = QuoteBlock::with('category')
            ->where('category_id', $categoryId)
            ->active()
            ->ordered()
            ->get()
            ->map(function($block) {
                return [
                    'id' => $block->id,
                    'name' => $block->name,
                    'description' => $block->description,
                    'type' => $block->type,
                    'base_price' => (float) $block->base_price,
                    'default_hours' => (int) $block->default_hours,
                    'config' => $block->config
                ];
            });
        
        return response()->json([
            'success' => true,
            'blocks' => $blocks
        ]);
    }
}
