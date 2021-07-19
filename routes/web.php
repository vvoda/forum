<?php

use App\Http\Controllers\CmsController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\TopicsController;
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

Route::get('/register', function() {

})->middleware('auth:sanctum' ,'admin');

Route::middleware(['auth:sanctum', 'verified'])->group(function() {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::post('/topic/post', [TopicsController::class, 'store'])->name('topic.store');
    Route::post('/', [TopicConversationController::class, 'store'])->name('conversation.store');
    Route::post('/topic/file', [TopicsController::class, 'storeTopicFileConversation'])->name('conversation.store.file');
    Route::get('/users', [HomeController::class, 'searchUser'])->name('search.user');
    Route::get('/download/{filename}', [HomeController::class, 'download'])->name('download');
});

Route::middleware(['auth:sanctum', 'verified', 'admin'])->group(function() {
    Route::get('/cms', [CmsController::class, 'dashboard'])->name('cms.dashboard');
    Route::get('/cms/register', [CmsController::class, 'create'])->name('cms.create');
    Route::post('/cms/register', [CmsController::class, 'register'])->name('cms.register');
    Route::get('/cms/search', [CmsController::class, 'search'])->name('cms.search');
});


Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');
