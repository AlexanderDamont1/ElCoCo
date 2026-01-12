<x-app-layout>
    <div class="py-6">
        <div class="max-w-4xl mx-auto px-4">

            <!-- Header limpio -->
            <div class="mb-8">
                <div class="flex items-center justify-between mb-4">
                    <a href="{{ route('bloques.index') }}" 
                       class="text-sm text-blue-600 hover:text-blue-800">
                        ← Bloques
                    </a>
                </div>
                
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">
                            {{ isset($quoteBlock) ? 'Editar Bloque' : 'Nuevo Bloque' }}
                        </h1>
                        <p class="text-gray-500 mt-1">
                            {{ isset($quoteBlock) ? 'Modifica los detalles del bloque' : 'Crea un nuevo bloque para cotizaciones' }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Formulario principal -->
            <form action="{{ isset($quoteBlock) ? route('bloques.update', $quoteBlock) : '#' }}" method="POST">
                @csrf
                @if(isset($quoteBlock))
                    @method('PUT')
                @endif

                <!-- Información básica -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Información básica</h2>
                    
                    <div class="space-y-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                Nombre del bloque
                            </label>
                            <input type="text" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', $quoteBlock->name ?? '') }}" 
                                   required
                                   placeholder="Ej: Curso de Ofimática Avanzada"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-blue-500 text-sm">
                        </div>
                        
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                Descripción
                            </label>
                            <textarea id="description" 
                                      name="description" 
                                      rows="3"
                                      placeholder="Describe brevemente este servicio"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-blue-500 text-sm">{{ old('description', $quoteBlock->description ?? '') }}</textarea>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="base_price" class="block text-sm font-medium text-gray-700 mb-2">
                                    Precio base ($ MXN)
                                </label>
                                <input type="number" 
                                       id="base_price" 
                                       name="base_price" 
                                       value="{{ old('base_price', $quoteBlock->base_price ?? 0) }}" 
                                       required
                                       min="0"
                                       step="0.01"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-blue-500 text-sm">
                            </div>
                            
                            <div>
                                <label for="default_hours" class="block text-sm font-medium text-gray-700 mb-2">
                                    Horas por defecto
                                </label>
                                <input type="number" 
                                       id="default_hours" 
                                       name="default_hours" 
                                       value="{{ old('default_hours', $quoteBlock->default_hours ?? 0) }}" 
                                       required
                                       min="0"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-blue-500 text-sm">
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="order" class="block text-sm font-medium text-gray-700 mb-2">
                                    Orden de aparición
                                </label>
                                <input type="number" 
                                       id="order" 
                                       name="order" 
                                       value="{{ old('order', $quoteBlock->order ?? 0) }}"
                                       min="0"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-blue-500 text-sm">
                            </div>
                            
                            <div>
                                <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    Categoría
                                </label>
                                <select id="category_id"
                                        name="category_id"
                                        required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-blue-500 text-sm">
                                    <option value="">Selecciona una categoría</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('category_id', $quoteBlock->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="flex items-center">
                            <input class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" 
                                   type="checkbox" 
                                   id="is_active" 
                                   name="is_active" 
                                   value="1"
                                   {{ old('is_active', $quoteBlock->is_active ?? true) ? 'checked' : '' }}>
                            <label for="is_active" class="ml-2 text-sm text-gray-700">
                                Bloque activo
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Campos adicionales -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Campos adicionales</h2>
                    
                    <div id="dynamic-fields" class="space-y-3 mb-4">
                        @php
                            $extras = old('extras');
                            if (!$extras && isset($quoteBlock) && is_array($quoteBlock->config)) {
                                $extras = [];
                                foreach ($quoteBlock->config as $item) {
                                    foreach ($item as $k => $v) {
                                        $extras[] = ['key' => $k, 'value' => $v];
                                    }
                                }
                            }
                        @endphp

                        @if(!empty($extras))
                            @foreach($extras as $index => $extra)
                                <div class="flex items-center gap-2 dynamic-row">
                                    <input type="text"
                                        name="extras[{{ $index }}][key]"
                                        value="{{ $extra['key'] }}"
                                        placeholder="Etiqueta"
                                        class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-blue-500 text-sm">

                                    <input type="text"
                                        name="extras[{{ $index }}][value]"
                                        value="{{ $extra['value'] }}"
                                        placeholder="Valor"
                                        class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-blue-500 text-sm">

                                    <button type="button"
                                            onclick="addRow()"
                                            class="px-3 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 text-sm">
                                        +
                                    </button>

                                    <button type="button"
                                            onclick="removeRow(this)"
                                            class="px-3 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 text-sm">
                                        ×
                                    </button>
                                </div>
                            @endforeach
                        @else
                            <div class="flex items-center gap-2 dynamic-row">
                                <input type="text"
                                    name="extras[0][key]"
                                    placeholder="Etiqueta"
                                    class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-blue-500 text-sm">

                                <input type="text"
                                    name="extras[0][value]"
                                    placeholder="Valor"
                                    class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-blue-500 text-sm">

                                <button type="button"
                                        onclick="addRow()"
                                        class="px-3 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 text-sm">
                                    +
                                </button>

                                <button type="button"
                                        onclick="removeRow(this)"
                                        class="px-3 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 text-sm">
                                    ×
                                </button>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Botones de acción -->
                <div class="flex justify-between items-center mt-6 pt-6 border-t border-gray-200">
                    <a href="{{ route('bloques.index') }}" 
                       class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 text-sm font-medium">
                        Cancelar
                    </a>
                    
                    <div class="flex gap-2">
                        @if(isset($quoteBlock))
                            <button type="button" 
                                    onclick="confirmDelete()"
                                    class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 text-sm font-medium">
                                Eliminar
                            </button>
                        @endif
                        
                        <button type="submit" 
                                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm font-medium">
                            {{ isset($quoteBlock) ? 'Actualizar Bloque' : 'Crear Bloque' }}
                        </button>
                    </div>
                </div>
            </form>

            <!-- Formulario para eliminar -->
            @if(isset($quoteBlock))
                <form id="delete-form" 
                      action="#" 
                      method="POST" 
                      class="hidden">
                    @csrf
                    @method('DELETE')
                </form>
            @endif

        </div>
    </div>

    <script>
    // Inicializar basado en las filas que ya existen en el DOM
    let rowIndex = document.querySelectorAll('.dynamic-row').length;
    
    // Si no hay filas, empezar desde 1
    if (rowIndex === 0) {
        rowIndex = 1;
    }

    function addRow() {
        const container = document.getElementById('dynamic-fields');
        const row = document.createElement('div');
        row.classList.add('flex', 'items-center', 'gap-2', 'dynamic-row');

        row.innerHTML = `
            <input type="text"
                   name="extras[\${rowIndex}][key]"
                   placeholder="Etiqueta"
                   class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-blue-500 text-sm">

            <input type="text"
                   name="extras[\${rowIndex}][value]"
                   placeholder="Valor"
                   class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-blue-500 text-sm">

            <button type="button"
                    onclick="addRow()"
                    class="px-3 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 text-sm">
                +
            </button>

            <button type="button"
                    onclick="removeRow(this)"
                    class="px-3 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 text-sm">
                ×
            </button>
        `;

        container.appendChild(row);
        rowIndex++;
    }

    function removeRow(button) {
        const row = button.closest('.dynamic-row');
        if (document.querySelectorAll('.dynamic-row').length > 1) {
            row.remove();
        }
    }

    function confirmDelete() {
        if (confirm('¿Estás seguro de eliminar este bloque? Esta acción no se puede deshacer.')) {
            document.getElementById('delete-form').submit();
        }
    }
</script>
</x-app-layout>