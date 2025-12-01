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
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'nama' => 'Admin User',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'no_hp' => '081234567890',
                'institusi' => 'Admin Institute',
            ]
        );

        User::firstOrCreate(
            ['email' => 'organizer@example.com'],
            [
                'nama' => 'Organizer User',
                'password' => Hash::make('password'),
                'role' => 'organizer',
                'no_hp' => '081234567891',
                'institusi' => 'Organizer Institute',
            ]
        );

        User::firstOrCreate(
            ['email' => 'participant@example.com'],
            [
                'nama' => 'Participant User',
                'password' => Hash::make('password'),
                'role' => 'participant',
                'no_hp' => '081234567892',
                'institusi' => 'Participant Institute',
            ]
        );
        for ($i = 1; $i <= 30; $i++) {
            User::firstOrCreate(
                ['email' => "participant$i@example.com"],
                [
                    'nama' => "Participant $i",
                    'password' => Hash::make('password'),
                    'role' => 'participant',
                    'no_hp' => "08" . rand(1000000000, 9999999999),
                    'institusi' => "Institute " . chr(64 + (($i - 1) % 26) + 1),
                ]
            );
        }
    }
}
