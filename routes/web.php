<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\Admin\QuoteBlockController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Http\Controllers\CsrfCookieController;
use Illuminate\Support\Facades\Mail;



Route::get('/test-mail', function () {

    Mail::raw('Test email funcionando', function ($msg) {
        $msg->to('cale.13.0611@gmail.com')
            ->subject('Test Laravel Mail');
    });

    return 'Correo enviado';
});

/*
|--------------------------------------------------------------------------
| CSRF Sanctum
|--------------------------------------------------------------------------
*/

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
| API Pública (para SPA)
|--------------------------------------------------------------------------
*/

Route::prefix('api')->group(function () {

    Route::get('/quote-blocks', [QuoteController::class, 'apiBlocks']);

    Route::post('/quotes/save-draft', [QuoteController::class, 'saveDraft']);
    Route::post('/quotes/generate-pdf', [QuoteController::class, 'generatePdf']);
    Route::post('/quotes/submit', [QuoteController::class, 'submit']);
    Route::post('/quotes/submit-with-appointment', [QuoteController::class, 'submitQuoteWithAppointment']);
});

/*
|--------------------------------------------------------------------------
| Auth + Dashboard
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Profile
    |--------------------------------------------------------------------------
    */

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    /*
    |--------------------------------------------------------------------------
    | Bloques (LIMPIO — solo resource)
    |--------------------------------------------------------------------------
    */

    Route::resource('bloques', QuoteBlockController::class);
    Route::post('bloques/categorias', [QuoteBlockController::class, 'storeCategory'])
    ->name('bloques.categorias.store');

    /*
    |--------------------------------------------------------------------------
    | Admin Cotizaciones
    |--------------------------------------------------------------------------
    */

    Route::prefix('admin/cotizaciones')
        ->name('admin.quotes.')
        ->group(function () {

            Route::get('/', [QuoteController::class, 'index'])
                ->name('index');

            Route::get('/{quote}', [QuoteController::class, 'show'])
                ->name('show');

            Route::patch('/{quote}/status', [QuoteController::class, 'updateStatus'])
                ->name('status');

            Route::post('/{quote}/reply', [QuoteController::class, 'reply'])
                ->name('reply');

            Route::get('/{quote}/pdf', [QuoteController::class, 'generatePdf'])
                ->name('pdf');
        });
});

/*
|--------------------------------------------------------------------------
| API Protegida Sanctum
|--------------------------------------------------------------------------
*/

Route::middleware(['auth:sanctum'])
    ->prefix('api/v1')
    ->group(function () {

        Route::get('/quotes/statistics', [QuoteController::class, 'getStatistics']);
        Route::get('/quotes/recent', [QuoteController::class, 'getRecentQuotes']);
        Route::post('/quotes/{id}/duplicate', [QuoteController::class, 'duplicateQuote']);
        Route::get('/quotes/export', [QuoteController::class, 'exportQuotes']);
    });

require __DIR__.'/auth.php';