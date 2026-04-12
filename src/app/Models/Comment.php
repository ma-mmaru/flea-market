<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'item_id',
        'content',
    ];
    //コメントは一人のユーザーに属する
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    //コメントは一つの商品に属する
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}