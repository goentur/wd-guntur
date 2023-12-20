<?php

use Illuminate\Support\Facades\Route;
use Modules\Peminjaman\app\Http\Controllers\PeminjamanController;

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

Route::middleware('auth', 'can:peminjaman')->group(function () {
    Route::prefix('peminjaman')->group(function () {
        Route::get('', [PeminjamanController::class, 'index'])->name('peminjaman.index');
        Route::post('update-profil', [PeminjamanController::class, 'updateProfil'])->name('peminjaman.update-profil');
        Route::post('cari-data', [PeminjamanController::class, 'cariData'])->name('peminjaman.cari-data');
        Route::post('data', [PeminjamanController::class, 'data'])->name('peminjaman.data');
        Route::post('selesai', [PeminjamanController::class, 'selesai'])->name('peminjaman.selesai');
    });
});
