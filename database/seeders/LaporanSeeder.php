<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LaporanSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('laporan')->insert([
            [
                'pelapor_id' => 3,
                'events_id' => 1,
                'judul' => 'Laporan Teknis Error',
                'deskripsi' => 'Ada error pada halaman pendaftaran saat mengupload file.',
                'status' => 'pending',
                'bukti' => null,
                'tanggapan' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
