<x-app-layout>

    {{-- ── Toast de éxito ── --}}
    @if(session('success'))
        <div class="fixed top-6 left-1/2 -translate-x-1/2 z-50"
             x-data="{ show: true }"
             x-show="show"
             x-init="setTimeout(() => show = false, 3500)"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-end="opacity-0 translate-y-2">
            <div class="flex items-center gap-3 rounded-xl bg-white px-5 py-3.5 shadow-xl ring-1 ring-gray-200 min-w-[280px]">
                <div class="h-8 w-8 rounded-full bg-green-50 flex items-center justify-center flex-shrink-0">
                    <svg class="h-4 w-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <p class="text-sm font-medium text-gray-900 flex-1">{{ session('success') }}</p>
                <button @click="show = false" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    @endif

    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- ── Breadcrumb + header ── --}}
            <div class="mb-8">
                <a href="{{ route('admin.quotes.index') }}"
                   class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-gray-800 transition-colors mb-4">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Cotizaciones
                </a>

                <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                    <div>
                        <div class="flex items-center gap-3 flex-wrap">
                            <h1 class="text-2xl font-bold text-gray-900">{{ $quote->reference }}</h1>

                            {{-- Badge de estado --}}
                            @php
                                $badges = [
                                    'draft'    => 'bg-gray-100 text-gray-600',
                                    'sent'     => 'bg-blue-50 text-blue-700',
                                    'approved' => 'bg-green-50 text-green-700',
                                    'rejected' => 'bg-red-50 text-red-600',
                                ];
                                $labels = [
                                    'draft'    => 'Borrador',
                                    'sent'     => 'Enviada',
                                    'approved' => 'Aprobada',
                                    'rejected' => 'Rechazada',
                                ];
                            @endphp
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-medium {{ $badges[$quote->status] ?? 'bg-gray-100 text-gray-600' }}">
                                {{ $labels[$quote->status] ?? ucfirst($quote->status) }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-500 mt-1">
                            Creada el {{ $quote->created_at->format('d/m/Y \a \l\a\s H:i') }}
                            @if($quote->sent_at)
                                · Enviada {{ $quote->sent_at->diffForHumans() }}
                            @endif
                        </p>
                    </div>

                    {{-- Acciones --}}
                    <div class="flex items-center gap-2 flex-shrink-0 flex-wrap">
                        {{-- Botón PDF — ahora funciona --}}
                        <a href="{{ route('admin.quotes.pdf', $quote) }}"
                           target="_blank"
                           class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg bg-white text-gray-700 hover:bg-gray-50 border border-gray-200 hover:border-gray-300 transition-colors text-sm font-medium shadow-sm">
                            <svg class="h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-6 4h4"/>
                            </svg>
                            Descargar PDF
                        </a>

                        {{-- Cambio de estado rápido --}}
                        <form action="{{ route('admin.quotes.status', $quote) }}" method="POST" class="inline">
                            @csrf @method('PATCH')
                            <select name="status"
                                    onchange="this.form.submit()"
                                    class="px-3 py-2 rounded-lg bg-white border border-gray-200 text-sm font-medium text-gray-700 shadow-sm cursor-pointer hover:border-gray-300 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-100">
                                @foreach(['draft' => 'Borrador', 'sent' => 'Enviada', 'approved' => 'Aprobada', 'rejected' => 'Rechazada'] as $val => $label)
                                    <option value="{{ $val }}" {{ $quote->status === $val ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- ═══ COLUMNA IZQUIERDA ═══ --}}
                <div class="space-y-5">

                    {{-- Info cliente --}}
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-5 py-4 border-b border-gray-100 bg-gray-50/50">
                            <h2 class="text-sm font-semibold text-gray-800">Información del cliente</h2>
                        </div>
                        <div class="px-5 py-4 space-y-3 text-sm">
                            <div>
                                <p class="text-xs text-gray-400 uppercase tracking-wide mb-0.5">Nombre</p>
                                <p class="font-medium text-gray-900">{{ $quote->client_name }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 uppercase tracking-wide mb-0.5">Correo</p>
                                <a href="mailto:{{ $quote->client_email }}"
                                   class="text-blue-600 hover:underline">{{ $quote->client_email }}</a>
                            </div>
                            @if($quote->client_phone)
                            <div>
                                <p class="text-xs text-gray-400 uppercase tracking-wide mb-0.5">Teléfono</p>
                                <a href="tel:{{ $quote->client_phone }}"
                                   class="text-gray-800">{{ $quote->client_phone }}</a>
                            </div>
                            @endif
                            @if($quote->client_company)
                            <div>
                                <p class="text-xs text-gray-400 uppercase tracking-wide mb-0.5">Empresa</p>
                                <p class="text-gray-800">{{ $quote->client_company }}</p>
                            </div>
                            @endif
                            @if($quote->additional_requirements)
                            <div class="pt-2 border-t border-gray-100">
                                <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Notas adicionales</p>
                                <p class="text-gray-600 leading-relaxed">{{ $quote->additional_requirements }}</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    {{-- Resumen financiero --}}
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-5 py-4 border-b border-gray-100 bg-gray-50/50">
                            <h2 class="text-sm font-semibold text-gray-800">Resumen</h2>
                        </div>
                        <div class="px-5 py-4 space-y-2.5 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-500">Servicios</span>
                                <span class="font-medium">{{ $quote->items->count() }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Horas totales</span>
                                <span class="font-medium">{{ $quote->total_hours }}h</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Subtotal</span>
                                <span class="font-medium">${{ number_format($quote->subtotal, 2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">IVA (16%)</span>
                                <span class="font-medium">${{ number_format($quote->tax, 2) }}</span>
                            </div>
                            <div class="flex justify-between pt-2.5 border-t border-gray-200">
                                <span class="font-semibold text-gray-900">Total</span>
                                <span class="text-lg font-bold text-gray-900">${{ number_format($quote->total, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Historial de citas --}}
                    @if($quote->replies->count())
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-5 py-4 border-b border-gray-100 bg-gray-50/50">
                            <h2 class="text-sm font-semibold text-gray-800">Citas agendadas</h2>
                        </div>
                        <div class="divide-y divide-gray-100">
                            @foreach($quote->replies as $reply)
                            <div class="px-5 py-3.5">
                                <div class="flex items-center gap-2.5">
                                    <div class="h-7 w-7 rounded-full bg-blue-50 flex items-center justify-center flex-shrink-0">
                                        <svg class="h-3.5 w-3.5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">
                                            {{ $reply->sent_at ? $reply->sent_at->format('d/m/Y H:i') : '—' }}
                                        </p>
                                        <p class="text-xs text-gray-400">
                                            Registrada {{ $reply->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                </div>

                {{-- ═══ COLUMNA DERECHA ═══ --}}
                <div class="lg:col-span-2 space-y-6">

                    {{-- Tabla de servicios --}}
                    @if($quote->items->count())
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-5 py-4 border-b border-gray-100 bg-gray-50/50">
                            <h2 class="text-sm font-semibold text-gray-800">Servicios cotizados</h2>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-100">
                                <thead>
                                    <tr class="bg-gray-50/80">
                                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Servicio</th>
                                        <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Horas</th>
                                        <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">P. Unitario</th>
                                        <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Total</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach($quote->items as $item)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-5 py-3.5">
                                            <p class="text-sm font-medium text-gray-900">{{ $item->name }}</p>
                                            @if($item->description)
                                                <p class="text-xs text-gray-400 mt-0.5">{{ $item->description }}</p>
                                            @endif
                                            @if($item->quantity > 1)
                                                <p class="text-xs text-gray-400 mt-0.5">Cantidad: {{ $item->quantity }}</p>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3.5 text-center">
                                            <span class="text-sm text-gray-700">{{ $item->hours }}h</span>
                                        </td>
                                        <td class="px-4 py-3.5 text-right">
                                            <span class="text-sm text-gray-700">${{ number_format($item->unit_price, 2) }}</span>
                                        </td>
                                        <td class="px-4 py-3.5 text-right">
                                            <span class="text-sm font-semibold text-gray-900">${{ number_format($item->total_price, 2) }}</span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="border-t-2 border-gray-200 bg-gray-50/60">
                                    <tr>
                                        <td colspan="3" class="px-5 py-3 text-right text-sm font-semibold text-gray-700">Total</td>
                                        <td class="px-4 py-3 text-right text-base font-bold text-gray-900">
                                            ${{ number_format($quote->total, 2) }}
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    @else
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 px-6 py-12 text-center text-gray-400">
                        <svg class="h-10 w-10 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <p class="text-sm font-medium text-gray-500">Sin servicios registrados</p>
                    </div>
                    @endif

                    {{-- Formulario de respuesta --}}
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden"
                         x-data="{ meetingDate: '{{ old('meeting_date', '') }}' }">

                        <div class="px-5 py-4 border-b border-gray-100 bg-gray-50/50">
                            <h2 class="text-sm font-semibold text-gray-800">Responder al cliente</h2>
                            <p class="text-xs text-gray-500 mt-0.5">
                                Se enviará un correo con la fecha de cita y el PDF de la cotización adjunto.
                            </p>
                        </div>

                        <div class="p-5">
                            <form action="{{ route('admin.quotes.reply', $quote) }}" method="POST" class="space-y-5">
                                @csrf

                                {{-- Fecha de cita --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                        Fecha y hora de la cita virtual
                                    </label>
                                    <input type="datetime-local"
                                           name="meeting_date"
                                           x-model="meetingDate"
                                           required
                                           class="w-full sm:w-auto rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition-colors">
                                    @error('meeting_date')
                                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Vista previa del correo --}}
                                <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-3">
                                        Vista previa del correo
                                    </p>
                                    <div class="space-y-3 text-sm text-gray-700 leading-relaxed">
                                        <p>Hola <strong>{{ $quote->client_name }}</strong>,</p>
                                        <p>
                                            Esperamos que te encuentres muy bien. Te compartimos la cotización solicitada
                                            en formato PDF, donde podrás revisar a detalle los servicios y los importes correspondientes.
                                        </p>
                                        <p class="font-medium text-gray-800"
                                           x-text="meetingDate
                                                ? 'Cita Virtual en Google Meet: ' + new Date(meetingDate).toLocaleString('es-MX', { dateStyle: 'long', timeStyle: 'short' })
                                                : 'Aquí aparecerá la fecha de la cita…'">
                                        </p>
                                        <p><strong>Total cotizado:</strong> ${{ number_format($quote->total, 2) }}</p>
                                        <p>
                                            El archivo PDF adjunto contiene la información completa.
                                            Si tienes alguna duda o requieres ajustes, con gusto te apoyamos.
                                        </p>
                                        <p>
                                            Saludos cordiales,<br>
                                            <strong>Equipo DMI</strong>
                                        </p>
                                    </div>
                                </div>

                                <div class="flex justify-end">
                                    <button type="submit"
                                            class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors shadow-sm">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                        </svg>
                                        Enviar correo con cotización
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>{{-- /col-derecha --}}
            </div>{{-- /grid --}}
        </div>
    </div>
</x-app-layout>