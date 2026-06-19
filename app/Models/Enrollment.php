<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    protected $guarded = [];

    public function members()
    {
        return $this->belongsToMany(Member::class, 'enrollments', 'program_id', 'member_id')
                    ->withTimestamps();
    }

    public function programs()
    {
        return $this->belongsToMany(Program::class, 'enrollments', 'member_id', 'program_id')
                    ->withTimestamps();
    }
}
