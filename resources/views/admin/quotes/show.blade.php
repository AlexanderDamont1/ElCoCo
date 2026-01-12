<x-app-layout>


    <div class="py-6">
        <div class="max-w-4xl mx-auto px-4">


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


@error('message')
    <div class="fixed top-6 left-1/2 transform -translate-x-1/2 z-50 animate-fade-in" 
         x-data="{ show: true }" 
         x-show="show" 
         x-init="setTimeout(() => show = false, 3000)"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-end="opacity-0 translate-y-2">
        <div class="flex items-center gap-3 rounded-lg bg-white p-4 shadow-xl ring-1 ring-red-200 min-w-[300px] max-w-md">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="flex-1">
                <p class="text-sm font-medium text-gray-900">{{ $message }}</p>
            </div>
            <button @click="show = false" 
                    class="flex-shrink-0 text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>
@enderror


            <!-- Header limpio -->
            <div class="mb-8">
                <div class="flex items-center justify-between mb-4">
                    <a href="{{ route('admin.quotes.index') }}" 
                       class="text-sm text-blue-600 hover:text-blue-800">
                        ← Cotizaciones
                    </a>
                    
                    
                </div>
                
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">{{ $quote->reference }}</h1>
                        <p class="text-gray-500 mt-1">{{ $quote->created_at->format('d/m/Y') }}</p>
                    </div>
                    
                    <div class="text-right">
                        <div class="text-xl font-bold text-gray-900">${{ number_format($quote->total, 2) }}</div>
                        <div class="mt-1">
                            @php
                                $statusBadge = [
                                    'draft' => 'bg-gray-200 text-gray-800',
                                    'sent' => 'bg-blue-100 text-blue-800',
                                    'approved' => 'bg-green-100 text-green-800',
                                    'rejected' => 'bg-red-100 text-red-800'
                                ];
                            @endphp
                            <span class="text-xs font-medium px-2 py-1 rounded {{ $statusBadge[$quote->status] ?? 'bg-gray-200' }}">
                                {{ strtoupper($quote->status) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cliente - Diseño limpio -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Cliente</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Nombre</p>
                        <p class="font-medium">{{ $quote->client_name }}</p>
                    </div>
                    
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Email</p>
                        <p class="font-medium">{{ $quote->client_email }}</p>
                    </div>
                    
                    @if($quote->client_company)
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Empresa</p>
                        <p class="font-medium">{{ $quote->client_company }}</p>
                    </div>
                    @endif
                    
                    @if($quote->client_phone)
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Teléfono</p>
                        <p class="font-medium">{{ $quote->client_phone }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Bloques de trabajo - Tabla simple -->
            @if($quote->items && $quote->items->count() > 0)
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden mb-6">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Servicios</h2>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Descripción</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Horas</th>
                                <th class="px6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Precio</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                            </tr>
                        </thead>
                        
                        <tbody class="divide-y divide-gray-200">
                            @foreach($quote->items as $item)
                            <tr>
                                <td class="px-6 py-4">
                                    <div class="font-medium text-gray-900">{{ $item->name }}</div>
                                    @if($item->description)
                                    <div class="text-sm text-gray-500 mt-1">{{ $item->description }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-gray-900">{{ $item->hours }}</td>
                                <td class="px-6 py-4 text-gray-900">${{ number_format($item->unit_price, 2) }}</td>
                                <td class="px-6 py-4 font-medium text-gray-900">${{ number_format($item->total_price, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        
                        <tfoot class="bg-gray-50">
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-right text-sm font-medium text-gray-700">
                                    Subtotal
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-900">
                                    ${{ number_format($quote->items->sum('total_price'), 2) }}
                                </td>
                            </tr>
                            
                            @if($quote->tax > 0)
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-right text-sm font-medium text-gray-700">
                                    Impuestos ({{ $quote->tax_rate ?? 16 }}%)
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-900">
                                    ${{ number_format($quote->tax, 2) }}
                                </td>
                            </tr>
                            @endif
                            
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-right text-lg font-bold text-gray-900">
                                    Total
                                </td>
                                <td class="px-6 py-4 text-lg font-bold text-gray-900">
                                    ${{ number_format($quote->total, 2) }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            @endif

           <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">
                    Historial de mensajes
                </h2>

                <div class="space-y-4">
                    @forelse($quote->replies as $reply)
                        <div class="border border-gray-200 rounded p-4">
                            <div class="text-sm text-gray-500 mb-2">
                                Enviado el {{ $reply->sent_at->format('d/m/Y H:i') }}
                                
                            </div>

                            <p class="text-gray-900 whitespace-pre-line">
                                {{ $reply->message }}
                            </p>
                        </div>
                    @empty
                        <div class="text-sm text-gray-500 italic text-center py-6">
                            Aún no hay mensajes
                        </div>
                    @endforelse
                </div>
            </div>



           <!-- Responder cotización -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">
                Responder al cliente
            </h2>

            <form 
                action="{{ route('admin.quotes.reply', $quote->id) }}" 
                method="POST"
                class="space-y-4"
            >
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Mensaje
                    </label>
                    <textarea
                        name="message"
                        rows="4"
                        required
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        placeholder="Escribe aquí tu respuesta para el/la cliente…"
                    >{{ old('message') }}</textarea>

                    
                </div>

                <div class="flex justify-end">
                    <button
                        type="submit"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700"
                    >
                        Enviar respuesta por correo
                    </button>
                </div>
            </form>
        </div>


        </div>
    </div>
</x-app-layout>