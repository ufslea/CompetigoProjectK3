<?php

namespace App\Listeners;

use App\Events\PartisipanRejected;
use App\Models\Notifikasi;

class SendRejectionNotification
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
    public function handle(PartisipanRejected $event): void
    {
        // Create notification for the participant about rejection
        $pesan = 'Pendaftaran Anda telah ditolak oleh organizer.';
        
        if ($event->rejectionReason) {
            $pesan .= ' Alasan: ' . $event->rejectionReason;
        }

        Notifikasi::create([
            'user_id' => $event->partisipan->user_id,
            'judul' => '✗ Pendaftaran Ditolak',
            'pesan' => $pesan,
            'is_read' => false,
        ]);
    }
}
