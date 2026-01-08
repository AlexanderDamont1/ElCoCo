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

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/cotizadorb', function () {return view('cotizador.edit');})->name('cotizador.edit');

   Route::get('/bloques', [QuoteBlockController::class, 'index'])->name('bloques.index');

   Route::get('/bloques/{quoteBlock}/edit', [QuoteBlockController::class, 'edit'])->name('bloques.edit');

   Route::put('/bloques/{quoteBlock}', [QuoteBlockController::class, 'update'])->name('bloques.update');
   
   
   
   Route::get('/admin/cotizaciones', [QuoteController::class, 'index']) ->name('admin.quotes.index');
   
   Route::get('/admin/cotizaciones/{quote}', [QuoteController::class, 'show'])->name('admin.quotes.show');
        
   Route::patch('/admin/cotizaciones/{quote}/status', [QuoteController::class, 'updateStatus'])->name('admin.quotes.status');
    /*
    |--------------------------------------------------------------------------
    | ADMIN
    |--------------------------------------------------------------------------
    */

 

        // bloques de cotización
        
Route::prefix('admin')->name('admin.')->group(function () {

     
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
