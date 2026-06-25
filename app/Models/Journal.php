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

   public function getSubmissionAttribute()
    {
        return TaskSubmission::where(
            'program_schedule_id',
            $this->program_schedule_id
        )
        ->where(
            'member_id',
            $this->member_id
        )
        ->first();
    }
}
