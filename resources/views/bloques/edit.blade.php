<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ isset($quoteBlock) ? 'Editar Bloque' : 'Nuevo Bloque' }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{route('bloques.update', $quoteBlock) }}" 
                          method="POST">
                        @csrf
                        @if(isset($quoteBlock))
                            @method('PUT')
                        @endif
                        
                        <div class="row">
                            <!-- Información básica -->
                            <div class="col-md-6">
                                <div class="card mb-4">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0 font-semibold">Información básica</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-4">
                                            <label for="name" class="block text-sm font-medium text-gray-700 required">Nombre del bloque</label>
                                            <input type="text" 
                                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" 
                                                   id="name" 
                                                   name="name" 
                                                   value="{{ old('name', $quoteBlock->name ?? '') }}" 
                                                   required
                                                   placeholder="Ej: Curso de Ofimática Avanzada">
                                        </div>
                                        
                                        <div class="mb-4">
                                            <label for="description" class="block text-sm font-medium text-gray-700">Descripción</label>
                                            <textarea class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" 
                                                      id="description" 
                                                      name="description" 
                                                      rows="3"
                                                      placeholder="Describe brevemente este servicio">{{ old('description', $quoteBlock->description ?? '') }}</textarea>
                                        </div>
                                        
                                       
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                            <div>
                                                <label for="base_price" class="block text-sm font-medium text-gray-700 required">Precio base ($ MXN)</label>
                                                <input type="number" 
                                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" 
                                                       id="base_price" 
                                                       name="base_price" 
                                                       value="{{ old('base_price', $quoteBlock->base_price ?? 0) }}" 
                                                       required
                                                       min="0"
                                                       step="0.01">
                                            </div>
                                            
                                            <div>
                                                <label for="default_hours" class="block text-sm font-medium text-gray-700 required">Horas por defecto</label>
                                                <input type="number" 
                                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" 
                                                       id="default_hours" 
                                                       name="default_hours" 
                                                       value="{{ old('default_hours', $quoteBlock->default_hours ?? 0) }}" 
                                                       required
                                                       min="0">
                                            </div>
                                        </div>
                                        
                                        <div class="mb-4">
                                            <label for="order" class="block text-sm font-medium text-gray-700">Orden de aparición</label>
                                            <input type="number" 
                                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" 
                                                   id="order" 
                                                   name="order" 
                                                   value="{{ old('order', $quoteBlock->order ?? 0) }}"
                                                   min="0">
                                        </div>

                                        <div class="mb-4">
                                            <label for="category_id" class="block text-sm font-medium text-gray-700 required">
                                                Categoría
                                            </label>

                                            <select id="category_id"
                                                    name="category_id"
                                                    required
                                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">

                                                <option value="">Selecciona una categoría</option>

                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}"
                                                        {{ old('category_id', $quoteBlock->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        
                                        <div class="flex items-center mb-4">
                                            <input class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" 
                                                   type="checkbox" 
                                                   id="is_active" 
                                                   name="is_active" 
                                                   value="1"
                                                   {{ old('is_active', $quoteBlock->is_active ?? true) ? 'checked' : '' }}>
                                            <label for="is_active" class="ml-2 block text-sm text-gray-700">
                                                Bloque activo
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                           <div class="mt-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Campos adicionales
                            </label>

                            <div id="dynamic-fields" class="space-y-3">

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
                                                class="flex-1 border-gray-300 rounded-md shadow-sm text-sm">

                                            <input type="text"
                                                name="extras[{{ $index }}][value]"
                                                value="{{ $extra['value'] }}"
                                                placeholder="Valor"
                                                class="flex-1 border-gray-300 rounded-md shadow-sm text-sm">

                                            <button type="button"
                                                    onclick="addRow()"
                                                    class="p-2 bg-green-600 text-white rounded hover:bg-green-700">
                                                +
                                            </button>

                                            <button type="button"
                                                    onclick="removeRow(this)"
                                                    class="p-2 bg-red-600 text-white rounded hover:bg-red-700">
                                                🗑
                                            </button>
                                        </div>
                                    @endforeach
                                @else
                                    {{-- Si no hay nada todavía --}}
                                    <div class="flex items-center gap-2 dynamic-row">
                                        <input type="text"
                                            name="extras[0][key]"
                                            placeholder="Etiqueta"
                                            class="flex-1 border-gray-300 rounded-md shadow-sm text-sm">

                                        <input type="text"
                                            name="extras[0][value]"
                                            placeholder="Valor"
                                            class="flex-1 border-gray-300 rounded-md shadow-sm text-sm">

                                        <button type="button"
                                                onclick="addRow()"
                                                class="p-2 bg-green-600 text-white rounded hover:bg-green-700">
                                            +
                                        </button>

                                        <button type="button"
                                                onclick="removeRow(this)"
                                                class="p-2 bg-red-600 text-white rounded hover:bg-red-700">
                                            🗑
                                        </button>
                                    </div>
                                @endif
                            </div>

                        </div>

                        
                        <!-- Botones de acción -->
                        <div class="flex justify-between items-center mt-6 pt-6 border-t border-gray-200">
                            <a href="{{ route('bloques.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Cancelar
                            </a>
                            
                            <div class="flex gap-2">
                                @if(isset($quoteBlock))
                                    <button type="button" 
                                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500" 
                                            onclick="confirmDelete()">
                                        Eliminar
                                    </button>
                                @endif
                                
                                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
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
        </div>
    </div>

    @stack('scripts')

    <script>
        // Mostrar/ocultar configuraciones según el tipo de bloque
        function updateFormFields() {
            const type = document.getElementById('type').value;
            
            // Ocultar todas las configuraciones
            document.querySelectorAll('.config-section').forEach(section => {
                section.style.display = 'none';
            });
            
            // Mostrar la configuración correspondiente
            const configSection = document.getElementById(`${type}-config`);
            if (configSection) {
                configSection.style.display = 'block';
            }
        }
        
        // Insertar variable en la fórmula
        function insertVariable(variable) {
            const formulaInput = document.getElementById('formula');
            const start = formulaInput.selectionStart;
            const end = formulaInput.selectionEnd;
            const text = formulaInput.value;
            
            formulaInput.value = text.substring(0, start) + variable + text.substring(end);
            formulaInput.focus();
            formulaInput.setSelectionRange(start + variable.length, start + variable.length);
        }
        
        // Confirmar eliminación
        function confirmDelete() {
            if (confirm('¿Estás seguro de eliminar este bloque? Esta acción no se puede deshacer.')) {
                document.getElementById('delete-form').submit();
            }
        }
        
        // Inicializar al cargar
        document.addEventListener('DOMContentLoaded', function() {
            updateFormFields();
        });
   
    let rowIndex = 1;

    function addRow() {
        const container = document.getElementById('dynamic-fields');

        const row = document.createElement('div');
        row.classList.add('flex', 'items-center', 'gap-2', 'dynamic-row');

        row.innerHTML = `
            <input type="text"
                   name="extras[${rowIndex}][key]"
                   placeholder="Etiqueta"
                   class="flex-1 border-gray-300 rounded-md shadow-sm text-sm">

            <input type="text"
                   name="extras[${rowIndex}][value]"
                   placeholder="Valor"
                   class="flex-1 border-gray-300 rounded-md shadow-sm text-sm">

            <button type="button"
                    onclick="addRow()"
                    class="p-2 bg-green-600 text-white rounded hover:bg-green-700">
                +
            </button>

            <button type="button"
                    onclick="removeRow(this)"
                    class="p-2 bg-red-600 text-white rounded hover:bg-red-700">
                🗑
            </button>
        `;

        container.appendChild(row);
        rowIndex++;
    }

    function removeRow(button) {
        const row = button.closest('.dynamic-row');
        row.remove();
    }
</script>

    
    @push('styles')
    <style>
        .required:after {
            content: " *";
            color: #dc2626;
        }
        .config-section {
            transition: all 0.3s ease;
        }
        .cursor-pointer {
            cursor: pointer;
        }
    </style>
    @endpush
</x-app-layout>