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


    <div class="min-h-screen bg-gray-50">
        <div class="py-8">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

                {{-- Header --}}
                <div class="mb-8">
                    <a href="{{ route('admin.quotes.index') }}"
                       class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900 mb-4">
                        ← Cotizaciones
                    </a>

                    <div class="flex justify-between items-center">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">
                                {{ $quote->reference }}
                            </h1>
                            <p class="text-sm text-gray-500">
                                {{ $quote->created_at->format('d/m/Y') }}
                            </p>
                        </div>

                        <div class="text-right">
                            <p class="text-2xl font-bold text-gray-900">
                                ${{ number_format($quote->total, 2) }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                    {{-- Columna izquierda --}}
                    <div class="space-y-6">

                        {{-- Cliente --}}
                        <div class="bg-white rounded-xl border p-5">
                            <h2 class="font-semibold mb-4">Información del cliente</h2>

                            <div class="space-y-3 text-sm">
                                <p><strong>Nombre:</strong> {{ $quote->client_name }}</p>
                                <p><strong>Email:</strong> {{ $quote->client_email }}</p>
                                <p><strong>Telefono:</strong> {{ $quote->client_phone }}</p>

                                @if($quote->client_company)
                                    <p><strong>Empresa:</strong> {{ $quote->client_company }}</p>
                                @endif
                            </div>

                            
                        </div>

                       
                    </div>

                    {{-- Columna derecha --}}
                    <div class="lg:col-span-2 space-y-6">

                        {{-- Servicios --}}
                        @if($quote->items->count())
                            <div class="bg-white rounded-xl border overflow-hidden">
                                <table class="w-full text-sm">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-4 py-2 text-left">Descripción</th>
                                            <th class="px-4 py-2">Horas</th>
                                            <th class="px-4 py-2">Precio</th>
                                            <th class="px-4 py-2">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($quote->items as $item)
                                            <tr class="border-t">
                                                <td class="px-4 py-2">
                                                    <p class="font-medium">{{ $item->name }}</p>
                                                    @if($item->description)
                                                        <p class="text-xs text-gray-500">
                                                            {{ $item->description }}
                                                        </p>
                                                    @endif
                                                </td>
                                                <td class="px-4 py-2 text-center">
                                                    {{ $item->hours }}
                                                </td>
                                                <td class="px-4 py-2 text-right">
                                                    ${{ number_format($item->unit_price, 2) }}
                                                </td>
                                                <td class="px-4 py-2 text-right font-semibold">
                                                    ${{ number_format($item->total_price, 2) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif

                        {{-- Responder --}}
                        <div
                            class="bg-white rounded-xl border p-6"
                            x-data="{ message: @js(old('message', '')) }"
                        >
                            <h2 class="text-lg font-semibold mb-4">
                                Responder al cliente
                            </h2>

                            <form action="{{ route('admin.quotes.reply', $quote->id) }}" method="POST" class="space-y-6">
                                @csrf

                                {{-- Textarea --}}
                               <div>
                                    <label class="block text-sm font-medium mb-2">
                                        Fecha de la cita virtual
                                    </label>

                                    <input
                                        type="datetime-local"
                                        name="meeting_date"
                                        required
                                        x-model="message"
                                        class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-100"
                                        placeholder="Selecciona la fecha y hora de la cita"
                                    />
                                </div>

                                <div class="bg-gray-50 border rounded-lg p-4">
                                    <p class="text-xs font-semibold text-gray-500 uppercase mb-3">
                                        Vista previa del correo
                                    </p>

                                    <div class="space-y-4 text-sm text-gray-700">
                                        <p>
                                            Hola <strong>{{ $quote->client_name }}</strong>,
                                        </p>

                                        <p>
                                            Esperamos que te encuentres muy bien. Te compartimos la cotización solicitada en formato PDF,
                                            donde podrás revisar a detalle los servicios considerados y los importes correspondientes.
                                        </p>

                                        <p x-text="message ? `Cita Virtual en GoogleMeet para Conversar detalles del trabajo: ${new Date(message).toLocaleString()}` : 'Aquí aparecerá la fecha de la cita…'"></p>


                                        <p>
                                            <strong>Total cotizado:</strong>
                                            ${{ number_format($quote->total, 2) }}
                                        </p>

                                        <p>
                                            El archivo PDF adjunto contiene la información completa de la cotización.
                                            Si tienes alguna duda o requieres algún ajuste, quedamos atentes para apoyarte.
                                        </p>

                                        <p>
                                            Saludos cordiales,<br>
                                            <strong>Equipo de Ventas</strong>
                                        </p>
                                    </div>
                                </div>


                                {{-- Botón --}}
                                <div class="flex justify-end">
                                    <button
                                        type="submit"
                                        class="px-5 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700"
                                    >
                                        Enviar respuesta por correo
                                    </button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
