<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Event::create([
            'organizer_id' => 2,
            'nama' => 'Kompetisi Web Development 2025',
            'deskripsi' => 'Kompetisi pengembangan website tingkat nasional',
            'url' => 'https://example.com/event1',
            'tanggal_mulai' => '2025-01-15',
            'tanggal_akhir' => '2025-02-15',
            'status' => 'active',
            'gambar' => null,
        ]);

        Event::create([
            'organizer_id' => 2,
            'nama' => 'Kompetisi Mobile App 2025',
            'deskripsi' => 'Kompetisi pengembangan aplikasi mobile',
            'url' => 'https://example.com/event2',
            'tanggal_mulai' => '2025-02-01',
            'tanggal_akhir' => '2025-03-01',
            'status' => 'draft',
            'gambar' => null,
        ]);
    }
}
