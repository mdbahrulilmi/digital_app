<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramSchedule extends Model
{
    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    
    public function tasks()
    {
        return $this->hasMany(\App\Models\Task::class, 'date', 'date')
                    ->whereColumn('program_id', 'program_id');
    }
}
