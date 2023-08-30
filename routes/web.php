<?php

use App\Services\AppService;
use Illuminate\Support\Facades\Lang;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();









// localized routes

AppService::setLocaleFromPrefix();
Route::group(['prefix' => '{locale}'], function () {
    Route::get(Lang::get('routes.home'), [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get(Lang::get('routes.about-us'), [App\Http\Controllers\HomeController::class, 'aboutUs'])->name('about-us');
    Route::get(Lang::get('routes.contact'), [App\Http\Controllers\HomeController::class, 'contact'])->name('about-us');
});
Route::redirect(Lang::get('routes.home'), 'en/' . Lang::get('routes.home'));
Route::redirect(Lang::get('routes.about-us'), 'en/' . Lang::get('routes.about-us'));
Route::redirect(Lang::get('routes.contact'), 'en/' . Lang::get('routes.contact'));
