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
    Route::get('/', [PostController::class, 'index'])->name('posts.index'); // 投稿の一覧表示
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create'); // 投稿作成フォームの表示
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store'); // 投稿データの保存
    Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show'); // 個別投稿の表示
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update'); // 投稿データの更新
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy'); // 投稿の削除
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit'); // 投稿編集フォームの表示
    Route::post('/posts/{post}/like', [PostController::class, 'storeLike'])->name('posts.like'); // いいね機能のルート
});

// ChatControllerに関連するルート定義
Route::get('/chat/{user}', [ChatController::class, 'openChat']);


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
