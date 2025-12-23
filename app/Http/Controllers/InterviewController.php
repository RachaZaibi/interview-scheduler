<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Models\InterviewSlot;
use App\Models\Candidate;
use App\Models\Appointment;
use App\Mail\BookingConfirmation;

class InterviewController extends Controller
{
    /**
     * Show available interview slots
     */
    public function index()
    {
        $slots = InterviewSlot::with('department')
            ->where('is_booked', false)
            ->orderBy('date')
            ->orderBy('start_time')
            ->get();

        return view('interviews.index', compact('slots'));
    }

    /**
     * Show booking form
     * Route Model Binding is used here
     */
    public function create(InterviewSlot $slot)
    {
        // Extra safety: prevent booking an already booked slot
        if ($slot->is_booked) {
            return redirect('/interviews')
                ->with('success', 'This slot is already booked.');
        }

        return view('interviews.book', compact('slot'));
    }

    /**
     * Store interview booking
     */
    public function store(Request $request)
    {
        $request->validate([
            'slot_id'     => 'required|exists:interview_slots,id',
            'full_name'   => 'required|string|max:150',
            'email'       => 'required|email|max:150',
            'phone'       => 'required|string|max:50',
            'university'  => 'nullable|string|max:150',
        ]);

        $result = DB::transaction(function () use ($request) {

            // Lock slot row to prevent double booking
            $slot = InterviewSlot::lockForUpdate()->find($request->slot_id);

            if ($slot->is_booked) {
                abort(409, 'Slot already booked');
            }

            // Create candidate
            $candidate = Candidate::create([
                'full_name'  => $request->full_name,
                'email'      => $request->email,
                'phone'      => $request->phone,
                'university' => $request->university,
            ]);

            // Create appointment
            $appointment = Appointment::create([
                'candidate_id'       => $candidate->id,
                'interview_slot_id'  => $slot->id,
            ]);

            // Mark slot as booked
            $slot->update([
                'is_booked' => true
            ]);

            return compact('candidate', 'appointment', 'slot');
        });

        // Queue booking confirmation email
        try {
            Mail::to($result['candidate']->email)->send(new BookingConfirmation($result['appointment']));
        } catch (\Exception $e) {
            // Log and continue (don't block user booking)
            logger()->error('Failed to queue booking confirmation email: ' . $e->getMessage());
        }

        return redirect('/interviews')
            ->with('success', 'Interview booked successfully.');
    }
}
