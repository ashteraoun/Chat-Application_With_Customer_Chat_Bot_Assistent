<?php

namespace App\Http\Controllers\Api\Chat;

use App\Http\Controllers\Controller;
use App\Services\Chat\ReadReceiptService;
use Illuminate\Http\Request;

class UnreadController extends Controller
{
    public function __construct(protected ReadReceiptService $service)
    {
    }

    public function index(Request $request)
    {
        return response()->json([
            'unread_count' => $this->service->totalUnreadCount($request->user()),
        ]);
    }

    public function conversation(Request $request, $conversationId)
    {
        $conversation = $request->user()->conversations()->findOrFail($conversationId);

        $created = $this->service->markConversationAsRead($conversation, $request->user());

        return response()->json([
            'message' => 'Conversation marked as read.',
            'created_receipts' => $created,
        ]);
    }
}
