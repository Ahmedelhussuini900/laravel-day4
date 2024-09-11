<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});



// Auth routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
});

Auth::routes();

// Post routes
Route::resource('posts', PostController::class);

// Post management routes
Route::get('/posts/{id}/confirm-delete', [PostController::class, 'confirmDelete'])->name('posts.confirmDelete');
Route::delete('/posts/{id}', [PostController::class, 'destroy'])->name('posts.destroy');
Route::get('/posts/{id}/restore', [PostController::class, 'restore'])->name('posts.restore');

// Comment routes
Route::post('/posts/{postId}/comments', [CommentController::class, 'storeComment'])->name('comments.store');

// Home route
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
