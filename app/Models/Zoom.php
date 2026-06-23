<?php

namespace App\Models;

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Zoom extends Model
{
    protected $fillable = ['program_id', 'title', 'date', 'start_time', 'end_time', 'url', 'recording_url'];

   public function getStatusAttribute()
    {
        $now = Carbon::now();
        $start = Carbon::parse($this->date . ' ' . $this->start_time);
        $end = Carbon::parse($this->date . ' ' . $this->end_time);

        if ($now->between($start, $end)) return 'live';
        if ($now->lt($start)) return 'upcoming';
        return 'past';
    }

    public function getAccessStatusAttribute()
    {
        $today = Carbon::today();
        $sessionDate = Carbon::parse($this->date);

        if ($today->isSameDay($sessionDate) || $today->copy()->addDay()->isSameDay($sessionDate)) {
            return 'zoom';
        }

        if ($sessionDate->isPast() && !$today->isSameDay($sessionDate)) {
            return 'recording';
        }

        return 'locked';
    }
}