<?php

use App\Services\AppService;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

AppService::setLocaleFromPrefix();

Route::group(['prefix' => '{__locale}'], function () {
    Auth::routes();
    Route::get('change-locale/{currentRouteName}', [App\Http\Controllers\HomeController::class, 'changeLocale'])->name('change-locale');
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get(AppService::trans('about-us'), [App\Http\Controllers\HomeController::class, 'aboutUs'])->name('about-us');
    Route::get(AppService::trans('contact'), [App\Http\Controllers\HomeController::class, 'contact'])->name('contact');
});

$locale = Cookie::get('locale') ?: request()->getDefaultLocale();

Route::redirect('/', "/$locale");
