<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LandingPageSection extends Model
{
    protected $guarded = [];

    /**
     * Otomatis melakukan casting data JSON ke Array PHP saat dipanggil
     */
    protected $casts = [
        'content' => 'array',
        'is_visible' => 'boolean',
        'sort_order' => 'integer'
    ];

    /**
     * Relasi balik ke Landing Page utama
     */
    public function landingPage(): BelongsTo
    {
        return $this->belongsTo(LandingPage::class);
    }

    public function components()
    {
        return $this->hasMany(LandingPageComponent::class,'section_id')
            ->orderBy('sort_order');
    }
}