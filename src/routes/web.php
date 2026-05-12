<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PurchaseController;

//誰でもアクセス可能
Route::get('/', [ItemController::class, 'index'])->name('item.index');
Route::get('/item/{item}', [ItemController::class, 'show'])->name('item.show');

//メール認証
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect()->route('profile.edit');
})->middleware(['auth', 'signed'])->name('verification.verify');
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('status', 'verification-link-sent');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

//メール認証が済んでいないとアクセス不可
Route::middleware(['auth', 'verified'])->group(function () {
    //プロフィール設定画面
    Route::get('/mypage/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    //プロフィール更新処理
    Route::post('/mypage/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/mypage', [ProfileController::class, 'index'])->name('mypage');
    //出品機能
    Route::get('/sell', [ItemController::class, 'create'])->name('exhibition.create');
    Route::post('/sell', [ItemController::class, 'store'])->name('exhibition.store');
    //いいね・コメント
    Route::post('/item/{item}/like', [LikeController::class, 'store'])->name('like.store');
    Route::post('/item/{item}/comment', [CommentController::class, 'store'])->name('comment.store');
    //購入
    Route::get('/purchase/{item}', [PurchaseController::class, 'show'])->name('purchase.show');
    Route::get('/purchase/address/{item}', [PurchaseController::class, 'editAddress'])->name('address.edit');
    Route::post('/purchase/address/{item}', [PurchaseController::class, 'updateAddress'])->name('address.update');
    Route::post('/purchase/{item}', [PurchaseController::class, 'store'])->name('purchase.store');
    Route::get('/purchase/success/{item}', [PurchaseController::class, 'success'])->name('purchase.success');
});