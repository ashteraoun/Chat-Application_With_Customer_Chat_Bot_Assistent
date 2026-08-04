<?php

namespace App\Http\Controllers\Api\Chat;

use App\Http\Controllers\Controller;
use App\Http\Requests\Chat\StoreConversationRequest;
use App\Http\Requests\Chat\UpdateConversationRequest;
use App\Http\Resources\ConversationResource;
use App\Models\Conversation;
use App\Services\Chat\ConversationService;
use Illuminate\Http\Request;

class ConversationController extends Controller
{
    public function __construct(protected ConversationService $service)
    {
    }

    public function index(Request $request)
    {
        $conversations = $this->service->list($request->user(), $request->only([
            'type',
            'title',
            'participant_id',
            'order_by',
            'order_direction',
            'per_page',
        ]));

        return response()->json([
            'conversations' => ConversationResource::collection($conversations),
            'meta' => [
                'current_page' => $conversations->currentPage(),
                'last_page' => $conversations->lastPage(),
                'total' => $conversations->total(),
            ],
        ]);
    }

    public function store(StoreConversationRequest $request)
    {
        $conversation = $this->service->create($request->validated(), $request->user());

        return response()->json([
            'message' => 'Conversation created successfully.',
            'conversation' => new ConversationResource($conversation),
        ], 201);
    }

    public function show(Request $request, Conversation $conversation)
    {
        abort_unless($conversation->participants()->where('user_id', $request->user()->id)->exists(), 403);

        $conversation->load(['creator', 'participants.user']);

        return response()->json(['conversation' => new ConversationResource($conversation)]);
    }

    public function update(UpdateConversationRequest $request, Conversation $conversation)
    {
        abort_unless($conversation->participants()->where('user_id', $request->user()->id)->exists(), 403);

        $updated = $this->service->update($conversation, $request->validated());

        return response()->json([
            'message' => 'Conversation updated successfully.',
            'conversation' => new ConversationResource($updated),
        ]);
    }

    public function destroy(Request $request, Conversation $conversation)
    {
        abort_unless($conversation->participants()->where('user_id', $request->user()->id)->exists(), 403);

        $this->service->delete($conversation);

        return response()->json(['message' => 'Conversation deleted successfully.']);
    }
}
