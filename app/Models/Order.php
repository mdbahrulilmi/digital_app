<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_id',
        'customer_name',
        'customer_whatsapp',
        'customer_address',
        'amount',
        'payment_method',
        'cart_snapshot',
        'status',
    ];

    protected $casts = [
        'cart_snapshot' => 'array',
    ];
}
