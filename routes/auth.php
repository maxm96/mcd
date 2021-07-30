<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

Route::get('/login', [LoginController::class, 'index'])->name('login.get');

Route::post('/login', [LoginController::class, 'login'])->name('login.post');

Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', function () {
    return 'register!';
})->name('register');

Route::get('/account_settings', function () {
    return 'account settings!';
})->name('account_settings');
