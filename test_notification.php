<?php

// Setup Laravel app
$app = require __DIR__.'/bootstrap/app.php';

$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Partisipan;
use App\Models\User;
use App\Models\Notifikasi;
use App\Events\PartisipanVerified;

// Get test data
$partisipan = Partisipan::where('verification_status', 'pending')->first();
$organizer = User::where('role', 'organizer')->first();

echo "=== TEST NOTIFICATION SYSTEM ===\n";
echo "Participant ID: " . ($partisipan->partisipan_id ?? 'None') . "\n";
echo "Organizer ID: " . ($organizer->user_id ?? 'None') . "\n";

if ($partisipan && $organizer) {
    echo "\nDispatch PartisipanVerified event...\n";
    PartisipanVerified::dispatch($partisipan, "Test verification notes");
    
    // Check if notification was created
    $notifikasi = Notifikasi::where('user_id', $partisipan->user_id)->latest()->first();
    
    if ($notifikasi) {
        echo "✓ Notification created!\n";
        echo "  - Judul: " . $notifikasi->judul . "\n";
        echo "  - Pesan: " . substr($notifikasi->pesan, 0, 50) . "...\n";
        echo "  - User ID: " . $notifikasi->user_id . "\n";
    } else {
        echo "✗ Notification NOT created!\n";
    }
} else {
    echo "Test data not found\n";
}
