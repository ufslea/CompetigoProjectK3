<?php

namespace App\Listeners;

use App\Events\AnnouncementCreated;
use App\Models\Notifikasi;
use App\Models\Partisipan;

class SendAnnouncementNotification
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
    public function handle(AnnouncementCreated $event): void
    {
        // Get all participants in this event
        $partisipans = Partisipan::whereHas('sublomba', function($query) use ($event) {
            $query->where('event_id', $event->pengumuman->events_id);
        })->with('user')->get();

        // Create notification for each participant
        foreach ($partisipans as $partisipan) {
            Notifikasi::create([
                'user_id' => $partisipan->user_id,
                'judul' => '📢 Pengumuman: ' . $event->pengumuman->judul,
                'pesan' => $event->pengumuman->isi,
                'is_read' => false,
            ]);
        }
    }
}
