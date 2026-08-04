<?php

namespace App\Services\Chat;

use App\Events\ReadReceiptCreated;
use App\Models\Conversation;
use App\Models\ReadReceipt;
use App\Models\User;
use Illuminate\Support\Collection;

class ReadReceiptService
{
    public function markConversationAsRead(Conversation $conversation, User $user): int
    {
        $unreadMessages = $conversation->messages()
            ->whereNotExists(function ($query) use ($user) {
                $query->select('*')
                    ->from('read_receipts')
                    ->whereColumn('read_receipts.message_id', 'messages.id')
                    ->where('read_receipts.user_id', $user->id);
            })
            ->get();

        $created = 0;

        foreach ($unreadMessages as $message) {
            $receipt = ReadReceipt::create([
                'message_id' => $message->id,
                'user_id' => $user->id,
                'read_at' => now(),
            ]);

            broadcast(new ReadReceiptCreated($receipt))->toOthers();
            $created++;
        }

        return $created;
    }

    public function totalUnreadCount(User $user): int
    {
        return $user->conversations()
            ->withCount(['messages as unread_count' => function ($query) use ($user) {
                $query->whereNotExists(function ($sub) use ($user) {
                    $sub->select('*')
                        ->from('read_receipts')
                        ->whereColumn('read_receipts.message_id', 'messages.id')
                        ->where('read_receipts.user_id', $user->id);
                });
            }])
            ->get()
            ->sum('unread_count');
    }

    public function unreadCountByConversation(User $user): Collection
    {
        return $user->conversations()
            ->withCount(['messages as unread_count' => function ($query) use ($user) {
                $query->whereNotExists(function ($sub) use ($user) {
                    $sub->select('*')
                        ->from('read_receipts')
                        ->whereColumn('read_receipts.message_id', 'messages.id')
                        ->where('read_receipts.user_id', $user->id);
                });
            }])
            ->get()
            ->map(fn ($conversation) => [
                'conversation_id' => $conversation->id,
                'unread_count' => $conversation->unread_count,
            ]);
    }
}
