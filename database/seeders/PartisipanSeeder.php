<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PartisipanSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('partisipans')->insert([
            [
                'user_id' => 3,
                'sublomba_id' => 1,
                'institusi' => 'University A',
                'kontak' => '081234567890',
                'file_karya' => null,
                'status' => 'pending',
                'registered_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 3,
                'sublomba_id' => 2,
                'institusi' => 'University A',
                'kontak' => '081234567890',
                'file_karya' => null,
                'status' => 'approved',
                'registered_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
