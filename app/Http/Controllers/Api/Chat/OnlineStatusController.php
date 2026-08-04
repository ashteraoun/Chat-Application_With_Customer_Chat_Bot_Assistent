<?php

namespace App\Http\Controllers\Api\Chat;

use App\Http\Controllers\Controller;
use App\Http\Requests\Chat\OnlineStatusRequest;
use App\Models\OnlineStatus;
use Illuminate\Http\Request;

class OnlineStatusController extends Controller
{
    public function index(Request $request)
    {
        return response()->json([
            'online_statuses' => $request->user()->conversations()
                ->with(['participants.user', 'participants.user.onlineStatus'])
                ->get()
                ->pluck('participants')
                ->flatten()
                ->map(fn ($participant) => [
                    'user_id' => $participant->user_id,
                    'is_online' => $participant->user->onlineStatus?->is_online ?? false,
                    'last_active_at' => $participant->user->onlineStatus?->last_active_at,
                ])
                ->unique('user_id')
                ->values(),
        ]);
    }

    public function update(OnlineStatusRequest $request)
    {
        $status = OnlineStatus::updateOrCreate(
            ['user_id' => $request->user()->id],
            [
                'is_online' => $request->is_online,
                'last_active_at' => now(),
                'updated_at' => now(),
            ]
        );

        broadcast(new \App\Events\OnlineStatusUpdated($status))->toOthers();

        return response()->json([
            'message' => 'Online status updated.',
            'online_status' => $status,
        ]);
    }
}
