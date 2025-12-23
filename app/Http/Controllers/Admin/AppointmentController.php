<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\BookingCancellation;
use Illuminate\Http\Request;
use App\Models\Appointment;
use Illuminate\Support\Facades\Mail;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::with('candidate', 'interviewSlot.department')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.appointments.index', compact('appointments'));
    }

    public function show(Appointment $appointment)
    {
        $appointment->load('candidate', 'interviewSlot.department');

        return view('admin.appointments.show', compact('appointment'));
    }

    public function destroy(Appointment $appointment)
    {
        // Free the slot
        $slot = $appointment->interviewSlot;
        if ($slot) {
            $slot->update(['is_booked' => false]);
        }

        // Notify candidate of cancellation
        try {
            if ($appointment->candidate) {
                Mail::to($appointment->candidate->email)
                    ->send(new BookingCancellation($appointment));
            }
        } catch (\Exception $e) {
            logger()->error('Failed to send cancellation email: ' . $e->getMessage());
        }

        // Delete appointment
        $appointment->delete();

        return redirect()->route('admin.appointments.index')
            ->with('success', 'Appointment canceled.');
    }

}
