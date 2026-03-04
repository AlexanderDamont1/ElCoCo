<x-app-layout>

    {{-- ══════════════════════════════════════════
         TOAST DE ÉXITO
    ══════════════════════════════════════════ --}}
    @if(session('success'))
        <div class="fixed top-6 left-1/2 -translate-x-1/2 z-50"
             x-data="{ show: true }"
             x-show="show"
             x-init="setTimeout(() => show = false, 3500)"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 -translate-y-3"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-end="opacity-0 translate-y-2">
            <div class="flex items-center gap-3 bg-white rounded-xl px-5 py-3.5 shadow-xl ring-1 ring-gray-200 min-w-[280px]">
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
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- ══════════════════════════════════════════
                 HEADER
            ══════════════════════════════════════════ --}}
            <div class="mb-8">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <p class="mt-1 text-sm text-gray-500">
                            {{ now()->isoFormat('dddd, D [de] MMMM [de] YYYY') }}
                        </p>
                    </div>
                    <div class="flex flex-wrap items-center gap-2">
                        <a href="{{ route('bloques.index') }}"
                           class="inline-flex items-center gap-2 px-4 py-2.5 bg-white text-gray-700 rounded-lg hover:bg-gray-50 transition-colors text-sm font-medium border border-gray-200 shadow-sm">
                            <svg class="h-4 w-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                            </svg>
                            Bloques
                        </a>
                        <a href="{{ route('admin.quotes.index') }}"
                           class="inline-flex items-center gap-2 px-4 py-2.5 bg-white text-gray-700 rounded-lg hover:bg-gray-50 transition-colors text-sm font-medium border border-gray-200 shadow-sm">
                            <svg class="h-4 w-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Cotizaciones
                        </a>
                        <a href="{{ route('quote.builder') }}"
                           class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium shadow-sm">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Nueva Cotización
                        </a>
                    </div>
                </div>
            </div>

            {{-- ══════════════════════════════════════════
                 KPI CARDS
            ══════════════════════════════════════════ --}}
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 mb-6">

                {{-- Total Cotizaciones --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 px-5 py-5">
                    <div class="flex items-center justify-between mb-3">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider leading-tight">Total Cotiz.</p>
                        <div class="h-8 w-8 rounded-lg bg-blue-50 flex items-center justify-center flex-shrink-0">
                            <svg class="h-4 w-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_quotes']) }}</p>
                    <p class="mt-1 text-xs text-gray-400">Historial completo</p>
                </div>

                {{-- Este mes --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 px-5 py-5">
                    <div class="flex items-center justify-between mb-3">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider leading-tight">Este Mes</p>
                        <div class="h-8 w-8 rounded-lg bg-indigo-50 flex items-center justify-center flex-shrink-0">
                            <svg class="h-4 w-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    </div>
                    @php
                        $quoteDiff = $stats['monthly_quotes'] - $stats['last_month_quotes'];
                        $quoteUp   = $quoteDiff >= 0;
                    @endphp
                    <div class="flex items-end gap-1.5">
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['monthly_quotes']) }}</p>
                        <span class="mb-0.5 inline-flex items-center gap-0.5 text-xs font-medium {{ $quoteUp ? 'text-green-600' : 'text-red-500' }}">
                            <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $quoteUp ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7' }}"/>
                            </svg>
                            {{ abs($quoteDiff) }}
                        </span>
                    </div>
                    <p class="mt-1 text-xs text-gray-400">vs mes anterior</p>
                </div>

                {{-- Ingresos --}}
                <div class="col-span-2 sm:col-span-1 bg-white rounded-xl shadow-sm border border-gray-200 px-5 py-5">
                    <div class="flex items-center justify-between mb-3">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider leading-tight">Ingresos Mes</p>
                        <div class="h-8 w-8 rounded-lg bg-green-50 flex items-center justify-center flex-shrink-0">
                            <svg class="h-4 w-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    @php
                        $incomeDiff = $stats['monthly_income'] - $stats['last_month_income'];
                        $incomeUp   = $incomeDiff >= 0;
                    @endphp
                    <div class="flex items-end gap-1.5">
                        <p class="text-2xl font-bold text-gray-900">${{ number_format($stats['monthly_income'], 0) }}</p>
                        <span class="mb-0.5 inline-flex items-center gap-0.5 text-xs font-medium {{ $incomeUp ? 'text-green-600' : 'text-red-500' }}">
                            <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $incomeUp ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7' }}"/>
                            </svg>
                            ${{ number_format(abs($incomeDiff), 0) }}
                        </span>
                    </div>
                    <p class="mt-1 text-xs text-gray-400">vs mes anterior</p>
                </div>

                {{-- Horas vendidas --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 px-5 py-5">
                    <div class="flex items-center justify-between mb-3">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider leading-tight">Horas Mes</p>
                        <div class="h-8 w-8 rounded-lg bg-cyan-50 flex items-center justify-center flex-shrink-0">
                            <svg class="h-4 w-4 text-cyan-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['monthly_hours']) }}</p>
                    <p class="mt-1 text-xs text-gray-400">horas estimadas</p>
                </div>

                {{-- Bloques activos --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 px-5 py-5">
                    <div class="flex items-center justify-between mb-3">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider leading-tight">Bloques</p>
                        <div class="h-8 w-8 rounded-lg bg-amber-50 flex items-center justify-center flex-shrink-0">
                            <svg class="h-4 w-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['active_blocks']) }}</p>
                    <p class="mt-1 text-xs text-gray-400">de {{ number_format($stats['total_blocks']) }} totales</p>
                </div>

            </div>

            {{-- ══════════════════════════════════════════
                 GRÁFICA + TOP BLOQUES
            ══════════════════════════════════════════ --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">

                {{-- Gráfica --}}
                <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50/50">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                            <div>
                                <h2 class="text-base font-semibold text-gray-900">Tendencia Mensual</h2>
                                <p class="text-xs text-gray-500 mt-0.5">Cotizaciones e ingresos — últimos 6 meses</p>
                            </div>
                            <div class="flex items-center gap-4 text-xs text-gray-500">
                                <span class="flex items-center gap-1.5">
                                    <span class="h-2.5 w-2.5 rounded-full bg-blue-500 flex-shrink-0 inline-block"></span>
                                    Cotizaciones
                                </span>
                                <span class="flex items-center gap-1.5">
                                    <span class="h-2.5 w-2.5 rounded-full bg-green-400 flex-shrink-0 inline-block"></span>
                                    Ingresos
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <div style="position:relative;height:240px;">
                            <canvas id="quotesChart"></canvas>
                        </div>
                    </div>
                </div>

                {{-- Top 5 bloques --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50/50">
                        <div class="flex items-center justify-between">
                            <div>
                                <h2 class="text-base font-semibold text-gray-900">Top Bloques</h2>
                                <p class="text-xs text-gray-500 mt-0.5">Por número de usos</p>
                            </div>
                            <a href="{{ route('bloques.index') }}"
                               class="text-xs text-blue-600 hover:text-blue-700 font-medium transition-colors">
                                Ver todos
                            </a>
                        </div>
                    </div>
                    <div class="divide-y divide-gray-100">
                        @forelse($topBlocks as $i => $block)
                        <div class="px-5 py-3.5 hover:bg-gray-50 transition-colors duration-150">
                            <div class="flex items-center gap-3">
                                <span class="flex-shrink-0 h-6 w-6 rounded-full flex items-center justify-center text-xs font-bold
                                    {{ $i === 0 ? 'bg-amber-100 text-amber-700' : ($i === 1 ? 'bg-gray-200 text-gray-600' : 'bg-gray-100 text-gray-400') }}">
                                    {{ $i + 1 }}
                                </span>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">{{ $block->name }}</p>
                                    <div class="flex items-center gap-2 mt-1">
                                        @if($topBlocks->isNotEmpty() && $topBlocks->first()->usage_count > 0)
                                        <div class="flex-1 h-1 bg-gray-100 rounded-full overflow-hidden" style="max-width:80px">
                                            <div class="h-1 rounded-full bg-blue-400"
                                                 style="width:{{ round(($block->usage_count / $topBlocks->first()->usage_count) * 100) }}%">
                                            </div>
                                        </div>
                                        @endif
                                        <span class="text-xs text-gray-400 whitespace-nowrap">
                                            {{ $block->usage_count }} {{ $block->usage_count == 1 ? 'uso' : 'usos' }}
                                        </span>
                                    </div>
                                </div>
                                <div class="text-right flex-shrink-0">
                                    <p class="text-sm font-semibold text-gray-900">${{ number_format($block->total_generated ?? 0, 0) }}</p>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="px-6 py-12 text-center text-gray-400">
                            <svg class="h-10 w-10 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                            </svg>
                            <p class="text-sm font-medium text-gray-500">Sin datos aún</p>
                        </div>
                        @endforelse
                    </div>
                </div>

            </div>

            {{-- ══════════════════════════════════════════
                 ACTIVIDAD RECIENTE
            ══════════════════════════════════════════ --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50/50">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <div>
                            <h2 class="text-base font-semibold text-gray-900">Actividad Reciente</h2>
                            <p class="text-xs text-gray-500 mt-0.5">Últimas 5 cotizaciones creadas</p>
                        </div>
                        <a href="{{ route('admin.quotes.index') }}"
                           class="inline-flex items-center gap-1 text-sm text-blue-600 hover:text-blue-700 font-medium transition-colors">
                            Ver todas
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </div>

                @if($recentQuotes->count())

                    {{-- TABLA — sm y superior --}}
                    <div class="hidden sm:block overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-100">
                            <thead>
                                <tr class="bg-gray-50/80">
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Referencia</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Cliente</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Total</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Estado</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Fecha</th>
                                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($recentQuotes as $quote)
                                @php
                                    $statusMap = [
                                        'draft'    => ['label' => 'Borrador',  'class' => 'bg-gray-100 text-gray-600'],
                                        'sent'     => ['label' => 'Enviada',   'class' => 'bg-blue-50 text-blue-700'],
                                        'approved' => ['label' => 'Aprobada',  'class' => 'bg-green-50 text-green-700'],
                                        'rejected' => ['label' => 'Rechazada', 'class' => 'bg-red-50 text-red-600'],
                                    ];
                                    $s = $statusMap[$quote->status] ?? ['label' => ucfirst($quote->status ?? '—'), 'class' => 'bg-gray-100 text-gray-600'];
                                @endphp
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm font-mono font-medium text-gray-500">
                                            {{ $quote->reference ?? '#'.$quote->id }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <p class="text-sm font-medium text-gray-900">{{ $quote->client_name ?? '—' }}</p>
                                        @if($quote->client_email)
                                            <p class="text-xs text-gray-400 truncate max-w-[160px]">{{ $quote->client_email }}</p>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm font-semibold text-gray-900">${{ number_format($quote->total, 2) }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $s['class'] }}">
                                            {{ $s['label'] }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <p class="text-sm text-gray-700">{{ $quote->created_at->format('d/m/Y') }}</p>
                                        <p class="text-xs text-gray-400">{{ $quote->created_at->diffForHumans() }}</p>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <a href="{{ route('admin.quotes.show', $quote) }}"
                                           class="inline-flex items-center gap-1 px-3 py-1.5 rounded-md bg-white text-gray-700 hover:bg-gray-100 border border-gray-300 hover:border-gray-400 transition-colors text-xs font-medium">
                                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                            Ver
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- CARDS MÓVIL --}}
                    <div class="sm:hidden divide-y divide-gray-100">
                        @foreach($recentQuotes as $quote)
                        @php
                            $statusMap = [
                                'draft'    => ['label' => 'Borrador',  'class' => 'bg-gray-100 text-gray-600'],
                                'sent'     => ['label' => 'Enviada',   'class' => 'bg-blue-50 text-blue-700'],
                                'approved' => ['label' => 'Aprobada',  'class' => 'bg-green-50 text-green-700'],
                                'rejected' => ['label' => 'Rechazada', 'class' => 'bg-red-50 text-red-600'],
                            ];
                            $s = $statusMap[$quote->status] ?? ['label' => ucfirst($quote->status ?? '—'), 'class' => 'bg-gray-100 text-gray-600'];
                        @endphp
                        <div class="px-5 py-4">
                            <div class="flex items-start justify-between gap-3">
                                <div class="min-w-0 flex-1">
                                    <div class="flex items-center gap-2 mb-1 flex-wrap">
                                        <span class="text-xs font-mono text-gray-400">{{ $quote->reference ?? '#'.$quote->id }}</span>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $s['class'] }}">
                                            {{ $s['label'] }}
                                        </span>
                                    </div>
                                    <p class="text-sm font-semibold text-gray-900">{{ $quote->client_name ?? '—' }}</p>
                                    <p class="text-xs text-gray-400 mt-0.5">
                                        {{ $quote->created_at->format('d/m/Y') }} · {{ $quote->created_at->diffForHumans() }}
                                    </p>
                                </div>
                                <div class="text-right flex-shrink-0">
                                    <p class="text-sm font-bold text-gray-900">${{ number_format($quote->total, 2) }}</p>
                                    <a href="{{ route('admin.quotes.show', $quote) }}"
                                       class="mt-1.5 inline-flex items-center gap-1 px-2.5 py-1 rounded-md bg-white text-gray-600 hover:bg-gray-100 border border-gray-300 transition-colors text-xs font-medium">
                                        Ver
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                @else
                    <div class="px-6 py-16 text-center">
                        <svg class="h-12 w-12 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <h3 class="text-base font-semibold text-gray-900 mb-1">Sin cotizaciones aún</h3>
                        <p class="text-sm text-gray-500 mb-4">Crea tu primera cotización para comenzar</p>
                        <a href="{{ route('quote.builder') }}"
                           class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Nueva Cotización
                        </a>
                    </div>
                @endif
            </div>

            {{-- Pie --}}
            <div class="mt-6 text-xs text-gray-400 text-center">
                Métricas actualizadas cada 5 minutos · {{ now()->format('H:i') }} ·
                <a href="{{ route('admin.quotes.index') }}" class="hover:text-blue-500 transition-colors">Ver reporte completo →</a>
            </div>

        </div>
    </div>

    {{-- ══════════════════════════════════════════
         CHART.JS VÍA CDN
    ══════════════════════════════════════════ --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
    (function () {
        const labels  = @json($chartData->pluck('month_label'));
        const counts  = @json($chartData->pluck('total_quotes'));
        const incomes = @json($chartData->pluck('total_income'));

        const ctx = document.getElementById('quotesChart');
        if (!ctx) return;

        new Chart(ctx, {
            type: 'line',
            data: {
                labels,
                datasets: [
                    {
                        label: 'Cotizaciones',
                        data: counts,
                        borderColor: '#3b82f6',
                        backgroundColor: 'rgba(59,130,246,0.07)',
                        borderWidth: 2,
                        pointBackgroundColor: '#3b82f6',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 7,
                        tension: 0.4,
                        fill: true,
                        yAxisID: 'y',
                    },
                    {
                        label: 'Ingresos',
                        data: incomes,
                        borderColor: '#4ade80',
                        backgroundColor: 'rgba(74,222,128,0.06)',
                        borderWidth: 2,
                        pointBackgroundColor: '#4ade80',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 7,
                        tension: 0.4,
                        fill: true,
                        yAxisID: 'y1',
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: { mode: 'index', intersect: false },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        titleColor: '#94a3b8',
                        bodyColor: '#f1f5f9',
                        padding: 12,
                        cornerRadius: 10,
                        callbacks: {
                            label: function(ctx) {
                                if (ctx.datasetIndex === 0) return '  Cotizaciones: ' + ctx.parsed.y;
                                return '  Ingresos: $' + Number(ctx.parsed.y).toLocaleString('es-MX', { maximumFractionDigits: 0 });
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { color: '#9ca3af', font: { size: 12 } }
                    },
                    y: {
                        position: 'left',
                        beginAtZero: true,
                        grid: { color: '#f3f4f6' },
                        ticks: { color: '#9ca3af', font: { size: 11 }, precision: 0 }
                    },
                    y1: {
                        position: 'right',
                        beginAtZero: true,
                        grid: { drawOnChartArea: false },
                        ticks: {
                            color: '#9ca3af',
                            font: { size: 11 },
                            callback: function(v) {
                                return '$' + Number(v).toLocaleString('es-MX', { maximumFractionDigits: 0 });
                            }
                        }
                    }
                }
            }
        });
    })();
    </script>

    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translate(-50%, -10px); }
            to   { opacity: 1; transform: translate(-50%, 0); }
        }
    </style>

</x-app-layout>