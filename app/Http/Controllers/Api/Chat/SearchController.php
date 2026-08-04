<?php

namespace App\Http\Controllers\Api\Chat;

use App\Http\Controllers\Controller;
use App\Http\Requests\Chat\SearchRequest;
use App\Http\Resources\ConversationResource;
use App\Http\Resources\MessageResource;
use App\Models\Conversation;
use App\Repositories\Chat\MessageRepository;

class SearchController extends Controller
{
    public function __construct(protected MessageRepository $messages)
    {
    }

    public function __invoke(SearchRequest $request)
    {
        if ($request->type === 'conversations') {
            $conversations = Conversation::with(['creator', 'participants.user'])
                ->whereHas('participants', fn ($query) => $query->where('user_id', $request->user()->id))
                ->where('title', 'like', '%'.$request->query.'%')
                ->orderBy($request->order_by ?? 'last_message_at', $request->order_direction ?? 'desc')
                ->paginate($request->per_page ?? 15);

            return response()->json([
                'results' => ConversationResource::collection($conversations),
                'meta' => [
                    'current_page' => $conversations->currentPage(),
                    'last_page' => $conversations->lastPage(),
                    'total' => $conversations->total(),
                ],
            ]);
        }

        $messages = $this->messages->search($request->query, $request->only(['conversation_id', 'order_by', 'order_direction', 'per_page']));

        return response()->json([
            'results' => MessageResource::collection($messages),
            'meta' => [
                'current_page' => $messages->currentPage(),
                'last_page' => $messages->lastPage(),
                'total' => $messages->total(),
            ],
        ]);
    }
}
