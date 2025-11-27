<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PengumumanSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pengumuman')->insert([
            [
                'events_id' => 1,
                'judul' => 'Pendaftaran Dibuka',
                'isi' => 'Pendaftaran untuk Kompetisi Web Development 2025 telah dibuka. Segera daftarkan tim Anda sebelum batas waktu.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'events_id' => 1,
                'judul' => 'Pengumuman Hasil Penilaian',
                'isi' => 'Hasil penilaian untuk semua kategori telah diumumkan. Selamat kepada semua pemenang!',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
