<?php

namespace App\Services\Chat;

use App\Models\Conversation;
use App\Models\User;
use App\Repositories\Chat\ConversationRepository;
use Illuminate\Support\Str;

class ConversationService
{
    public function __construct(protected ConversationRepository $repository)
    {
    }

    public function list(User $user, array $filters = [])
    {
        return $this->repository->listForUser($user, $filters);
    }

    public function find(User $user, int $conversationId): ?Conversation
    {
        return $this->repository->findForUser($conversationId, $user);
    }

    public function create(array $data, User $creator): Conversation
    {
        $conversation = $this->repository->create(array_merge($data, [
            'uuid' => Str::uuid()->toString(),
        ]), $creator);

        $participantIds = array_unique(array_merge([$creator->id], $data['participant_ids'] ?? []));

        $conversation->participants()->createMany(array_map(fn ($userId) => [
            'user_id' => $userId,
            'role' => $userId === $creator->id ? 'owner' : 'participant',
            'joined_at' => now(),
        ], $participantIds));

        return $conversation->load(['creator', 'participants.user']);
    }

    public function update(Conversation $conversation, array $data): Conversation
    {
        return $this->repository->update($conversation, $data)->load(['creator', 'participants.user']);
    }

    public function delete(Conversation $conversation): bool
    {
        return $this->repository->delete($conversation);
    }
}
