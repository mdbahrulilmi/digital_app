<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'title',
        'type',
        'slug',
        'description',
        'price',
        'stock',
        'image',
        'image_source',
        'asset_source',
        'digital_assets',
        'status',
    ];

    protected $casts = [
        'digital_assets' => 'array',
        'price' => 'integer',
        'stock' => 'integer',
    ];
}   