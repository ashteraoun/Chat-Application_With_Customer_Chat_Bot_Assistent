<?php

namespace App\Events;

use App\Models\OnlineStatus;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class OnlineStatusUpdated implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public OnlineStatus $status;

    public function __construct(OnlineStatus $status)
    {
        $this->status = $status;
    }

    public function broadcastOn(): Channel
    {
        return new PrivateChannel('user.'.$this->status->user_id);
    }

    public function broadcastWith(): array
    {
        return [
            'user_id' => $this->status->user_id,
            'is_online' => $this->status->is_online,
            'last_active_at' => $this->status->last_active_at->toDateTimeString(),
        ];
    }
}
