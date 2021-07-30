<?php

use Illuminate\Support\Facades\Route;

Route::get('/login', function () {
    return 'Login!';
})->name('login');

Route::get('/register', function () {
    return 'register!';
})->name('register');

Route::get('/account_settings', function () {
    return 'account settings!';
})->name('account_settings');

Route::get('/logout', function () {
    return 'logout!';
})->name('logout');
