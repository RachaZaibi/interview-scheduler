@extends('layouts.app')

@section('content')
<h3 class="mb-4">Confirm Interview Slot</h3>

<div class="card mb-4">
    <div class="card-body">
        <p><strong>Department:</strong> {{ $slot->department->name }}</p>
        <p><strong>Date:</strong> {{ $slot->date }}</p>
        <p><strong>Time:</strong> {{ $slot->start_time }} - {{ $slot->end_time }}</p>
    </div>
</div>

<form method="POST" action="/interviews/book">
    @csrf

    <input type="hidden" name="slot_id" value="{{ $slot->id }}">

    <div class="mb-3">
        <label class="form-label">Full Name</label>
        <input type="text" name="full_name" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Phone</label>
        <input type="text" name="phone" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">University</label>
        <input type="text" name="university" class="form-control">
    </div>

    <button type="submit" class="btn btn-success">
        Confirm Booking
    </button>
</form>
@endsection
