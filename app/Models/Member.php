<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; // WAJIB PAKAI INI
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Member extends Authenticatable
{
    use Notifiable;

    protected $guarded = [];

    protected $hidden = [
        'password',
    ];

    public function programs(): BelongsToMany
    {
        return $this->belongsToMany(Program::class, 'enrollments', 'member_id', 'program_id');
    }

    public function journals() {
        return $this->hasMany(Journal::class);
    }

    public function schedules()
    {
        return $this->hasManyThrough(
            ProgramSchedule::class,
            Enrollment::class,
            'member_id',
            'program_id',
            'id',
            'program_id'
        );
    }

    public function memberProducts()
    {
        return $this->hasMany(MemberProduct::class);
    }

    public function products()
    {
        return $this->belongsToMany(
            Product::class,
            'member_products'
        )->withTimestamps();
    }
}