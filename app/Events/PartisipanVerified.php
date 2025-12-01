<?php

namespace App\Events;

use App\Models\Partisipan;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PartisipanVerified
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $partisipan;
    public $verificationNotes;

    /**
     * Create a new event instance.
     */
    public function __construct(Partisipan $partisipan, $verificationNotes = null)
    {
        $this->partisipan = $partisipan;
        $this->verificationNotes = $verificationNotes;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
