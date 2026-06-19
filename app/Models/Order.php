<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_id',
        'customer_name',
        'customer_email',
        'customer_whatsapp',
        'customer_address',
        'amount',
        'payment_method',
        'payment_code',
        'cart_snapshot',
        'status',
    ];

    protected $casts = [
        'cart_snapshot' => 'array',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'order_id');
    }
}
