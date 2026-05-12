<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'item_id',
        'user_id',
        'payment_method',
        'price',
        'shipping_postal_code',
        'shipping_address',
        'shipping_building',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}