<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\InterviewSlot;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SlotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = Department::all();

        foreach ($departments as $department) {
            for ($d = 1; $d <= 3; $d++) {
                InterviewSlot::create([
                    'department_id' => $department->id,
                    'date' => now()->addDays($d)->toDateString(),
                    'start_time' => '09:00:00',
                    'end_time' => '09:30:00',
                ]);

                InterviewSlot::create([
                    'department_id' => $department->id,
                    'date' => now()->addDays($d)->toDateString(),
                    'start_time' => '10:00:00',
                    'end_time' => '10:30:00',
                ]);
            }
        }
    }
}
