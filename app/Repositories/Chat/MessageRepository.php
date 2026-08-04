<?php

namespace App\Repositories\Chat;

use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Pagination\LengthAwarePaginator;

class MessageRepository
{
    public function paginateByConversation(Conversation $conversation, array $filters = []): LengthAwarePaginator
    {
        $query = Message::with(['sender', 'attachments'])
            ->where('conversation_id', $conversation->id);

        $orderBy = $filters['order_by'] ?? 'created_at';
        $direction = $filters['order_direction'] ?? 'asc';

        return $query->orderBy($orderBy, $direction)
            ->paginate($filters['per_page'] ?? 20);
    }

    public function create(Conversation $conversation, array $data): Message
    {
        $message = $conversation->messages()->create([
            'uuid' => $data['uuid'],
            'sender_id' => $data['sender_id'],
            'body' => $data['body'] ?? null,
            'type' => $data['type'],
            'status' => $data['status'] ?? 'sent',
            'edited_at' => $data['edited_at'] ?? null,
            'metadata' => $data['metadata'] ?? null,
        ]);

        return $message;
    }

    public function attachFiles(Message $message, array $attachments): void
    {
        foreach ($attachments as $attachment) {
            $message->attachments()->create([
                'filename' => $attachment['filename'],
                'content_type' => $attachment['content_type'],
                'size' => $attachment['size'],
                'url' => $attachment['url'],
                'storage_path' => $attachment['storage_path'] ?? null,
                'metadata' => $attachment['metadata'] ?? null,
            ]);
        }
    }

    public function search(string $query, array $filters = []): LengthAwarePaginator
    {
        $builder = Message::with(['sender', 'conversation'])
            ->where('body', 'like', '%'.$query.'%');

        if (! empty($filters['conversation_id'])) {
            $builder->where('conversation_id', $filters['conversation_id']);
        }

        $orderBy = $filters['order_by'] ?? 'created_at';
        $direction = $filters['order_direction'] ?? 'desc';

        return $builder->orderBy($orderBy, $direction)
            ->paginate($filters['per_page'] ?? 20);
    }
}
