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

//Route::post('/auth/login', [App\Http\Controllers\Api\AuthController::class, 'login'])->name('api_login');
//Route::post('/auth/register', [App\Http\Controllers\Api\AuthController::class, 'register'])->name('api_register');
//
//Route::get('/verify-account', [App\Http\Controllers\AuthController::class, 'verifyAccount'])->name('verify_account');
//Route::post('/recover-password', [App\Http\Controllers\AuthController::class, 'recoverPassword'])->name('recover_password');
//Route::post('/reset-password', [App\Http\Controllers\AuthController::class, 'resetPassword'])->name('reset_password');

//// public routes
//Route::get('me', 'User\MeController@getMe');
//
//// authenticated only
//Route::group(['middleware' => ['auth:api']], function() {
//    Route::post('logout', 'Auth\LoginController@logout');
//
//    Route::put('settings/profile', 'User\SettingsController@updateProfile');
//    Route::put('settings/password', 'User\SettingsController@updatePassword');
//});

// guests only
//Route::group(['middleware' => ['guest:api']], function() {
    Route::post('auth/register', 'App\Http\Controllers\Auth\AuthController@register');
//    Route::post('verification/verify/{user}', 'Auth\VerificationController@verify')->name('verification.verify');
//    Route::post('verification/resend/{user}', 'Auth\VerificationController@resend');
    Route::post('auth/login', 'App\Http\Controllers\Auth\AuthController@login');
    Route::post('auth/recover-password', 'App\Http\Controllers\Auth\ResetPasswordController@sendResetLinkEmail');
//    Route::post('password/reset', 'Auth\ResetPasswordController@reset');
//});
