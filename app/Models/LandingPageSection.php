<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LandingPageSection extends Model
{
    protected $fillable = [
        'landing_page_id', 
        'name', 
        'type', 
        'content', 
        'sort_order', 
        'is_visible'
    ];

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
}