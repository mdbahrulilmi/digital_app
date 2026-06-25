<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LandingPage extends Model
{
    protected $guarded = [];

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