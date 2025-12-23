<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        User::updateOrCreate(
            ['email' => 'smartlab.fmm@gmail.com'],
            [
                'name'      => 'System Admin',
                'password'  => Hash::make('smartlab.fmm@25$'),
                'is_admin'  => true,
            ]
        );
    }
}
