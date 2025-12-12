<?php
// app/Http/Controllers/Admin/QuoteBlockController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QuoteBlock;
use App\Models\QuoteBlockCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class QuoteBlockController extends Controller
{
    public function index()
    {
        $categories = QuoteBlockCategory::with('blocks')->ordered()->get();
        $blocks = QuoteBlock::with('category')->ordered()->get();
        
        return view('bloques.index', compact('categories', 'blocks'));
    }

    public function create()
    {
        $categories = QuoteBlockCategory::active()->ordered()->get();
        $blockTypes = [
            'course' => 'Curso Personalizado',
            'audit' => 'Auditoría',
            'maintenance' => 'Mantenimiento',
            'software_module' => 'Módulo de Software',
            'section' => 'Sección',
            'generic' => 'Genérico'
        ];
        
        return view('admin.quote-blocks.form', compact('categories', 'blockTypes'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:quote_block_categories,id',
            'type' => 'required|in:course,audit,maintenance,software_module,section,generic',
            'base_price' => 'required|numeric|min:0',
            'default_hours' => 'required|integer|min:0'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $block = QuoteBlock::create([
            'name' => $request->name,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'type' => $request->type,
            'base_price' => $request->base_price,
            'default_hours' => $request->default_hours,
            'config' => $this->processConfig($request),// Archivo JSON con configuraciones específicas por tipo
            'formula' => $request->formula,
            'validation_rules' => $this->processValidationRules($request),
            'order' => QuoteBlock::where('category_id', $request->category_id)->max('order') + 1,
            'is_active' => $request->has('is_active')
        ]);

        return redirect()->route('bloques.index')
            ->with('success', 'Bloque creado exitosamente');
    }

    public function edit(QuoteBlock $quoteBlock)
    {
        $categories = QuoteBlockCategory::active()->ordered()->get();
        $blockTypes = [
            'course' => 'Curso Personalizado',
            'audit' => 'Auditoría',
            'maintenance' => 'Mantenimiento',
            'software_module' => 'Módulo de Software',
            'section' => 'Sección',
            'generic' => 'Genérico'
        ];
        
        return view('admin.quote-blocks.form', compact('quoteBlock', 'categories', 'blockTypes'));
    }

    public function update(Request $request, QuoteBlock $quoteBlock)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:quote_block_categories,id',
            'type' => 'required|in:course,audit,maintenance,software_module,section,generic',
            'base_price' => 'required|numeric|min:0',
            'default_hours' => 'required|integer|min:0'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $quoteBlock->update([
            'name' => $request->name,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'type' => $request->type,
            'base_price' => $request->base_price,
            'default_hours' => $request->default_hours,
            'config' => $this->processConfig($request),
            'formula' => $request->formula,
            'validation_rules' => $this->processValidationRules($request),
            'is_active' => $request->has('is_active')
        ]);

        return redirect()->route('bloques.index')
            ->with('success', 'Bloque actualizado exitosamente');
    }

    public function destroy(QuoteBlock $quoteBlock)
    {
        $quoteBlock->delete();
        
        return redirect()->route('bloques.index')
            ->with('success', 'Bloque eliminado exitosamente');
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'blocks' => 'required|array',
            'blocks.*.id' => 'required|exists:quote_blocks,id',
            'blocks.*.order' => 'required|integer'
        ]);

        foreach ($request->blocks as $block) {
            QuoteBlock::where('id', $block['id'])->update(['order' => $block['order']]);
        }

        return response()->json(['success' => true]);
    }

    private function processConfig(Request $request)
    {
        $config = [];
        
        switch ($request->type) {
            case 'course':
                $config = [
                    'modality' => [
                        'online' => ['surcharge' => 0, 'label' => 'En línea'],
                        'onsite' => ['surcharge' => 2000, 'label' => 'En instalaciones']
                    ],
                    'min_participants' => $request->min_participants ?? 10,
                    'price_per_participant' => $request->price_per_participant ?? 500
                ];
                break;
                
            case 'software_module':
                $config = [
                    'complexity_levels' => [
                        'low' => ['factor' => 0.8, 'label' => 'Baja'],
                        'medium' => ['factor' => 1.0, 'label' => 'Media'],
                        'high' => ['factor' => 1.5, 'label' => 'Alta']
                    ],
                    'integration_hours' => $request->integration_hours ?? 20,
                    'hourly_rate' => $request->hourly_rate ?? 500
                ];
                break;
                
            case 'audit':
                $config = [
                    'scope_levels' => [
                        'basic' => ['factor' => 0.7, 'label' => 'Básica'],
                        'standard' => ['factor' => 1.0, 'label' => 'Estándar'],
                        'comprehensive' => ['factor' => 1.5, 'label' => 'Integral']
                    ],
                    'cost_per_system' => $request->cost_per_system ?? 1000
                ];
                break;
        }
        
        return $config;
    }

    private function processValidationRules(Request $request)
    {
        $rules = [];
        
        switch ($request->type) {
            case 'course':
                $rules = [
                    'participants' => 'required|integer|min:10',
                    'modality' => 'required|in:online,onsite'
                ];
                break;
                
            case 'software_module':
                $rules = [
                    'complexity' => 'required|in:low,medium,high',
                    'estimated_hours' => 'required|integer|min:1'
                ];
                break;
        }
        
        return $rules;
    }
}
