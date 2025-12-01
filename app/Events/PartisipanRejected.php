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

class PartisipanRejected
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $partisipan;
    public $rejectionReason;

    /**
     * Create a new event instance.
     */
    public function __construct(Partisipan $partisipan, $rejectionReason = null)
    {
        $this->partisipan = $partisipan;
        $this->rejectionReason = $rejectionReason;
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
