<x-app-layout>
    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header mejorado -->
            <div class="mb-8">
                <a href="{{ route('bloques.index') }}"
                   class="inline-flex items-center text-sm text-blue-600 hover:text-blue-800 transition-colors mb-4">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Volver a Bloques
                </a>

                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-900">
                            {{ isset($quoteBlock) ? 'Editar Bloque' : 'Crear Nuevo Bloque' }}
                        </h1>
                        <p class="text-gray-600 mt-1 text-sm">
                            {{ isset($quoteBlock) ? 'Modifica la información del bloque' : 'Configura un nuevo bloque para cotizaciones' }}
                        </p>
                    </div>
                </div>
            </div>

            <form
                action="{{ isset($quoteBlock) ? route('bloques.update', $quoteBlock) : route('bloques.store') }}"
                method="POST"
                class="space-y-6"
            >
                @csrf
                @isset($quoteBlock)
                    @method('PUT')
                @endisset

                <!-- Información básica -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-6">
                    <h2 class="text-lg font-semibold text-gray-900 pb-2 border-b border-gray-100">
                        Información básica
                    </h2>

                    <div class="space-y-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Nombre del bloque *
                            </label>
                            <input
                                type="text"
                                name="name"
                                placeholder="Ej: Curso de Ofimática Avanzada"
                                class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-colors text-sm"
                                value="{{ old('name', $quoteBlock->name ?? '') }}"
                                required
                            >
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Descripción
                            </label>
                            <textarea
                                name="description"
                                placeholder="Describe brevemente este bloque de servicio..."
                                class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-colors text-sm"
                                rows="3"
                            >{{ old('description', $quoteBlock->description ?? '') }}</textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Categoría *
                                </label>
                                <select
                                    name="category_id"
                                    class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-colors text-sm"
                                    required
                                >
                                    <option value="">Selecciona una categoría</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('category_id', $quoteBlock->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Orden de aparición
                                </label>
                                <input
                                    type="number"
                                    name="order"
                                    min="0"
                                    class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-colors text-sm"
                                    placeholder="0"
                                    value="{{ old('order', $quoteBlock->order ?? 0) }}"
                                >
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Precio base ($ MXN) *
                                </label>
                                <div class="relative">
                                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">$</span>
                                    <input
                                        type="number"
                                        name="base_price"
                                        min="0"
                                        step="0.01"
                                        class="w-full pl-8 pr-3 py-2.5 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-colors text-sm"
                                        placeholder="0.00"
                                        value="{{ old('base_price', $quoteBlock->base_price ?? 0) }}"
                                        required
                                    >
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Horas por defecto *
                                </label>
                                <input
                                    type="number"
                                    name="default_hours"
                                    min="0"
                                    class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-colors text-sm"
                                    placeholder="0"
                                    value="{{ old('default_hours', $quoteBlock->default_hours ?? 0) }}"
                                    required
                                >
                            </div>
                        </div>

                        <div class="flex items-center pt-2">
                            <div class="relative">
                                <input
                                    type="checkbox"
                                    id="is_active"
                                    name="is_active"
                                    value="1"
                                    {{ old('is_active', $quoteBlock->is_active ?? true) ? 'checked' : '' }}
                                    class="sr-only peer"
                                >
                                <div class="w-10 h-5 bg-gray-300 peer-focus:ring-2 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-blue-600"></div>
                            </div>
                            <label for="is_active" class="ml-3 text-sm text-gray-700 cursor-pointer">
                                Bloque activo
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Extras / Configuración -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between mb-4 pb-3 border-b border-gray-100">
                        <h2 class="text-lg font-semibold text-gray-900">
                            Extras / Configuración
                        </h2>
                        <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded">Opcional</span>
                    </div>

                    <div id="extras-container" class="space-y-3 mb-4"></div>

                    <button
                        type="button"
                        onclick="addExtra()"
                        class="w-full py-3 border-2 border-dashed border-gray-300 rounded-lg hover:border-blue-400 hover:bg-blue-50 transition-colors text-sm text-gray-600 hover:text-blue-700 flex items-center justify-center gap-2"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Agregar campo extra
                    </button>
                </div>

                <!-- Botón de acción -->
                <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                    <a href="{{ route('bloques.index') }}"
                       class="px-4 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors text-sm font-medium inline-flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Cancelar
                    </a>

                    <button
                        type="submit"
                        class="px-6 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium shadow-sm hover:shadow inline-flex items-center gap-2"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        {{ isset($quoteBlock) ? 'Actualizar Bloque' : 'Crear Bloque' }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Datos de extras desde backend -->
    <div
        id="extras-data"
        data-extras='@json(old("extras", $quoteBlock->config ?? []))'
        class="hidden">
    </div>

    <script>
        let extraIndex = 0;

        function addExtra(key = '', value = '') {
            const container = document.getElementById('extras-container');
            
            const row = document.createElement('div');
            row.className = 'flex items-center gap-2 group';
            row.setAttribute('data-row-index', extraIndex);

            row.innerHTML = `
                <input
                    type="text"
                    name="extras[${extraIndex}][key]"
                    value="${key}"
                    placeholder="Etiqueta (ej: Duración, Materiales)"
                    class="flex-1 px-3 py-2.5 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-colors text-sm"
                >
                <input
                    type="text"
                    name="extras[${extraIndex}][value]"
                    value="${value}"
                    placeholder="Valor (ej: 30 días, Incluidos)"
                    class="flex-1 px-3 py-2.5 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-colors text-sm"
                >
                <button 
                    type="button" 
                    onclick="removeExtra(this)"
                    class="px-3 py-2.5 bg-gray-100 text-gray-500 rounded-lg hover:bg-red-50 hover:text-red-600 transition-colors opacity-0 group-hover:opacity-100"
                    title="Eliminar campo"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            `;

            container.appendChild(row);
            
            // Enfocar el primer input si está vacío
            if (!key) {
                row.querySelector('input[name^="extras"]').focus();
            }
            
            extraIndex++;
        }

        function removeExtra(button) {
            const row = button.closest('[data-row-index]');
            if (row) {
                row.remove();
                
                // Re-indexar las filas restantes
                const rows = document.querySelectorAll('#extras-container [data-row-index]');
                rows.forEach((row, index) => {
                    row.setAttribute('data-row-index', index);
                    const keyInput = row.querySelector('input[name^="extras"]');
                    const valueInput = row.querySelector('input[name$="[value]"]');
                    
                    if (keyInput && valueInput) {
                        keyInput.name = `extras[${index}][key]`;
                        valueInput.name = `extras[${index}][value]`;
                    }
                });
                
                extraIndex = rows.length;
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            const raw = document.getElementById('extras-data').dataset.extras;
            const extras = JSON.parse(raw);

            if (extras && extras.length) {
                extras.forEach(item => {
                    const key = Object.keys(item)[0];
                    addExtra(key, item[key]);
                });
            } else {
                addExtra();
            }
        });
    </script>
</x-app-layout>