<p>Hi {{ $appointment->candidate->full_name }},</p>

<p>Your interview for the {{ $appointment->interviewSlot->department->name }} department on 
{{ $appointment->interviewSlot->date }} at {{ $appointment->interviewSlot->start_time }} 
has been canceled.</p>

<p>If you have questions, please contact the organizer.</p>

<p>Best regards,<br>Interview Scheduler</p>
