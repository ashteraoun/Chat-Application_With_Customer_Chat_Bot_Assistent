<?php

namespace App\Http\Controllers\Api\Chat;

use App\Events\TypingStatusUpdated;
use App\Http\Controllers\Controller;
use App\Http\Requests\Chat\TypingStatusRequest;
use App\Models\Conversation;
use App\Models\TypingStatus;
use Illuminate\Http\Request;

class TypingStatusController extends Controller
{
    public function index(Request $request)
    {
        $data = $request->validate([
            'conversation_id' => ['required', 'integer', 'exists:conversations,id'],
        ]);

        $conversation = Conversation::findOrFail($data['conversation_id']);

        abort_unless($conversation->participants()->where('user_id', $request->user()->id)->exists(), 403);

        $statuses = TypingStatus::with('user')
            ->where('conversation_id', $conversation->id)
            ->where('is_typing', true)
            ->where('updated_at', '>=', now()->subSeconds(5))
            ->get();

        return response()->json([
            'typing_statuses' => $statuses->map(fn (TypingStatus $status) => [
                'id' => $status->id,
                'conversation_id' => $status->conversation_id,
                'user_id' => $status->user_id,
                'is_typing' => $status->is_typing,
                'updated_at' => $status->updated_at?->toDateTimeString(),
                'user' => $status->user ? [
                    'id' => $status->user->id,
                    'name' => $status->user->name,
                    'email' => $status->user->email,
                ] : null,
            ])->values(),
        ]);
    }

    public function update(TypingStatusRequest $request)
    {
        $status = TypingStatus::updateOrCreate(
            [
                'conversation_id' => $request->conversation_id,
                'user_id' => $request->user()->id,
            ],
            [
                'is_typing' => $request->is_typing,
                'updated_at' => now(),
            ]
        );

        broadcast(new TypingStatusUpdated($status))->toOthers();

        return response()->json([
            'message' => 'Typing status updated.',
            'status' => $status,
        ]);
    }
}
