<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('find-meetups', [App\Http\Controllers\HomeController::class, 'findMeetups'])->name('find-meetups');
Route::post('get-regions', [App\Http\Controllers\HomeController::class, 'getRegions'])->name('get-regions');
