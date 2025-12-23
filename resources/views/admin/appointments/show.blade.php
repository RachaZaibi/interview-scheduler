@extends('layouts.admin')

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

        <p><strong>Status:</strong>
            @if($appointment->status == 'scheduled')
                <span class="badge bg-primary">Scheduled</span>
            @elseif($appointment->status == 'done')
                <span class="badge bg-success">Done</span>
            @elseif($appointment->status == 'canceled')
                <span class="badge bg-danger">Canceled</span>
            @elseif($appointment->status == 'no_show')
                <span class="badge bg-warning text-dark">No Show</span>
            @endif
        </p>

        <div class="mt-3">
            @if($appointment->status != 'done')
                <form action="{{ route('admin.appointments.done', $appointment) }}" method="POST" class="d-inline">
                    @csrf
                    <button class="btn btn-success">Mark Done</button>
                </form>
            @endif
            @if($appointment->status != 'no_show')
                <form action="{{ route('admin.appointments.no_show', $appointment) }}" method="POST" class="d-inline">
                    @csrf
                    <button class="btn btn-warning">No Show</button>
                </form>
            @endif
            @if($appointment->status != 'canceled')
                <form action="{{ route('admin.appointments.cancel', $appointment) }}" method="POST" class="d-inline" onsubmit="return confirm('Cancel this appointment?');">
                    @csrf
                    <button class="btn btn-danger">Cancel</button>
                </form>
            @endif

            <a href="{{ route('admin.appointments.index') }}" class="btn btn-secondary ms-2">Back</a>
        </div>
    </div>
</div>
@endsection
