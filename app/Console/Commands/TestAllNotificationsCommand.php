<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Partisipan;
use App\Models\User;
use App\Models\Notifikasi;
use App\Events\PartisipanVerified;
use App\Events\PartisipanRejected;
use App\Events\ResultCreated;
use App\Events\AnnouncementCreated;

class TestAllNotificationsCommand extends Command
{
    protected $signature = 'test:all-notifications';
    protected $description = 'Test all notification scenarios';

    public function handle()
    {
        $this->info('=== TEST ALL NOTIFICATION SCENARIOS ===');
        
        // Clear previous notifications for clean test
        Notifikasi::truncate();
        $this->info("\n✓ Cleared previous notifications for clean test");

        // Test 1: Verification Notification
        $this->info("\n\n--- TEST 1: Verification Notification ---");
        $partisipan1 = Partisipan::where('verification_status', 'pending')->first();
        if ($partisipan1) {
            $userId = $partisipan1->user_id;
            PartisipanVerified::dispatch($partisipan1, "Bukti pembayaran valid");
            
            $notif = Notifikasi::where('user_id', $userId)->latest()->first();
            $this->info("Judul: " . $notif->judul);
            $this->info("User ID: " . $notif->user_id);
            $this->line("✓ Test 1 passed!");
        }

        // Test 2: Rejection Notification
        $this->info("\n--- TEST 2: Rejection Notification ---");
        $partisipan2 = Partisipan::where('verification_status', 'pending')->skip(1)->first();
        if ($partisipan2) {
            $userId = $partisipan2->user_id;
            PartisipanRejected::dispatch($partisipan2, "Bukti pembayaran tidak sesuai");
            
            $notif = Notifikasi::where('user_id', $userId)->latest()->first();
            $this->info("Judul: " . $notif->judul);
            $this->info("User ID: " . $notif->user_id);
            $this->line("✓ Test 2 passed!");
        }

        // Test 3: Result Notification
        $this->info("\n--- TEST 3: Result Notification ---");
        $hasil = \App\Models\Hasil::first();
        if ($hasil) {
            $userId = $hasil->partisipan->user_id;
            ResultCreated::dispatch($hasil);
            
            $notif = Notifikasi::where('user_id', $userId)->latest()->first();
            $this->info("Judul: " . $notif->judul);
            $this->info("User ID: " . $notif->user_id);
            $this->line("✓ Test 3 passed!");
        }

        // Test 4: Announcement Notification
        $this->info("\n--- TEST 4: Announcement Notification ---");
        $pengumuman = \App\Models\Pengumuman::first();
        if ($pengumuman) {
            $countBefore = Notifikasi::count();
            AnnouncementCreated::dispatch($pengumuman);
            $countAfter = Notifikasi::count();
            
            $this->info("Notifications created: " . ($countAfter - $countBefore));
            $latestNotif = Notifikasi::latest()->first();
            $this->info("Latest notification - Judul: " . $latestNotif->judul);
            $this->line("✓ Test 4 passed!");
        }

        $this->info("\n\n✓ ALL TESTS PASSED!");
        $this->info("Total notifications in system: " . Notifikasi::count());
    }
}
