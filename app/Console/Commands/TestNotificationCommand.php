<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Partisipan;
use App\Models\User;
use App\Models\Notifikasi;
use App\Events\PartisipanVerified;

class TestNotificationCommand extends Command
{
    protected $signature = 'test:notification';
    protected $description = 'Test notification system';

    public function handle()
    {
        $this->info('=== TEST NOTIFICATION SYSTEM ===');

        // Get test data
        $partisipan = Partisipan::where('verification_status', 'pending')->first();
        $organizer = User::where('role', 'organizer')->first();

        $this->info("Participant ID: " . ($partisipan->partisipan_id ?? 'None'));
        $this->info("Organizer ID: " . ($organizer->user_id ?? 'None'));

        if ($partisipan && $organizer) {
            $this->info("\nDispatching PartisipanVerified event...");
            PartisipanVerified::dispatch($partisipan, "Test verification notes");
            
            // Check if notification was created
            $notifikasi = Notifikasi::where('user_id', $partisipan->user_id)->latest()->first();
            
            if ($notifikasi) {
                $this->info("✓ Notification created!");
                $this->info("  - Judul: " . $notifikasi->judul);
                $this->info("  - Pesan: " . substr($notifikasi->pesan, 0, 60) . "...");
                $this->info("  - User ID: " . $notifikasi->user_id);
                $this->info("  - Is Read: " . ($notifikasi->is_read ? 'Yes' : 'No'));
            } else {
                $this->error("✗ Notification NOT created!");
            }
        } else {
            $this->error("Test data not found");
        }
    }
}
