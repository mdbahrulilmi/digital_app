<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberProduct extends Model
{
    protected $fillable = [
        'member_id',
        'product_id',
        'order_id',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }
}