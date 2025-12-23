<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InterviewSlot extends Model
{
    protected $fillable = [
        'department_id',
        'date',
        'start_time',
        'end_time',
        'is_booked'
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
