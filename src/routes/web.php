<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;

//誰でもアクセス可能
Route::get('/', [ItemController::class, 'index'])->name('item.index');
//商品詳細(未ログインでも閲覧可)
Route::get('/item/{item}', [ItemController::class, 'show'])->name('item.show');

//認証関連をここに実装

//認証が必要
Route::middleware(['auth'])->group(function()
{
    Route::get('/mypage', [ProfileController::class, 'index'])->name('mypage');
    //プロフィール設定画面
    Route::get('/mypage/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    //プロフィール更新処理
    Route::post('/mypage/profile', [ProfileController::class, 'update'])->name('profile.update');
    //出品機能
    Route::get('/sell', [ItemController::class, 'create'])->name('item.create');
    Route::post('/sell', [ItemController::class, 'store'])->name('item.store');
    //ログアウト機能をここに実装
    
    //いいね
    Route::post('/item/{item}/like', [LikeController::class, 'store'])->name('like.store');
    //コメント送信機能
    Route::post('/item/comment', [CommentController::class, 'store'])->name('comment.store');
    //購入手続き画面へ
    Route::get('/purchase/{item}', [ItemController::class, 'purchase'])->name('purchase.show');
});