@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Admin – Appointments</h3>
</div>

<table class="table table-striped">
    <thead>
        <tr>
            <th>Date</th>
            <th>Time</th>
            <th>Department</th>
            <th>Candidate</th>
            <th>Email</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @forelse($appointments as $appointment)
        <tr>
            <td>{{ $appointment->interviewSlot->date }}</td>
            <td>{{ $appointment->interviewSlot->start_time }} - {{ $appointment->interviewSlot->end_time }}</td>
            <td>{{ $appointment->interviewSlot->department->name }}</td>
            <td>{{ $appointment->candidate->full_name }}</td>
            <td>{{ $appointment->candidate->email }}</td>
            <td class="text-end">
                <a href="{{ route('admin.appointments.show', $appointment) }}" class="btn btn-sm btn-outline-primary">View</a>

                <form action="{{ route('admin.appointments.destroy', $appointment) }}" method="POST" class="d-inline-block ms-1" onsubmit="return confirm('Cancel this appointment?');">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger">Cancel</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6" class="text-center">No appointments found.</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection
