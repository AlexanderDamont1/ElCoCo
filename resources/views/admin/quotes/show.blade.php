<x-app-layout>

<div class="py-6">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

        <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
            <div class="p-6 text-gray-900">

                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold">
                        Cotización {{ $quote->reference }}
                    </h1>

                    @if($quote->pdf_path)
                        <a href="{{ Storage::url($quote->pdf_path) }}" target="_blank"
                           class="inline-flex items-center px-4 py-2 bg-gray-800 text-white rounded hover:bg-black text-sm">
                            Ver PDF
                        </a>
                    @endif
                </div>

                <!-- Info cliente -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6 text-sm bg-gray-50 p-4 rounded">
                    <div><strong>Cliente:</strong> {{ $quote->client_name }}</div>
                    <div><strong>Email:</strong> {{ $quote->client_email }}</div>
                    <div><strong>Empresa:</strong> {{ $quote->client_company }}</div>
                    <div><strong>Tel:</strong> {{ $quote->client_phone }}</div>
                    <div><strong>Total:</strong> ${{ number_format($quote->total,2) }}</div>
                    <div><strong>Horas:</strong> {{ $quote->total_hours }}</div>
                    <div><strong>Status:</strong> {{ strtoupper($quote->status) }}</div>
                    <div><strong>Fecha:</strong> {{ $quote->created_at->format('d/m/Y H:i') }}</div>
                </div>

                <!-- Items -->
                <!-- <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">

                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Bloque</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Horas</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Unitario</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                            </tr>
                        </thead>

                        <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($quote->items as $item)
                            <tr>
                                <td class="px-6 py-4 text-sm">
                                    <div class="font-medium">{{ $item->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $item->description }}</div>
                                </td>
                                <td class="px-6 py-4 text-sm">{{ $item->hours }}</td>
                                <td class="px-6 py-4 text-sm">${{ number_format($item->unit_price,2) }}</td>
                                <td class="px-6 py-4 text-sm font-semibold">${{ number_format($item->total_price,2) }}</td>
                            </tr>
                        @endforeach
                        </tbody>

                    </table>
                </div> -->

            </div>
        </div>

    </div>
</div>
</x-app-layout>
