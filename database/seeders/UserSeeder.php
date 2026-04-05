<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin FireFinance',
            'email' => 'admin@firefinance.id',
            'phone_number' => '+62812345678',
            'password' => Hash::make('password'),
            'role_name' => 'admin',
            'status' => 'Active',
            'join_date' => now(),
        ]);

        User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'phone_number' => '+62811223344',
            'password' => Hash::make('password'),
            'role_name' => 'client',
            'status' => 'Active',
            'join_date' => now(),
        ]);

        User::create([
            'name' => 'Siti Rahayu',
            'email' => 'siti@example.com',
            'phone_number' => '+62899887766',
            'password' => Hash::make('password'),
            'role_name' => 'client',
            'status' => 'Active',
            'join_date' => now(),
        ]);
    }
}
