<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingConfirmation;
use App\Models\InterviewSlot;
use App\Models\Department;

class BookingTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_book_slot()
    {
        Mail::fake();

        // Create department and slot
        Department::insert([
            ['name' => 'IT', 'created_at' => now(), 'updated_at' => now()]
        ]);

        $department = Department::first();

        $slot = InterviewSlot::create([
            'department_id' => $department->id,
            'date' => now()->addDays(1)->toDateString(),
            'start_time' => '09:00:00',
            'end_time' => '09:30:00',
        ]);

        $payload = [
            'slot_id' => $slot->id,
            'full_name' => 'Test Candidate',
            'email' => 'candidate@example.com',
            'phone' => '555-1234',
            'university' => 'Test University'
        ];

        $response = $this->post('/interviews/book', $payload);

        $response->assertRedirect('/interviews');

        $this->assertDatabaseHas('candidates', ['email' => 'candidate@example.com']);
        $this->assertDatabaseHas('interview_slots', ['id' => $slot->id, 'is_booked' => 1]);
        Mail::assertQueued(BookingConfirmation::class);
    }

    public function test_prevent_double_booking()
    {
        Department::insert([
            ['name' => 'HR', 'created_at' => now(), 'updated_at' => now()]
        ]);

        $department = Department::first();

        $slot = InterviewSlot::create([
            'department_id' => $department->id,
            'date' => now()->addDays(2)->toDateString(),
            'start_time' => '10:00:00',
            'end_time' => '10:30:00',
        ]);

        $payload = [
            'slot_id' => $slot->id,
            'full_name' => 'Alice',
            'email' => 'alice@example.com',
            'phone' => '555-0001',
        ];

        // First booking succeeds
        $first = $this->post('/interviews/book', $payload);
        $first->assertRedirect('/interviews');

        // Second booking attempt should fail with 409
        $second = $this->post('/interviews/book', $payload);
        $second->assertStatus(409);
    }
}
