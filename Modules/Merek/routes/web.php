<?php

use Illuminate\Support\Facades\Route;
use Modules\Merek\app\Http\Controllers\MerekController;

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

Route::middleware('auth', 'can:merek')->group(function () {
    Route::resource('merek', MerekController::class);
});
