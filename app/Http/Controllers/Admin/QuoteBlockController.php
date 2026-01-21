<?php

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

    /**
     * Vista para crear bloque
     */
    public function create()
    {
        $categories = QuoteBlockCategory::ordered()->get();

        $blockTypes = [
            'course' => 'Curso Personalizado',
            'audit' => 'Auditoría',
            'maintenance' => 'Mantenimiento',
            'software_module' => 'Módulo de Software',
            'section' => 'Sección',
            'generic' => 'Genérico',
        ];

        return view('bloques.create', compact('categories', 'blockTypes'));
    }

    /**
     * Guardar bloque
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:quote_block_categories,id',
          
            'base_price' => 'required|numeric|min:0',
            'default_hours' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        QuoteBlock::create([
            'name' => $request->name,
            'description' => $request->description,
            'category_id' => $request->category_id,
          
            'base_price' => $request->base_price,
            'default_hours' => $request->default_hours,
            'config' => $this->processConfig($request->input('extras')),
            'order' => QuoteBlock::where('category_id', $request->category_id)->max('order') + 1,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()
            ->route('bloques.index')
            ->with('success', 'Bloque creado exitosamente');
    }

    /**
     * Vista para editar bloque
     */
    public function edit(QuoteBlock $quoteBlock)
    {
        $categories = QuoteBlockCategory::ordered()->get();

        $blockTypes = [
            'course' => 'Curso Personalizado',
            'audit' => 'Auditoría',
            'maintenance' => 'Mantenimiento',
            'software_module' => 'Módulo de Software',
            'section' => 'Sección',
            'generic' => 'Genérico',
        ];

        return view('bloques.edit', compact('quoteBlock', 'categories', 'blockTypes'));
    }

    /**
     * Actualizar bloque
     */
    public function update(Request $request, QuoteBlock $quoteBlock)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:quote_block_categories,id',
            'base_price' => 'required|numeric|min:0',
            'default_hours' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $quoteBlock->update([
            'name' => $request->name,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'base_price' => $request->base_price,
            'default_hours' => $request->default_hours,
            'config' => $this->processConfig($request->input('extras')),
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()
            ->route('bloques.index')
            ->with('success', 'Bloque actualizado exitosamente');
    }

    public function destroy(QuoteBlock $quoteBlock)
    {
        $quoteBlock->delete();

        return redirect()
            ->route('bloques.index')
            ->with('success', 'Bloque eliminado exitosamente');
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'blocks' => 'required|array',
            'blocks.*.id' => 'required|exists:quote_blocks,id',
            'blocks.*.order' => 'required|integer',
        ]);

        foreach ($request->blocks as $block) {
            QuoteBlock::where('id', $block['id'])
                ->update(['order' => $block['order']]);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Procesar config dinámica
     */
    private function processConfig(?array $extras): array
    {
        if (!$extras) {
            return [];
        }

        $config = [];

        foreach ($extras as $item) {
            if (empty($item['key']) || !array_key_exists('value', $item)) {
                continue;
            }

            $value = is_numeric($item['value'])
                ? $item['value'] + 0
                : $item['value'];

            $config[] = [
                $item['key'] => $value,
            ];
        }

        return $config;
    }
}
