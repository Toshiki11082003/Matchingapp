<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ChatController;
use Illuminate\Support\Facades\Route;

// ダッシュボードへのルート定義
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// PostControllerに関連するルートのグループ定義
Route::middleware(['auth'])->group(function(){
    Route::get('/', [PostController::class, 'index'])->name('posts.index');
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::post('/posts/{post}/like', [PostController::class, 'storeLike'])->name('posts.like');
});

// ChatControllerに関連するルート定義
//Route::get('/chat/{post}/{user}', [ChatController::class, 'openChat']);
Route::post('/chat', [ChatController::class, 'sendMessage']);
Route::get('/chat/{post}/{user}', [ChatController::class, 'openChat']);

// カテゴリーに関連するルート定義
Route::get('/categories/{category}', [CategoryController::class, 'index'])->middleware("auth");

// プロファイル編集に関連するルートのグループ定義
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 認証関連のルート定義
require __DIR__.'/auth.php';
