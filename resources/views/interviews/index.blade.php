@extends('layouts.app')

@section('content')
<h3 class="mb-4">Available Interview Slots</h3>

@if($slots->count() === 0)
    <div class="alert alert-warning">
        No interview slots available at the moment.
    </div>
@endif

<div class="row">
@foreach($slots as $slot)
    <div class="col-md-4 mb-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">
                    {{ $slot->department->name }} Department
                </h5>

                <p class="card-text">
                    <strong>Date:</strong> {{ $slot->date }}<br>
                    <strong>Time:</strong> {{ $slot->start_time }} - {{ $slot->end_time }}
                </p>

                <a href="{{ url('/interviews/book/'.$slot->id) }}" class="btn btn-primary">
                    Book Slot
                </a>
            </div>
        </div>
    </div>
@endforeach
</div>
@endsection
