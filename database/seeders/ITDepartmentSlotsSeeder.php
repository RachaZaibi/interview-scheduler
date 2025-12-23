<?php

namespace Database\Seeders;

use App\Models\InterviewSlot;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ITDepartmentSlotsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // IT Department ID (adjust if different)
        $departmentId = 1;

        // Date range: next 2 weeks (adjust as needed)
        $startDate = Carbon::tomorrow();
        $endDate = Carbon::today()->addWeeks(2);

        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {

            // Skip Saturday (6) and Sunday (0)
            if (in_array($date->dayOfWeek, [0, 6])) {
                continue;
            }

            $startTime = Carbon::createFromTime(10, 0, 0); // 10:00
            $endTime   = Carbon::createFromTime(15, 0, 0); // 15:00

            while ($startTime->lt($endTime)) {
                $slotEnd = $startTime->copy()->addMinutes(15);

                // Create slot
                InterviewSlot::create([
                    'department_id' => $departmentId,
                    'date'          => $date->toDateString(),
                    'start_time'    => $startTime->format('H:i:s'),
                    'end_time'      => $slotEnd->format('H:i:s'),
                    'is_booked'     => false,
                ]);

                // Add 15 minutes gap
                $startTime->addMinutes(30);
            }
        }

        $this->command->info('IT Department slots seeded successfully.');
    }
}
