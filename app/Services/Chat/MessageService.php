<?php

namespace App\Services\Chat;

use App\Events\MessageCreated;
use App\Models\Conversation;
use App\Models\Message;
use App\Repositories\Chat\MessageRepository;
use Illuminate\Support\Str;

class MessageService
{
    public function __construct(protected MessageRepository $repository)
    {
    }

    public function paginate(Conversation $conversation, array $filters = [])
    {
        return $this->repository->paginateByConversation($conversation, $filters);
    }

    public function create(Conversation $conversation, array $data): Message
    {
        $message = $this->repository->create($conversation, array_merge($data, [
            'uuid' => Str::uuid()->toString(),
            'status' => $data['status'] ?? 'sent',
        ]));

        if (! empty($data['attachments'])) {
            $this->repository->attachFiles($message, $data['attachments']);
        }

        $conversation->update(['last_message_at' => now()]);

        $message->load(['sender', 'attachments']);

        broadcast(new MessageCreated($message))->toOthers();

        return $message;
    }
}
