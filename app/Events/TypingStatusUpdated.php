<?php

namespace App\Events;

use App\Models\TypingStatus;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class TypingStatusUpdated implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public TypingStatus $typingStatus;

    public function __construct(TypingStatus $typingStatus)
    {
        $this->typingStatus = $typingStatus;
    }

    public function broadcastOn(): Channel
    {
        return new PrivateChannel('conversation.'.$this->typingStatus->conversation_id);
    }

    public function broadcastWith(): array
    {
        return [
            'user_id' => $this->typingStatus->user_id,
            'is_typing' => $this->typingStatus->is_typing,
            'updated_at' => $this->typingStatus->updated_at->toDateTimeString(),
        ];
    }
}
