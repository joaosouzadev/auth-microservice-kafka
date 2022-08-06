<?php

use Illuminate\Http\Request;
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

Route::post('/login', [App\Http\Controllers\AuthController::class, 'login'])->name('api_login');
Route::post('/register', [App\Http\Controllers\AuthController::class, 'register'])->name('api_register');
Route::post('/recover-password', [App\Http\Controllers\AuthController::class, 'sendResetLinkEmail'])->name('api_recover_password');
Route::post('/reset-password', [App\Http\Controllers\AuthController::class, 'resetPassword'])->name('api_reset_password');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', [App\Http\Controllers\UserController::class, 'getUser'])->name('api_get_user');
    Route::put('/user', [App\Http\Controllers\UserController::class, 'updateUser'])->name('api_update_user');
});
