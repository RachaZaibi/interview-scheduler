@extends('layouts.app')

@section('content')
<h3 class="mb-4">Appointment Details</h3>

<div class="card mb-3">
    <div class="card-body">
        <p><strong>Department:</strong> {{ $appointment->interviewSlot->department->name }}</p>
        <p><strong>Date:</strong> {{ $appointment->interviewSlot->date }}</p>
        <p><strong>Time:</strong> {{ $appointment->interviewSlot->start_time }} - {{ $appointment->interviewSlot->end_time }}</p>

        <hr>

        <p><strong>Name:</strong> {{ $appointment->candidate->full_name }}</p>
        <p><strong>Email:</strong> {{ $appointment->candidate->email }}</p>
        <p><strong>Phone:</strong> {{ $appointment->candidate->phone }}</p>
        <p><strong>University:</strong> {{ $appointment->candidate->university ?? '-' }}</p>

        <div class="mt-3">
            <form action="{{ route('admin.appointments.destroy', $appointment) }}" method="POST" onsubmit="return confirm('Cancel this appointment?');">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger">Cancel Appointment</button>
                <a href="{{ route('admin.appointments.index') }}" class="btn btn-secondary ms-2">Back</a>
            </form>
        </div>
    </div>
</div>
@endsection
