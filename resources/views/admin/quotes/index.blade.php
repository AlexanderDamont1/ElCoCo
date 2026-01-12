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
                        <h1 class="text-3xl font-bold text-gray-900">Gestión de Cotizaciones</h1>
                        <p class="mt-2 text-gray-600">Visualiza y gestiona todas las cotizaciones del sistema</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="hidden sm:flex items-center gap-2 bg-white px-4 py-2 rounded-lg border border-gray-200">
                            <span class="text-sm text-gray-500">Total:</span>
                            <span class="font-semibold text-gray-900">{{ $quotes->total() }}</span>
                            <span class="text-gray-400">|</span>
                            <span class="text-sm text-gray-500">Mostrando:</span>
                            <span class="font-medium text-gray-900">{{ $quotes->count() }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tarjeta principal -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">

                <!-- Tabla -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr class="bg-gray-50/80">
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    <div class="flex items-center gap-1">
                                        Referencia
                                        <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                        </svg>
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Cliente
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Total
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Bloques
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Estado
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Fecha
                                </th>
                                <th class="px-6 py-4 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        
                        <tbody class="divide-y divide-gray-100">
                            @forelse($quotes as $quote)
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="ml-0">
                                                <div class="font-mono text-sm font-semibold text-gray-900">
                                                    {{ $quote->reference }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $quote->client_name }}</div>
                                        <div class="text-xs text-gray-500 truncate max-w-[180px]">{{ $quote->client_email }}</div>
                                    </td>
                                    
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-bold text-gray-900">${{ number_format($quote->total, 2) }}</div>
                                    </td>
                                    
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700">
                                                {{ $quote->items_count }} bloques
                                            </span>
                                        </div>
                                    </td>
                                    
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $statusConfig = [
                                                'draft' => ['bg-gray-100 text-gray-800', 'Borrador'],
                                                'sent' => ['bg-blue-100 text-blue-800', 'Enviado'],
                                                'approved' => ['bg-green-100 text-green-800', 'Aprobado'],
                                                'rejected' => ['bg-red-100 text-red-800', 'Rechazado']
                                            ];
                                            [$bgClass, $label] = $statusConfig[$quote->status] ?? ['bg-gray-100 text-gray-800', $quote->status];
                                        @endphp
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $bgClass }}">
                                            {{ ucfirst($label) }}
                                        </span>
                                    </td>
                                    
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <div>{{ $quote->created_at->format('d/m/Y') }}</div>
                                        <div class="text-xs">{{ $quote->created_at->format('H:i') }}</div>
                                    </td>
                                    
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('admin.quotes.show', $quote) }}"
                                               class="inline-flex items-center gap-1 px-3 py-1.5 rounded-md bg-white text-gray-700 hover:bg-gray-100 border border-gray-300 hover:border-gray-400 transition-colors text-xs font-medium">
                                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                                Ver
                                            </a>
                                            <button class="inline-flex items-center gap-1 px-3 py-1.5 rounded-md bg-white text-gray-700 hover:bg-gray-100 border border-gray-300 hover:border-gray-400 transition-colors text-xs font-medium">
                                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                                                </svg>
                                                PDF
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center text-gray-400">
                                            <svg class="h-12 w-12 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            <h3 class="text-lg font-medium text-gray-900 mb-1">No hay cotizaciones</h3>
                                            <p class="text-gray-500">No se encontraron cotizaciones en el sistema</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pie de tabla con paginación -->
                <div class="px-6 py-4 border-t border-gray-200 bg-gray-50/50">
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div class="text-sm text-gray-500">
                            Mostrando {{ $quotes->firstItem() ?? 0 }} - {{ $quotes->lastItem() ?? 0 }} de {{ $quotes->total() }} registros
                        </div>
                        <div class="flex items-center gap-2">
                            {{ $quotes->links() }}
                        </div>
                    </div>
                </div>

            </div>

            <!-- Información adicional -->
            <div class="mt-6 text-sm text-gray-500 text-center">
                <p>Las cotizaciones se actualizan automáticamente y pueden ser exportadas en formato PDF</p>
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