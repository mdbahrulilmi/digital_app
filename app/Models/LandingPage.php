<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LandingPage extends Model
{
    protected $fillable = ['title', 'slug', 'description', 'home', 'cart', 'blog','status'];

    /**
     * Relasi ke seksi-seksi di dalamnya, otomatis diurutkan berdasarkan 'sort_order'
     */
    public function sections(): HasMany
    {
        return $this->hasMany(LandingPageSection::class, 'landing_page_id')->orderBy('sort_order', 'asc');
    }
}