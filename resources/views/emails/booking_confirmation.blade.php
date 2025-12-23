<p>Hi {{ $appointment->candidate->full_name }},</p>

<p>Thanks — your interview is confirmed.</p>

<p>
    <strong>Department:</strong> {{ $appointment->interviewSlot->department->name }}<br>
    <strong>Date:</strong> {{ $appointment->interviewSlot->date }}<br>
    <strong>Time:</strong> {{ $appointment->interviewSlot->start_time }} - {{ $appointment->interviewSlot->end_time }}
</p>

<p>If you need to cancel, please contact the organizer.</p>

<p>Best regards,<br>Interview Scheduler</p>
