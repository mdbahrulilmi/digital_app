<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $guarded = [];

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function schedule()
    {
        return $this->belongsTo(ProgramSchedule::class, 'program_schedule_id');
    }   
}
