<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Validation\ValidationException;

class LandingPage extends Model
{
    protected $guarded = [];

    public const RESERVED_SLUGS = [
        'admin', 'login', 'register', 'cart', 'checkout', 'payment', 'produk', 'member'
    ];

    protected static function booted()
    {
        static::saving(function ($landingPage) {
            if ($landingPage->slug && in_array($landingPage->slug, self::RESERVED_SLUGS)) {
                throw ValidationException::withMessages([
                    'slug' => 'Slug "' . $landingPage->slug . '" tidak diperbolehkan karena digunakan oleh sistem.'
                ]);
            }
        });
    }

    public function sections(): HasMany
    {
        return $this->hasMany(LandingPageSection::class, 'landing_page_id')->orderBy('sort_order', 'asc');
    }

    public function program_page()
    {
        return $this->belongsTo(LandingPage::class, 'program_page_id');
    }
    
    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id');
    }
}