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
}
