<?php

use Illuminate\Support\Facades\Route;
use Modules\Pengembalian\app\Http\Controllers\PengembalianAdminController;
use Modules\Pengembalian\app\Http\Controllers\PengembalianController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('auth', 'can:pengembalian')->group(function () {
    Route::prefix('pengembalian')->group(function () {
        Route::post('data', [PengembalianController::class, 'data'])->name('pengembalian.data');
        Route::post('selesai', [PengembalianController::class, 'selesai'])->name('pengembalian.selesai');
    });
    Route::resource('pengembalian', PengembalianController::class);
});
