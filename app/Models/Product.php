<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'stock',
        'image',
        'digital_assets',
        'status',
    ];

    protected $casts = [
        'digital_assets' => 'array',
        'price' => 'integer',
        'stock' => 'integer',
    ];
}   