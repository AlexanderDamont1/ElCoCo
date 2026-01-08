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
            'config' => $this->processConfig($request->input('extras')),// Archivo JSON con configuraciones específicas por tipo
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
        return view('bloques.edit', compact('quoteBlock', 'categories', 'blockTypes'));
    }

    public function update(Request $request, QuoteBlock $quoteBlock)
    {

        $config = $this->processConfig($request->input('extras'));

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:quote_block_categories,id',
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
            'base_price' => $request->base_price,
            'default_hours' => $request->default_hours,
            'config' => $config,
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

   
   private function processConfig(?array $extras): array
{
    if (!$extras) {
        return [];
    }

    $config = [];

    foreach ($extras as $item) {
        if (
            empty($item['key']) ||
            !array_key_exists('value', $item)
        ) {
            continue;
        }

        $key = $item['key'];
        $value = $item['value'];

        // Si es número, se guarda sin comillas
        if (is_numeric($value)) {
            $value = $value + 0;
        }

        $config[] = [
            $key => $value
        ];
    }

    return $config;
}

}
