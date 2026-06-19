<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Zoom extends Model
{
    protected $fillable = ['program_id', 'date', 'start_time', 'end_time', 'url'];
}
