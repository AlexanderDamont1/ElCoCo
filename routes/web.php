<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuoteController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


// Ruta principal del cotizador
Route::get('/quote-builder', [QuoteController::class, 'showBuilder'])
    ->name('quote.builder');

// Envío de cotización (API)
Route::post('/quote/submit', [QuoteController::class, 'submitQuote'])
    ->name('quote.submit');

// Exportar PDF
Route::get('/quote/export/{quote}', [QuoteController::class, 'exportPdf'])
    ->name('quote.export');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
