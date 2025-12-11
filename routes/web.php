<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\Admin\QuoteBlockController;
use Illuminate\Support\Facades\Route;
use App\Models\Quote;
use Laravel\Sanctum\Http\Controllers\CsrfCookieController;


Route::get('/sanctum/csrf-cookie', [CsrfCookieController::class, 'show']);


/*
|--------------------------------------------------------------------------
| Public
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// Builder público tipo SPA
Route::get('/cotizador', [QuoteController::class, 'builder'])
    ->name('quote.builder');


/*
|--------------------------------------------------------------------------
| API Pública (sin middleware, para SPA)
|--------------------------------------------------------------------------
*/

Route::prefix('/api')->group(function () {

    // Cargar bloques para el cotizador
    Route::get('/quote-blocks', [QuoteController::class, 'apiBlocks']);

    // Guardar cotización desde SPA
    Route::post('/quotes/save-draft', [QuoteController::class, 'saveDraft']);
    Route::post('/quotes/generate-pdf', [QuoteController::class, 'generatePdf']);
    Route::post('/quotes/submit', [QuoteController::class, 'submit']);
});


/*
|--------------------------------------------------------------------------
| Auth + Dashboard Global
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', fn()=>view('dashboard'))->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    Route::get('/cotizadorb', function () {
        return view('cotizador.edit');
                })->name('cotizador.edit');

    Route::get('/bloques', function () {
        return view('bloques.edit');
                })->name('bloques.edit');
    


    /*
    |--------------------------------------------------------------------------
    | ADMIN
    |--------------------------------------------------------------------------
    */

    Route::prefix('admin')->name('admin.')->group(function () {

        Route::get('/', fn()=>view('admin.dashboard'))
            ->name('dashboard');

        // bloques de cotización
        Route::resource('quote-blocks', QuoteBlockController::class);

        Route::post('quote-blocks/reorder', [QuoteBlockController::class, 'reorder'])
            ->name('quote-blocks.reorder');

        // listado de cotizaciones admin
        Route::get('quotes', function () {
            $quotes = Quote::latest()->paginate(20);
            return view('admin.quotes.index', compact('quotes'));
        })->name('quotes.index');

        Route::get('quotes/{quote}', function (Quote $quote) {
            return view('admin.quotes.show', compact('quote'));
        })->name('quotes.show');

        Route::get('categories', function () {
            $categories = \App\Models\QuoteBlockCategory::withCount('blocks')->get();
            return view('admin.categories.index', compact('categories'));
        })->name('categories.index');
    });
});


/*
|--------------------------------------------------------------------------
| API protegida con Sanctum específicamente
|--------------------------------------------------------------------------
*/

Route::middleware(['auth:sanctum'])
    ->prefix('/api/v1')
    ->group(function () {

        Route::get('/quotes/statistics', [QuoteController::class, 'getStatistics']);
        Route::get('/quotes/recent', [QuoteController::class, 'getRecentQuotes']);
        Route::post('/quotes/{id}/duplicate', [QuoteController::class, 'duplicateQuote']);
        Route::get('/quotes/export', [QuoteController::class, 'exportQuotes']);
    });


require __DIR__.'/auth.php';
