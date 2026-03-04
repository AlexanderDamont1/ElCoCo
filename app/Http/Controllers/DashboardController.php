<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use App\Models\QuoteItem;
use App\Models\QuoteBlock;
use App\Models\QuoteBlockCategory;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $now = now();
        $lastMonth = now()->subMonth();

        /*
        |--------------------------------------------------------------------------
        | KPI PRINCIPALES
        |--------------------------------------------------------------------------
        */

        $stats = Cache::remember('dashboard.stats', 300, function () use ($now, $lastMonth) {

            return [

                // Totales generales
                'total_quotes' => Quote::count(),
                'total_blocks' => QuoteBlock::count(),
                'active_blocks' => QuoteBlock::active()->count(),
                'total_categories' => QuoteBlockCategory::count(),

                // Cotizaciones mes actual
                'monthly_quotes' => Quote::whereYear('created_at', $now->year)
                    ->whereMonth('created_at', $now->month)
                    ->count(),

                // Cotizaciones mes pasado
                'last_month_quotes' => Quote::whereYear('created_at', $lastMonth->year)
                    ->whereMonth('created_at', $lastMonth->month)
                    ->count(),

                // Ingresos
                'monthly_income' => Quote::whereYear('created_at', $now->year)
                    ->whereMonth('created_at', $now->month)
                    ->sum('total'),

                'last_month_income' => Quote::whereYear('created_at', $lastMonth->year)
                    ->whereMonth('created_at', $lastMonth->month)
                    ->sum('total'),

                // Horas vendidas este mes
                'monthly_hours' => Quote::whereYear('created_at', $now->year)
                    ->whereMonth('created_at', $now->month)
                    ->sum('total_hours'),

                // Cotizaciones enviadas este mes
                'sent_this_month' => Quote::whereNotNull('sent_at')
                    ->whereYear('sent_at', $now->year)
                    ->whereMonth('sent_at', $now->month)
                    ->count(),
            ];
        });


        /*
        |--------------------------------------------------------------------------
        | GRÁFICA – Últimos 6 meses
        |--------------------------------------------------------------------------
        */

        $chartData = Cache::remember('dashboard.chart', 300, function () {

            return Quote::selectRaw("
                    DATE_FORMAT(created_at, '%b %Y') as month_label,
                    YEAR(created_at)  as year_num,
                    MONTH(created_at) as month_num,
                    COUNT(*)          as total_quotes,
                    SUM(total)        as total_income
                ")
                ->where('created_at', '>=', now()->subMonths(5)->startOfMonth())
                ->groupByRaw("year_num, month_num, month_label")
                ->orderByRaw("year_num ASC, month_num ASC")
                ->get();
        });


        /*
        |--------------------------------------------------------------------------
        | TOP 5 BLOQUES MÁS USADOS (QuoteItem real)
        |--------------------------------------------------------------------------
        */

        $topBlocks = Cache::remember('dashboard.top_blocks', 300, function () {

            return QuoteItem::join('quote_blocks', 'quote_blocks.id', '=', 'quote_items.quote_block_id')
                ->select(
                    'quote_blocks.id',
                    'quote_blocks.name'
                )
                ->selectRaw('COUNT(quote_items.id) as usage_count')
                ->selectRaw('SUM(quote_items.total_price) as total_generated')
                ->groupBy('quote_blocks.id', 'quote_blocks.name')
                ->orderByDesc('usage_count')
                ->limit(5)
                ->get();
        });


        /*
        |--------------------------------------------------------------------------
        | ACTIVIDAD RECIENTE
        |--------------------------------------------------------------------------
        */

        $recentQuotes = Quote::select(
                'id',
                'reference',
                'client_name',
                'client_email',
                'total',
                'status',
                'created_at'
            )
            ->latest()
            ->limit(5)
            ->get();


        return view('dashboard', [
            'stats' => $stats,
            'chartData' => $chartData,
            'topBlocks' => $topBlocks,
            'recentQuotes' => $recentQuotes,
        ]);
    }
}