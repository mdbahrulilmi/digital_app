<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $guarded = [];

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'order_id');
    }
}
