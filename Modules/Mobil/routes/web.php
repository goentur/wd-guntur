<?php

use Illuminate\Support\Facades\Route;
use Modules\Mobil\app\Http\Controllers\MobilController;

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


Route::middleware('auth', 'can:mobil')->group(function () {
    Route::resource('mobil', MobilController::class);
});
