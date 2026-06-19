<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Program extends Model
{
    protected $guarded = [];

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(Member::class, 'enrollments', 'program_id', 'member_id')
                    ->withTimestamps();
    }

    public function zooms()
    {
        return $this->hasMany(Zoom::class);
    }

    public function pages()
    {
        return $this->hasMany(LandingPage::class, 'program_id');
    }
}
