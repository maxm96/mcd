<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ChatController;
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
Route::get('/home/get_posts/{page}/{count}', [HomeController::class, 'getPosts'])->name('home.get_posts');
Route::post('/home', [HomeController::class, 'submitPost'])
    ->name('home.submit_post')
    ->withoutMiddleware('auth');
Route::post('/home/comment', [HomeController::class, 'submitComment'])->name('home.submit_comment');

Route::group(['middleware' => 'user-is-logged-in'], function () {
    Route::get('/chat', [ChatController::class, 'index'])->name('chat')->middleware('user-is-logged-in');
    Route::post('/chat', [ChatController::class, 'postChat'])->name('chat.post');
});

Route::get('/boards', function () {
    return 'Boards';
})->name('boards');

include __DIR__ . '/auth.php';
