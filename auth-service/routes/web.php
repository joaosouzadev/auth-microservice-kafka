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

Route::get('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

Route::group(['middleware' => ['guest']], function () {
    Route::get('/', function () {
        return view('homepage');
    });

    Route::get('/login', function () {
        return view('auth.login');
    });

    Route::get('/register', function () {
        return view('auth.register');
    });

    Route::get('/recover-password', function () {
        return view('auth.recover-password');
    });

    Route::get('/verify-account', [App\Http\Controllers\AuthController::class, 'verifyAccount'])->name('verify_account');
    Route::post('/recover-password', [App\Http\Controllers\AuthController::class, 'recoverPassword'])->name('recover_password');
    Route::get('/reset-password', [App\Http\Controllers\AuthController::class, 'resetPasswordView'])->name('reset_password_view');
    Route::post('/reset-password', [App\Http\Controllers\AuthController::class, 'resetPassword'])->name('reset_password');

    Route::post('/register', [App\Http\Controllers\AuthController::class, 'register'])->name('register');
    Route::post('/login', [App\Http\Controllers\AuthController::class, 'login'])->name('login');
});

Route::prefix('app')->middleware(['auth'])->group(function () {
    Route::get('/home', function () {
        return view('app.home');
    })->name('home');
});
