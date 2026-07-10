<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramSchedule extends Model
{
    protected $guarded = [];

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function programProducts()
    {
        return $this->hasMany(ProgramProduct::class, 'program_schedule_id');
    }

    public function products()
    {
        return $this->hasManyThrough(
            Product::class, 
            ProgramProduct::class, 
            'program_schedule_id', 
            'id',
            'id',
            'product_id'
        );
    }
    
    public function tasks()
    {
        return $this->hasMany(Task::class, 'program_schedule_id');
    }
}
