<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProfileController;

//誰でもアクセス可能
Route::get('/', [ItemController::class, 'index'])->name('item.index');

//認証関連をここに実装

//認証が必要
Route::middleware(['auth'])->group(function()
{
    Route::get('/mypage', [ProfileController::class, 'index'])->name('login');
    //プロフィール設定画面
    Route::get('/mypage/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    //プロフィール更新処理
    Route::post('/mypage/profile', [ProfileController::class, 'update'])->name('profile.update');
    //出品機能
    Route::get('/sell', [ItemController::class, 'create'])->name('item.create');
    Route::get('/sell', [ItemController::class, 'store'])->name('item.store');
    //ログアウト機能をここに実装
});