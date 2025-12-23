@extends('layouts.admin')

@section('content')
<h3 class="mb-4">Admin – Interview Slots</h3>

{{-- Success message --}}
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

{{-- Faild message --}}
@if(session('failed'))
    <div class="alert alert-warning">{{ session('failed') }}</div>
@endif

<a href="{{ route('admin.slots.create') }}" class="btn btn-primary mb-3">+ Create Slot</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Date</th>
            <th>Time</th>
            <th>Department</th>
            <th>Status</th>
            <th> </th>
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
            <td>
                <form action="{{ route('admin.slots.destroy', $slot) }}" method="POST" class="d-inline-block ms-1" onsubmit="return confirm('Delete this Slot?');">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger">Delete</button>
                </form>
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
