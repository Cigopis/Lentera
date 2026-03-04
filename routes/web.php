<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HelpController;
use App\Http\Controllers\AuctionController;
use App\Http\Controllers\CatalogPageController;
use App\Http\Controllers\PaymentProofController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/bantuan', [HelpController::class, 'index'])->name('help');

Route::get('/search', function () {
    $query = request('q');
    return view('pages.search', compact('query'));
})->name('search');

Route::get('/lelang', [AuctionController::class, 'index'])->name('lelang.index');
Route::get('/lelang/{slug}', [AuctionController::class, 'show'])->name('lelang.show');

Route::get('/katalog', [CatalogPageController::class, 'index'])
    ->name('katalog.index');

Route::get('/employees', [EmployeeController::class, 'index']);

// Routes untuk payment proof
Route::post('/catalog/{catalog}/payment-proof', [PaymentProofController::class, 'store'])
    ->name('payment-proof.store');

Route::post('/catalog/{catalog}/payment-proof/check', [PaymentProofController::class, 'checkStatus'])
    ->name('payment-proof.check');