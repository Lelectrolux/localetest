<?php

use Illuminate\Support\Facades\Route;

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

Route::prefix('{locale}')->middleware('setLocale')->group(function () {
    Route::get('/', function () {})->name('root');
});

Route::get('/{any?}', function () {
    // detect user browser language prefs and redirect accordingly
    return redirect('somewhere');
})->where('any', '.*');
