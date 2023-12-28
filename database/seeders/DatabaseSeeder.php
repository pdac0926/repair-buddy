<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'firstName' => 'Pablo',
            'middleName' => 'Donmari',
            'lastName' => 'Cabilitazan',
            'address' => 'Baguio City Philippines',
            'phoneNumber' => '09345678543',
            'email' => 'pablo.admin@repairbuddy.com',
            'password' => Hash::make('pablo.admin@repairbuddy.com'),
            'role' => 'admin',
            'privacyPolicy' => true,
            'status' => true,
        ]);
    }
}
