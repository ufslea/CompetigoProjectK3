<?php

namespace App\Listeners;

use App\Events\ResultCreated;
use App\Models\Notifikasi;

class SendResultNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ResultCreated $event): void
    {
        // Create notification for the participant whose result was created
        $partisipan = $event->hasil->partisipan;
        $sublomba = $event->hasil->sublomba;
        
        $judul = '🏆 Hasil Lomba ' . $sublomba->nama;
        $pesan = 'Hasil lomba telah diumumkan! ';
        
        if ($event->hasil->rank) {
            $pesan .= 'Peringkat Anda: ' . $event->hasil->rank . '. ';
        }
        
        $pesan .= 'Silakan cek halaman hasil untuk detail lebih lanjut.';

        Notifikasi::create([
            'user_id' => $partisipan->user_id,
            'judul' => $judul,
            'pesan' => $pesan,
            'is_read' => false,
        ]);
    }
}
