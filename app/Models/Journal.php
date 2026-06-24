<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    protected $guarded = [];

    public function programSchedule()
    {
        return $this->belongsTo(ProgramSchedule::class);
    }

   public function submission() 
    {
        return $this->hasOne(\App\Models\TaskSubmission::class, 'program_schedule_id', 'program_schedule_id')
                ->where('member_id', $this->member_id);
    }
}
