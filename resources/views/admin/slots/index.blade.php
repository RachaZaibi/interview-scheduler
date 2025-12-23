@extends('layouts.app')

@section('content')
<h3 class="mb-4">Admin – Interview Slots</h3>

{{-- Success message --}}
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<a href="{{ route('admin.slots.create') }}" class="btn btn-primary mb-3">+ Create Slot</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Date</th>
            <th>Time</th>
            <th>Department</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @forelse($slots as $slot)
        <tr>
            <td>{{ $slot->date }}</td>
            <td>{{ $slot->start_time }} - {{ $slot->end_time }}</td>
            <td>{{ $slot->department->name }}</td>
            <td>
                @if($slot->is_booked)
                    <span class="badge bg-danger">Booked</span>
                @else
                    <span class="badge bg-success">Available</span>
                @endif
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="4" class="text-center">No slots found.</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection
