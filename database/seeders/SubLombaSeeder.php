<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubLombaSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('sub_lomba')->insert([
            [
                'event_id' => 1,
                'nama' => 'Frontend Development',
                'kategori' => 'Web',
                'deskripsi' => 'Kategori untuk pengembangan frontend website',
                'link' => 'https://example.com/lomba1',
                'deadline' => '2025-02-01',
                'gambar' => null,
                'status' => 'open',
                'jenis_sublomba' => 'berbayar',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'event_id' => 1,
                'nama' => 'Backend Development',
                'kategori' => 'Web',
                'deskripsi' => 'Kategori untuk pengembangan backend website',
                'link' => 'https://example.com/lomba2',
                'deadline' => '2025-02-05',
                'gambar' => null,
                'status' => 'open',
                'jenis_sublomba' => 'gratis',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'event_id' => 2,
                'nama' => 'Android Development',
                'kategori' => 'Mobile',
                'deskripsi' => 'Kategori untuk pengembangan aplikasi Android',
                'link' => 'https://example.com/lomba3',
                'deadline' => '2025-03-01',
                'gambar' => null,
                'status' => 'open',
                'jenis_sublomba' => 'berbayar',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
