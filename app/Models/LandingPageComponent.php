<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LandingPageComponent extends Model
{
    protected $guarded = [];

    public function section()
    {
        return $this->belongsTo(LandingPageSection::class);
    }

    protected $casts = [
        'content' => 'array',
        'is_visible' => 'boolean',
        'sort_order' => 'integer',
    ];
}
