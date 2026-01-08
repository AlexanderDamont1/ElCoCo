<x-app-layout>

@if(session('success'))
<div class="fixed top-6 left-1/2 transform -translate-x-1/2 z-50"
     x-data="{ show: true }"
     x-show="show"
     x-init="setTimeout(() => show = false, 3000)">
    <div class="bg-white shadow-xl ring-1 ring-gray-200 rounded-lg px-4 py-3 flex items-center gap-3">
        <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
        </svg>
        <span class="text-sm font-medium">{{ session('success') }}</span>
    </div>
</div>
@endif

<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">

                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold">Cotizaciones</h1>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">

                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Referencia</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cliente</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Bloques</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Acciones</th>
                            </tr>
                        </thead>

                        <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($quotes as $quote)
                            <tr class="hover:bg-gray-50">

                                <td class="px-6 py-4 text-sm font-mono">
                                    {{ $quote->reference }}
                                </td>

                                <td class="px-6 py-4 text-sm">
                                    <div class="font-medium">{{ $quote->client_name }}</div>
                                    <div class="text-gray-500 text-xs">{{ $quote->client_email }}</div>
                                </td>

                                <td class="px-6 py-4 text-sm font-semibold">
                                    ${{ number_format($quote->total,2) }}
                                </td>

                                <td class="px-6 py-4 text-sm">
                                    {{ $quote->items_count }}
                                </td>

                                <td class="px-6 py-4 text-sm">
                                    <span class="px-2 py-1 rounded text-xs
                                        @if($quote->status==='sent') bg-blue-100 text-blue-800
                                        @elseif($quote->status==='draft') bg-gray-100 text-gray-700
                                        @elseif($quote->status==='approved') bg-green-100 text-green-800
                                        @elseif($quote->status==='rejected') bg-red-100 text-red-800
                                        @endif">
                                        {{ strtoupper($quote->status) }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 text-xs text-gray-500">
                                    {{ $quote->created_at->format('d/m/Y H:i') }}
                                </td>

                                <td class="px-6 py-4 text-right text-sm font-medium">
                                    <a href="{{ route('admin.quotes.show', $quote) }}"
                                       class="text-blue-600 hover:underline">
                                        Ver
                                    </a>
                                </td>

                            </tr>
                        @endforeach
                        </tbody>

                    </table>
                </div>

                <div class="mt-4">
                    {{ $quotes->links() }}
                </div>

            </div>
        </div>

    </div>
</div>
</x-app-layout>
