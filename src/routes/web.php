<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProfileController;

Route::get('/', [ItemController::class, 'index']);

Route::middleware(['auth'])->group(function() {
    //プロフィール設定画面
    Route::get('/mypage/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    //プロフィール更新処理
    Route::post('/mypage/profile', [ProfileController::class, 'update'])->name('profile.update');
});