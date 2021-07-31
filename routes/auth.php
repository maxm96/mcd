<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;

Route::get('/login', [LoginController::class, 'index'])->name('login.get');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');

Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'index'])->name('register.get');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');

Route::get('/account_settings', function () {
    return 'account settings!';
})->name('account_settings');
