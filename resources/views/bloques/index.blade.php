<x-app-layout>
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


    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-bold text-gray-900">Bloques de Cotizacióoon</h1>
                        <a href="#" 
                           class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                            + Nuevo Bloque
                        </a>
                    </div>

                   

                    @foreach($categories as $category)
                        <div class="mb-6 bg-white rounded-lg shadow overflow-hidden">
                            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200 flex justify-between items-center">
                                <div class="flex items-center">
                                    <span class="font-semibold text-gray-900">{{ $category->name }}</span>
                                    @if(!$category->is_active)
                                        <span class="ml-2 px-2 py-1 text-xs font-medium bg-gray-100 text-gray-800 rounded">
                                            inactiva
                                        </span>
                                    @endif
                                </div>
                                <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded">
                                    {{ $category->blocks->count() }} bloques
                                </span>
                            </div>

                            @if($category->description)
                                <div class="px-6 py-4 border-b border-gray-200">
                                    <p class="text-gray-600">{{ $category->description }}</p>
                                </div>
                            @endif

                            @if($category->blocks->count())
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Nombre
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Tipo
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Precio base
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Horas por default
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Acciones
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach($category->blocks as $block)
                                                <tr class="hover:bg-gray-50">
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                        {{ $block->name }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                        {{ $block->type }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                        ${{ number_format($block->base_price, 2) }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                        {{ $block->default_hours }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                        <div class="flex justify-end space-x-2">
                                                            <a href="{{ route('bloques.edit', $block) }}" 
                                                               class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                                Editar
                                                            </a>
                                                            <form action="#" 
                                                                  method="POST" 
                                                                  class="inline"
                                                                  onsubmit="return confirm('¿Estás seguro de eliminar este bloque?')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" 
                                                                        class="inline-flex items-center px-3 py-1.5 border border-red-300 shadow-sm text-xs font-medium rounded text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
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
                                <div class="px-6 py-8 text-center">
                                    <p class="text-gray-500">No existen bloques en esta categoría</p>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    @push('styles')
    <style>
        /* Estilos adicionales para mejorar la visualización */
        .hover\:bg-gray-50:hover {
            background-color: #f9fafb;
        }
    </style>
    @endpush


    
</x-app-layout>