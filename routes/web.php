<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuctionController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/filter-lelang', [AuctionController::class, 'index'])
    ->name('lelang.index');

Route::view('/pusat-bantuan', 'pages.help')->name('help');

Route::get('/search', function () {
    $query = request('q');
    // Logic pencarian akan ditambahkan nanti
    return view('pages.search', compact('query'));
})->name('search');




Route::get('/employees', [EmployeeController::class, 'index']);