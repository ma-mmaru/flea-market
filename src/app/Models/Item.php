<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'brand',
        'price',
        'description',
        'image_url',
        'condition',
    ];
    
    //マイリスト（いいね）のリレーション
    public function likes()
    {
        return $this->belongsToMany(User::class, 'likes', 'item_id', 'user_id')->withTimestamps();
        
    }
    //購入済み判定(ordersテーブルにレコードがあるか)
    public function isSold(): bool
    {
        return $this->order()->exists();
    }
    //商品は１つの注文をもつ（1対1のリレーション）
    public function order()
    {
        return $this->hasOne(Order::class);
    }
    //カテゴリとのリレーション
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'categories_items');
    }
}