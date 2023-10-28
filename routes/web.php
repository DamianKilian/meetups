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

Route::post('update-user', [App\Http\Controllers\UserPanelController::class, 'updateUser'])->name('update-user');
Route::post('change-pass', [App\Http\Controllers\UserPanelController::class, 'changePass'])->name('change-pass');
Route::post('priv-message', [App\Http\Controllers\UserPanelController::class, 'privMessage'])->name('priv-message');
Route::post('get-priv-talk', [App\Http\Controllers\UserPanelController::class, 'getPrivTalk'])->name('get-priv-talk');
Route::post('get-priv-messages', [App\Http\Controllers\UserPanelController::class, 'getPrivMessages'])->name('get-priv-messages');

$urlsWithoutPrefix = [
    'broadcasting/auth',
];

if(false === array_search(request()->path(), $urlsWithoutPrefix)){
    AppService::setLocaleFromPrefix();
}

Route::group(['prefix' => '{__locale}'], function () {
    Auth::routes();
    Route::get('change-locale/{currentRouteName}', [App\Http\Controllers\HomeController::class, 'changeLocale'])->name('change-locale');
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get(AppService::trans('about-us'), [App\Http\Controllers\HomeController::class, 'aboutUs'])->name('about-us');
    Route::get(AppService::trans('contact'), [App\Http\Controllers\HomeController::class, 'contact'])->name('contact');
    Route::get(AppService::trans('user-panel'), [App\Http\Controllers\UserPanelController::class, 'userPanel'])->name('user-panel');
});

$locale = Cookie::get('locale') ?: request()->getDefaultLocale();

Route::redirect('/', "/$locale");
