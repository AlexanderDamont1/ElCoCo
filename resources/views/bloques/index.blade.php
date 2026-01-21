<x-app-layout>
    <!-- Notificación de éxito mejorada -->
   @if(session('success'))
    <div class="fixed top-6 left-1/2 transform -translate-x-1/2 z-50 animate-fade-in" 
         x-data="{ show: true }" 
         x-show="show" 
         x-init="setTimeout(() => show = false, 3000)"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-end="opacity-0 translate-y-2">
        <div class="flex items-center gap-3 rounded-lg bg-white p-4 shadow-xl ring-1 ring-gray-200 min-w-[300px] max-w-md">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="flex-1">
                <p class="text-sm font-medium text-gray-900">{{ session('success') }}</p>
            </div>
            <button @click="show = false" 
                    class="flex-shrink-0 text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>
@endif

    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header con estadísticas -->
            <div class="mb-8">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Gestión de Bloques</h1>
                        <p class="mt-2 text-gray-600">Administra los bloques de cotización del sistema</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="hidden sm:flex items-center gap-2 bg-white px-4 py-2 rounded-lg border border-gray-200">
                            <span class="text-sm text-gray-500">Categorías:</span>
                            <span class="font-semibold text-gray-900">{{ $categories->count() }}</span>
                            <span class="text-gray-400">|</span>
                            <span class="text-sm text-gray-500">Bloques:</span>
                            <span class="font-medium text-gray-900">{{ $categories->sum('blocks_count') }}</span>
                        </div>
                        <a href="{{ route('bloques.create') }}" 
                           class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium shadow-sm">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Nuevo Bloque
                        </a>
                    </div>
                </div>
            </div>

            <!-- Tarjetas de categorías -->
            @foreach($categories as $category)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
                
                <!-- Encabezado de categoría -->
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50/50">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div>
                            <div class="flex items-center gap-2">
                                <h2 class="text-lg font-semibold text-gray-900">{{ $category->name }}</h2>
                                @if(!$category->is_active)
                                    <span class="px-2 py-1 rounded text-xs font-medium bg-gray-100 text-gray-700">
                                        inactiva
                                    </span>
                                @endif
                            </div>
                            @if($category->description)
                                <p class="mt-1 text-sm text-gray-600">{{ $category->description }}</p>
                            @endif
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700">
                                {{ $category->blocks->count() }} bloques
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Tabla de bloques -->
                @if($category->blocks->count())
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr class="bg-gray-50/80">
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Nombre
                                </th>
                                
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Precio Base
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Horas Default
                                </th>
                                <th class="px-6 py-4 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        
                        <tbody class="divide-y divide-gray-100">
                            @foreach($category->blocks as $block)
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $block->name }}</div>
                                    </td>
                                    
                                   
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-semibold text-gray-900">${{ number_format($block->base_price, 2) }}</div>
                                    </td>
                                    
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $block->default_hours }}</div>
                                    </td>
                                    
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('bloques.edit', $block) }}"
                                               class="inline-flex items-center gap-1 px-3 py-1.5 rounded-md bg-white text-gray-700 hover:bg-gray-100 border border-gray-300 hover:border-gray-400 transition-colors text-xs font-medium">
                                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                                Editar
                                            </a>
                                            <form action="#" 
                                                  method="POST" 
                                                  class="inline"
                                                  onsubmit="return confirm('¿Estás seguro de eliminar este bloque?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="inline-flex items-center gap-1 px-3 py-1.5 rounded-md bg-white text-red-600 hover:bg-red-50 border border-red-200 hover:border-red-300 transition-colors text-xs font-medium">
                                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                    Eliminar
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="px-6 py-12 text-center">
                    <div class="flex flex-col items-center justify-center text-gray-400">
                        <svg class="h-12 w-12 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 mb-1">No hay bloques</h3>
                        <p class="text-gray-500">No existen bloques en esta categoría</p>
                    </div>
                </div>
                @endif

            </div>
            @endforeach

            <!-- Información adicional -->
            <div class="mt-6 text-sm text-gray-500 text-center">
                <p>Los bloques se utilizan para crear cotizaciones personalizadas para los clientes</p>
            </div>

        </div>
    </div>

    <!-- Estilos adicionales -->
    <style>
        .animate-fade-in {
            animation: fadeIn 0.3s ease-out;
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translate(-50%, -10px);
            }
            to {
                opacity: 1;
                transform: translate(-50%, 0);
            }
        }
    </style>
</x-app-layout>