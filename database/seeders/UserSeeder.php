<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@firefinance.id'],
            [
                'name' => 'Admin FireFinance',
                'phone_number' => '+62812345678',
                'password' => Hash::make('password'),
                'role_name' => 'admin',
                'status' => 'Active',
                'join_date' => now(),
            ]
        );

        User::firstOrCreate(
            ['email' => 'budi@example.com'],
            [
                'name' => 'Budi Santoso',
                'phone_number' => '+62811223344',
                'password' => Hash::make('password'),
                'role_name' => 'client',
                'status' => 'Active',
                'join_date' => now(),
            ]
        );

        User::firstOrCreate(
            ['email' => 'siti@example.com'],
            [
                'name' => 'Siti Rahayu',
                'phone_number' => '+62899887766',
                'password' => Hash::make('password'),
                'role_name' => 'client',
                'status' => 'Active',
                'join_date' => now(),
            ]
        );

        // Generate 10 random clients
        User::factory(10)->create([
            'role_name' => 'client',
            'status' => 'Active',
            'join_date' => now(),
        ]);
    }
}
