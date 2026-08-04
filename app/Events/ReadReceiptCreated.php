<?php

namespace App\Events;

use App\Models\ReadReceipt;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class ReadReceiptCreated implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public ReadReceipt $receipt;

    public function __construct(ReadReceipt $receipt)
    {
        $this->receipt = $receipt;
    }

    public function broadcastOn(): Channel
    {
        return new PrivateChannel('conversation.'.$this->receipt->message->conversation_id);
    }

    public function broadcastWith(): array
    {
        return [
            'message_id' => $this->receipt->message_id,
            'user_id' => $this->receipt->user_id,
            'read_at' => $this->receipt->read_at->toDateTimeString(),
        ];
    }
}
