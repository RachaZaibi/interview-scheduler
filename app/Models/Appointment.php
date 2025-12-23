<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'candidate_id',
        'interview_slot_id',
        'status',
    ];

    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }

    public function interviewSlot()
    {
        return $this->belongsTo(InterviewSlot::class);
    }
}
