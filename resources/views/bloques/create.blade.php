<x-app-layout>
    <div class="py-6">
        <div class="max-w-4xl mx-auto px-4">
            
            <!-- Header limpio -->
            <div class="mb-8">
                <div class="flex items-center justify-between mb-4">
                    <a href="{{ route('bloques.index') }}" 
                       class="text-sm text-blue-600 hover:text-blue-800 flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Volver a Bloques
                    </a>
                </div>
                
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">
                            Crear nuevo bloque de cotización
                        </h1>
                        <p class="text-gray-500 mt-1">
                            Configura un nuevo bloque para usar en las cotizaciones
                        </p>
                    </div>
                </div>
            </div>

            <!-- Errores mejorados -->
            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                    <div class="flex items-center gap-2 text-red-700 mb-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        <span class="font-medium">Corrige los siguientes errores:</span>
                    </div>
                    <ul class="list-disc list-inside text-red-600 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Formulario principal -->
            <form method="POST" action="{{ route('bloques.store') }}">
                @csrf

                <!-- Información básica -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4 pb-2 border-b border-gray-100">
                        Información básica
                    </h2>
                    
                    <div class="space-y-6">
                        <!-- Nombre -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                Nombre del bloque *
                            </label>
                            <input
                                type="text"
                                id="name"
                                name="name"
                                value="{{ old('name') }}"
                                required
                                placeholder="Ej: Curso de Ofimática Avanzada"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:ring-opacity-50 transition-colors text-sm"
                            >
                        </div>

                        <!-- Descripción -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                Descripción
                            </label>
                            <textarea
                                id="description"
                                name="description"
                                rows="3"
                                placeholder="Describe brevemente este bloque de servicio..."
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:ring-opacity-50 transition-colors text-sm"
                            >{{ old('description') }}</textarea>
                        </div>

                        <!-- Categoría -->
                        <div>
                            <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Categoría *
                            </label>
                            <select
                                id="category_id"
                                name="category_id"
                                required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:ring-opacity-50 transition-colors text-sm"
                            >
                                <option value="">Selecciona una categoría</option>
                                @foreach ($categories as $category)
                                    <option
                                        value="{{ $category->id }}"
                                        {{ old('category_id') == $category->id ? 'selected' : '' }}
                                    >
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Precio base y Horas -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="base_price" class="block text-sm font-medium text-gray-700 mb-2">
                                    Precio base ($ MXN) *
                                </label>
                                <div class="relative">
                                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">$</span>
                                    <input
                                        type="number"
                                        id="base_price"
                                        name="base_price"
                                        value="{{ old('base_price', 0) }}"
                                        required
                                        min="0"
                                        step="0.01"
                                        class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:ring-opacity-50 transition-colors text-sm"
                                    >
                                </div>
                            </div>

                            <div>
                                <label for="default_hours" class="block text-sm font-medium text-gray-700 mb-2">
                                    Horas por defecto *
                                </label>
                                <input
                                    type="number"
                                    id="default_hours"
                                    name="default_hours"
                                    value="{{ old('default_hours', 1) }}"
                                    required
                                    min="0"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:ring-opacity-50 transition-colors text-sm"
                                >
                            </div>
                        </div>

                        <!-- Orden -->
                        <div>
                            <label for="order" class="block text-sm font-medium text-gray-700 mb-2">
                                Orden de aparición
                            </label>
                            <input
                                type="number"
                                id="order"
                                name="order"
                                value="{{ old('order', 0) }}"
                                min="0"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:ring-opacity-50 transition-colors text-sm"
                            >
                        </div>

                        <!-- Activo -->
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
                    <div class="flex items-center justify-between mb-4 pb-2 border-b border-gray-100">
                        <h2 class="text-lg font-semibold text-gray-900">
                            Extras / Configuración
                        </h2>
                        <span class="text-xs text-gray-500">Opcional</span>
                    </div>
                    
                    <p class="text-sm text-gray-600 mb-4">
                        Agrega campos adicionales personalizados para este bloque.
                    </p>

                    <div id="extras-container" class="space-y-3 mb-4">
                        <!-- Fila inicial se generará con JavaScript -->
                    </div>

                    <button
                        type="button"
                        onclick="addExtra()"
                        class="w-full py-2 border-2 border-dashed border-gray-300 rounded-lg hover:border-blue-400 hover:bg-blue-50 transition-colors text-sm text-gray-600 hover:text-blue-700 flex items-center justify-center gap-2"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Agregar campo extra
                    </button>
                </div>

                <!-- Botones de acción -->
                <div class="flex justify-between items-center mt-6 pt-6 border-t border-gray-200">
                    <a href="{{ route('bloques.index') }}" 
                       class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors text-sm font-medium flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Cancelar
                    </a>
                    
                    <button
                        type="submit"
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium flex items-center gap-2 shadow-sm hover:shadow"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Guardar bloque
                    </button>
                </div>
            </form>
        </div>
    </div>

   <!-- ESTE DIV VA EN TU VISTA .blade.php -->
<script>
    let extraIndex = 0;

    function addExtra(key = '', value = '') {
        const container = document.getElementById('extras-container');

        const row = document.createElement('div');
        row.className = 'flex items-center gap-2 group';
        row.dataset.rowIndex = extraIndex;

        row.innerHTML = `
            <input
                type="text"
                name="extras[${extraIndex}][key]"
                value="${key}"
                placeholder="Etiqueta (ej: Duración, Materiales, etc.)"
                class="flex-1 px-3 py-2 border border-gray-300 rounded-lg text-sm"
            >
            <input
                type="text"
                name="extras[${extraIndex}][value]"
                value="${value}"
                placeholder="Valor (ej: 30 días, Incluidos, etc.)"
                class="flex-1 px-3 py-2 border border-gray-300 rounded-lg text-sm"
            >
            <button
                type="button"
                onclick="removeExtra(this)"
                class="px-3 py-2 bg-gray-100 text-gray-500 rounded-lg hover:bg-red-50 hover:text-red-600 opacity-0 group-hover:opacity-100"
                title="Eliminar campo"
            >
                ✕
            </button>
        `;

        container.appendChild(row);
        extraIndex++;
    }

    function removeExtra(button) {
        const row = button.closest('[data-row-index]');
        if (!row) return;

        row.remove();

        const rows = document.querySelectorAll('#extras-container [data-row-index]');
        rows.forEach((row, index) => {
            row.dataset.rowIndex = index;

            const keyInput = row.querySelector('input[name$="[key]"]');
            const valueInput = row.querySelector('input[name$="[value]"]');

            if (keyInput) keyInput.name = `extras[${index}][key]`;
            if (valueInput) valueInput.name = `extras[${index}][value]`;
        });

        extraIndex = rows.length;
    }

    document.addEventListener('DOMContentLoaded', () => {
        const dataEl = document.getElementById('extras-data');
        const oldExtras = dataEl
            ? JSON.parse(dataEl.dataset.extras || '[]')
            : [];

        if (oldExtras.length > 0) {
            oldExtras.forEach(extra => {
                addExtra(extra.key ?? '', extra.value ?? '');
            });
        } else {
            addExtra();
        }
    });
</script>


</x-app-layout>