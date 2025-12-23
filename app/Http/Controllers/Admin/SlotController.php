<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InterviewSlot;
use App\Models\Department;

class SlotController extends Controller
{
    /**
     * Display all interview slots
     */
    public function index()
    {
        $slots = InterviewSlot::with('department')
            ->orderBy('date')
            ->orderBy('start_time')
            ->get();

        return view('admin.slots.index', compact('slots'));
    }

    /**
     * Show form to create a new interview slot
     */
    public function create()
    {
        $departments = Department::orderBy('name')->get();

        return view('admin.slots.create', compact('departments'));
    }

    /**
     * Store a new interview slot
     */
    public function store(Request $request)
    {
        $request->validate([
            'department_id' => 'required|exists:departments,id',
            'date'          => 'required|date',
            'start_time'    => 'required',
            'end_time'      => 'required|after:start_time',
        ]);

        // Prevent duplicate slots
        $exists = InterviewSlot::where('department_id', $request->department_id)
            ->where('date', $request->date)
            ->where('start_time', $request->start_time)
            ->exists();

        if ($exists) {
            return back()
                ->withErrors(['start_time' => 'This interview slot already exists'])
                ->withInput();
        }

        InterviewSlot::create([
            'department_id' => $request->department_id,
            'date'          => $request->date,
            'start_time'    => $request->start_time,
            'end_time'      => $request->end_time,
        ]);

        return redirect('/admin/slots')
            ->with('success', 'Interview slot created successfully.');
    }

    public function destroy (InterviewSlot $slot ){
        if ($slot->appointment()->exists()) {
            return redirect()->route('admin.slots.index')
                ->with('failed', 'Cannot delete slot: an appointment is already booked.');
        }

        $slot->delete();
        
        return redirect()->route('admin.slots.index')
            ->with('success', 'Slot Deleted.');
    }
}
