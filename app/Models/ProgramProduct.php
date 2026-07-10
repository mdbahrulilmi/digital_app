<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramProduct extends Model
{
    protected $guarded = [];

    public function schedule()
    {
        return $this->belongsTo(ProgramSchedule::class, 'program_schedule_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}