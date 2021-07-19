<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\TopicsController;
use App\Http\Controllers\TopicConversationController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\UsersController;


use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

// For Postman - dev
Route::get('/token', function() {
    return csrf_token();
});

Route::middleware(['auth:sanctum', 'verified'])->group(function() {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::post('/', [TopicConversationController::class, 'store'])->name('conversation.store');
    Route::post('/topic/post', [TopicsController::class, 'store'])->name('topic.store');
    // Redirect from /topic/post
    Route::get('/topic/post', function() {
       return redirect('/');
    });
    Route::post('/topic/file', [TopicsController::class, 'storeTopicFileConversation'])->name('conversation.store.file');
    Route::get('/users', [HomeController::class, 'searchUser'])->name('search.user');

    Route::post('/add-contact', [ContactController::class, 'store'])->name('add.contact');

    Route::put('/users/conversations', [UsersController::class, 'switchConversation'])->name('switch.conversations');

    Route::get('/download/{filename}', [HomeController::class, 'download'])->name('download');

    // Get Image from Storage
    Route::get('/image-get/{filename}', function(String $filename) {
        $path = Storage::disk('local')->get('public/'.$filename);
        return response()->stream(function() use ($path) {
            echo $path;
        }, 200);
    });

});


// Dashboard - Jetstream
Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');
