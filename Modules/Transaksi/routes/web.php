<?php

use Illuminate\Support\Facades\Route;
use Modules\Transaksi\app\Http\Controllers\BookingController;
use Modules\Transaksi\app\Http\Controllers\TransaksiBelumController;
use Modules\Transaksi\app\Http\Controllers\TransaksiController;
use Modules\Transaksi\app\Http\Controllers\TransaksiSelesaiController;

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

Route::middleware('auth', 'can:transaksi')->prefix('transaksi')->group(function () {
    Route::resource('booking', BookingController::class)->names('transaksi.booking');
    Route::resource('belum-selesai', TransaksiBelumController::class)->names('transaksi.belum-selesai');
    Route::resource('selesai', TransaksiSelesaiController::class)->names('transaksi.selesai');
    // Route::resource('transaksi', TransaksiController::class);
});
