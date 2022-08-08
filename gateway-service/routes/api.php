<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('register', 'App\Http\Controllers\Auth\AuthController@register');
Route::post('login', 'App\Http\Controllers\Auth\AuthController@login');
Route::post('recover-password', 'App\Http\Controllers\Auth\ResetPasswordController@sendResetLinkEmail');
Route::post('reset-password', 'App\Http\Controllers\Auth\ResetPasswordController@resetPassword');

//Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', [App\Http\Controllers\User\UserController::class, 'getUser'])->name('api_get_user');
    Route::put('/user', [App\Http\Controllers\User\UserController::class, 'updateUser'])->name('api_update_user');
//});
