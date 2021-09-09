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

Route::get('/', fn() => view('root'))->name('root');


/** @var string $locale Included by the RouteServiceProvider line 55 and 66 */
$r = fn(string $name, array $replacements = []): string|array|null => __("routes.$name", $replacements, $locale);

/**
 * If we also need translated url segments, we can use laravel translation component with an explicit locale
 * These three next routes definitions are equivalent
 */
Route::get(__('routes.about-us', [], $locale), fn() => 'About us page, check url')->name('about');
Route::get(__('routes.about-us', locale: $locale), fn() => 'About us page, check url')->name('about');
Route::get($r('about-us'), fn() => 'About us page, check url')->name('about');

/**
 * Still works with route parameters
 */
Route::get("/{$r('posts')}/{post}", fn() => view('posts.show'))->name('posts.show');
