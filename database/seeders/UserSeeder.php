<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'nama' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'no_hp' => '081234567890',
            'institusi' => 'Admin Institute',
        ]);

        User::create([
            'nama' => 'Organizer User',
            'email' => 'organizer@example.com',
            'password' => Hash::make('password'),
            'role' => 'organizer',
            'no_hp' => '081234567891',
            'institusi' => 'Organizer Institute',
        ]);

        User::create([
            'nama' => 'Participant User',
            'email' => 'participant@example.com',
            'password' => Hash::make('password'),
            'role' => 'participant',
            'no_hp' => '081234567892',
            'institusi' => 'Participant Institute',
        ]);
    }
}
