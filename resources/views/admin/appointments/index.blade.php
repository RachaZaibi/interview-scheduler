@extends('layouts.admin')

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
            <th>Status</th>
            <th class="text-end">Actions</th>
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
            <td>
                @if($appointment->status == 'scheduled')
                    <span class="badge bg-primary">Scheduled</span>
                @elseif($appointment->status == 'done')
                    <span class="badge bg-success">Done</span>
                @elseif($appointment->status == 'canceled')
                    <span class="badge bg-danger">Canceled</span>
                @elseif($appointment->status == 'no_show')
                    <span class="badge bg-warning text-dark">No Show</span>
                @endif
            </td>
            <td class="text-end">
                <a href="{{ route('admin.appointments.show', $appointment) }}" class="btn btn-sm btn-outline-primary">View</a>

                @if($appointment->status == 'scheduled')
                    <form action="{{ route('admin.appointments.done', $appointment) }}" method="POST" class="d-inline">
                        @csrf
                        <button class="btn btn-sm btn-success">Mark Done</button>
                    </form>
                    <form action="{{ route('admin.appointments.no_show', $appointment) }}" method="POST" class="d-inline ms-1">
                        @csrf
                        <button class="btn btn-sm btn-warning">No Show</button>
                    </form>
                    <form action="{{ route('admin.appointments.cancel', $appointment) }}" method="POST" class="d-inline ms-1" onsubmit="return confirm('Cancel this appointment?');">
                        @csrf
                        <button class="btn btn-sm btn-danger">Cancel</button>
                    </form>
                @endif

                <form action="{{ route('admin.appointments.destroy', $appointment) }}" method="POST" class="d-inline ms-1" onsubmit="return confirm('Delete this appointment?');">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-dark">Delete</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="7" class="text-center">No appointments found.</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection
