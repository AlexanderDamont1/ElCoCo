<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuoteController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware(['throttle:60,1'])->group(function () {
    // Bloques de cotización (públicos para el builder)
    Route::get('/quote-blocks', [QuoteController::class, 'apiBlocks']);
    Route::get('/quote-blocks/category/{categoryId}', [QuoteController::class, 'getBlocksByCategory']);
    Route::post('/quote-blocks/calculate', [QuoteController::class, 'calculateBlockPrice']);
    
    // Cotizaciones (públicas para enviar)
    Route::post('/quotes/save-draft', [QuoteController::class, 'saveDraft']);
    Route::post('/quotes/generate-pdf', [QuoteController::class, 'generatePdf']);
    Route::post('/quotes/submit', [QuoteController::class, 'submit']);
});

// Rutas protegidas con autenticación
Route::middleware(['auth:sanctum', 'throttle:30,1'])->group(function () {
    // Estadísticas y gestión de cotizaciones
    Route::get('/quotes/statistics', [QuoteController::class, 'getStatistics']);
    Route::get('/quotes/recent', [QuoteController::class, 'getRecentQuotes']);
    Route::post('/quotes/{id}/duplicate', [QuoteController::class, 'duplicateQuote']);
    Route::get('/quotes/export', [QuoteController::class, 'exportQuotes']);
    
    // API para administración (si necesitas API para el panel admin)
    Route::prefix('admin')->group(function () {
        Route::apiResource('quote-blocks', \App\Http\Controllers\Admin\QuoteBlockController::class);
        Route::post('quote-blocks/reorder', [\App\Http\Controllers\Admin\QuoteBlockController::class, 'reorder']);
    });
});

// Ruta de salud para monitoreo
Route::get('/health', function () {
    return response()->json(['status' => 'healthy', 'timestamp' => now()]);
});