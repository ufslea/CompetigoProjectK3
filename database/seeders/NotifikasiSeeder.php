<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NotifikasiSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('notifikasi')->insert([
            [
                'user_id' => 3,
                'judul' => 'Pendaftaran Diterima',
                'pesan' => 'Pendaftaran Anda untuk kategori Frontend Development telah diterima dan disetujui.',
                'is_read' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 3,
                'judul' => 'Hasil Penilaian',
                'pesan' => 'Anda berhasil mendapatkan peringkat 1 dalam kategori Frontend Development. Selamat!',
                'is_read' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
