<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SertifikatSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('sertifikat')->insert([
            [
                'partisipan_id' => 1,
                'sublomba_id' => 1,
                'gambar' => 'sertifikat_1.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'partisipan_id' => 2,
                'sublomba_id' => 2,
                'gambar' => 'sertifikat_2.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
