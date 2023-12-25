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
            'firstName' => 'vencer',
            'middleName' => 'consul',
            'lastName' => 'olermo',
            'address' => 'Baguio City Philippines',
            'phoneNumber' => '09555845304',
            'email' => 'vencer@gmail.com',
            'password' => Hash::make('vencer@gmail.com'),
            'role' => 'admin',
            'privacyPolicy' => true,
            'status' => true,
        ]);
    }
}
