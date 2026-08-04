<?php

namespace App\Repositories\Chat;

use App\Models\Conversation;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class ConversationRepository
{
    public function listForUser(User $user, array $filters = []): LengthAwarePaginator
    {
        $query = Conversation::with(['creator', 'participants.user'])
            ->whereHas('participants', fn (Builder $query) => $query->where('user_id', $user->id));

        if (! empty($filters['type'])) {
            $query->where('type', $filters['type']);
        }

        if (! empty($filters['title'])) {
            $query->where('title', 'like', '%'.$filters['title'].'%');
        }

        if (! empty($filters['participant_id'])) {
            $query->whereHas('participants', fn (Builder $query) => $query->where('user_id', $filters['participant_id']));
        }

        $orderBy = $filters['order_by'] ?? 'last_message_at';
        $orderDirection = $filters['order_direction'] ?? 'desc';

        return $query->orderBy($orderBy, $orderDirection)
            ->paginate($filters['per_page'] ?? 15);
    }

    public function findForUser(int $conversationId, User $user): ?Conversation
    {
        return Conversation::with(['creator', 'participants.user'])
            ->where('id', $conversationId)
            ->whereHas('participants', fn (Builder $query) => $query->where('user_id', $user->id))
            ->first();
    }

    public function create(array $data, User $creator): Conversation
    {
        $conversation = Conversation::create([
            'uuid' => $data['uuid'],
            'type' => $data['type'],
            'title' => $data['title'] ?? null,
            'created_by' => $creator->id,
            'last_message_at' => null,
            'metadata' => $data['metadata'] ?? null,
        ]);

        return $conversation;
    }

    public function update(Conversation $conversation, array $data): Conversation
    {
        $conversation->fill(array_filter([
            'type' => $data['type'] ?? null,
            'title' => array_key_exists('title', $data) ? $data['title'] : $conversation->title,
            'metadata' => $data['metadata'] ?? $conversation->metadata,
        ], fn ($value) => $value !== null || array_key_exists('title', $data)));
        $conversation->save();

        return $conversation;
    }

    public function delete(Conversation $conversation): bool
    {
        return $conversation->delete();
    }
}
