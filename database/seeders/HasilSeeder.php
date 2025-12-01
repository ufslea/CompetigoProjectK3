<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HasilSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('hasil')->insert([
            [
                'sublomba_id' => 1,
                'partisipan_id' => 1,
                'rank' => 1,
                'deskripsi' => 'Pemenang kategori Frontend Development',
                'gambar' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'sublomba_id' => 2,
                'partisipan_id' => 2,
                'rank' => 2,
                'deskripsi' => 'Peringkat 2 kategori Backend Development',
                'gambar' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
