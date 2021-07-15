<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\TopicConversationController;


use Inertia\Inertia;

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

Route::get('/token', function() {
    return csrf_token();
});



Route::middleware(['auth:sanctum', 'verified'])->group(function() {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::post('/topic/post', [TopicController::class, 'store'])->name('topic.store');
    Route::post('/', [TopicConversationController::class, 'store'])->name('conversation.store');
    Route::get('/users', [HomeController::class, 'searchUser'])->name('search.user');
});



Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');
