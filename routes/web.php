<?php

use App\Http\Controllers\HomeController;
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

Route::get('/', function () {
    return redirect(route('home'));
});

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/home/get_posts', [HomeController::class, 'getPosts'])->name('home.get_posts');
Route::post('/home', [HomeController::class, 'submitPost'])
    ->name('home.submit_post')
    ->withoutMiddleware('auth');

Route::get('/chat', function () {
    return 'Chat';
})->name('chat');

Route::get('/boards', function () {
    return 'Boards';
})->name('boards');
