<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['item_id', 'user_id'];
    
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}