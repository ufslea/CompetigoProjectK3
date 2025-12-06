<?php

namespace App\Listeners;

use App\Events\PartisipanVerified;
use App\Models\Notifikasi;

class SendVerificationNotification
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
    public function handle(PartisipanVerified $event): void
    {
        // Create notification for the participant
        Notifikasi::create([
            'user_id' => $event->partisipan->user_id,
            'judul' => '✓ Pendaftaran Diverifikasi',
            'pesan' => 'Pendaftaran Anda telah diverifikasi oleh organizer. Anda sekarang dapat mensubmit karya Anda.',
            'is_read' => false,
        ]);
    }
}
