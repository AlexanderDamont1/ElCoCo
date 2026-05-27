<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\Admin\QuoteBlockController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Pública
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/cotizador', [QuoteController::class, 'builder'])
    ->name('quote.builder');

/*
|--------------------------------------------------------------------------
| API pública — cotizador SPA
| throttle: máx 30 req/min en general, 5 envíos/min para submit
|--------------------------------------------------------------------------
*/

Route::prefix('api')->middleware('throttle:30,1')->group(function () {

    Route::get('/quote-blocks', [QuoteController::class, 'apiBlocks']);

    Route::post('/quotes/save-draft', [QuoteController::class, 'saveDraft']);

    Route::post('/quotes/generate-pdf', [QuoteController::class, 'generatePdf']);

    Route::middleware('throttle:5,1')->group(function () {
        Route::post('/quotes/submit', [QuoteController::class, 'submit']);
        Route::post('/quotes/submit-with-appointment', [QuoteController::class, 'submitWithAppointment']);
    });
});

/*
|--------------------------------------------------------------------------
| Auth + Panel admin
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Bloques — primero la ruta de categorías para evitar colisión con {bloque}
    Route::post('bloques/categorias', [QuoteBlockController::class, 'storeCategory'])
        ->name('bloques.categorias.store');
    Route::resource('bloques', QuoteBlockController::class);

    // Cotizaciones admin
    Route::prefix('admin/cotizaciones')->name('admin.quotes.')->group(function () {
        Route::get('/',                    [QuoteController::class, 'index'])->name('index');
        Route::get('/{quote}',             [QuoteController::class, 'show'])->name('show');
        Route::patch('/{quote}/status',    [QuoteController::class, 'updateStatus'])->name('status');
        Route::post('/{quote}/reply',      [QuoteController::class, 'reply'])->name('reply');
        Route::get('/{quote}/pdf',         [QuoteController::class, 'generatePdf'])->name('pdf');
    });
});

require __DIR__.'/auth.php';