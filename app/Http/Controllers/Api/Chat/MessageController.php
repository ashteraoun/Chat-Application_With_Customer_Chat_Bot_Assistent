<?php

namespace App\Http\Controllers\Api\Chat;

use App\Http\Controllers\Controller;
use App\Http\Requests\Chat\SearchRequest;
use App\Http\Requests\Chat\StoreMessageRequest;
use App\Http\Requests\Chat\UpdateMessageRequest;
use App\Http\Resources\MessageResource;
use App\Models\Conversation;
use App\Services\Chat\MessageService;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function __construct(protected MessageService $service)
    {
    }

    public function index(Request $request, Conversation $conversation)
    {
        abort_unless($conversation->participants()->where('user_id', $request->user()->id)->exists(), 403);

        $messages = $this->service->paginate($conversation, $request->only(['order_by', 'order_direction', 'per_page']));

        return response()->json([
            'messages' => MessageResource::collection($messages),
            'meta' => [
                'current_page' => $messages->currentPage(),
                'last_page' => $messages->lastPage(),
                'total' => $messages->total(),
            ],
        ]);
    }

    public function store(StoreMessageRequest $request, Conversation $conversation)
    {
        abort_unless($conversation->participants()->where('user_id', $request->user()->id)->exists(), 403);

        $message = $this->service->create($conversation, array_merge($request->validated(), [
            'sender_id' => $request->user()->id,
        ]));

        return response()->json([
            'message' => 'Message sent successfully.',
            'data' => new MessageResource($message),
        ], 201);
    }

    public function show(Request $request, Conversation $conversation, $messageId)
    {
        abort_unless($conversation->participants()->where('user_id', $request->user()->id)->exists(), 403);

        $message = $conversation->messages()->with(['sender', 'attachments'])->findOrFail($messageId);

        return response()->json(['message' => new MessageResource($message)]);
    }

    public function update(UpdateMessageRequest $request, Conversation $conversation, $messageId)
    {
        abort_unless($conversation->participants()->where('user_id', $request->user()->id)->exists(), 403);

        $message = $conversation->messages()->findOrFail($messageId);
        $message->update($request->validated());

        return response()->json([
            'message' => 'Message updated successfully.',
            'data' => new MessageResource($message->load(['sender', 'attachments'])),
        ]);
    }

    public function destroy(Request $request, Conversation $conversation, $messageId)
    {
        abort_unless($conversation->participants()->where('user_id', $request->user()->id)->exists(), 403);

        $message = $conversation->messages()->findOrFail($messageId);
        $message->delete();

        return response()->json(['message' => 'Message deleted successfully.']);
    }

    public function search(SearchRequest $request)
    {
        $result = $this->service->search($request->query, $request->only(['conversation_id', 'order_by', 'order_direction', 'per_page']));

        return response()->json([
            'messages' => MessageResource::collection($result),
            'meta' => [
                'current_page' => $result->currentPage(),
                'last_page' => $result->lastPage(),
                'total' => $result->total(),
            ],
        ]);
    }
}
