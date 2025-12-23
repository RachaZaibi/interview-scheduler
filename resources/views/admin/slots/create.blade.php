@extends('layouts.admin')

@section('content')
<h3 class="mb-4">Create New Interview Slot</h3>

{{-- Display validation errors --}}
@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('admin.slots.store') }}">
    @csrf

    <div class="mb-3">
        <label class="form-label">Department</label>
        <select name="department_id" class="form-control" required>
            <option value="">Select Department</option>
            @foreach($departments as $department)
                <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>
                    {{ $department->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Date</label>
        <input type="date" name="date" class="form-control" value="{{ old('date') }}" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Start Time</label>
        <input type="time" name="start_time" class="form-control" value="{{ old('start_time') }}" required>
    </div>

    <div class="mb-3">
        <label class="form-label">End Time</label>
        <input type="time" name="end_time" class="form-control" value="{{ old('end_time') }}" required>
    </div>

    <button type="submit" class="btn btn-success">Create Slot</button>
    <a href="{{ route('admin.slots.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection
