<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

// ダッシュボードへのルート定義
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// PostControllerに関連するルートのグループ定義
Route::controller(PostController::class)->middleware(['auth'])->group(function(){
    Route::get('/', 'index')->name('posts.index'); // 投稿の一覧表示
    Route::get('/posts/create', 'create')->name('posts.create'); // 投稿作成フォームの表示
    Route::post('/posts', 'store')->name('posts.store'); // 投稿データの保存
    Route::get('/posts/{post}', 'show')->name('posts.show'); // 個別投稿の表示
    Route::put('/posts/{post}', 'update')->name('posts.update'); // 投稿データの更新
    Route::delete('/posts/{post}', 'destroy')->name('posts.destroy'); // 投稿の削除
    Route::get('/posts/{post}/edit', 'edit')->name('posts.edit'); // 投稿編集フォームの表示
});

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

