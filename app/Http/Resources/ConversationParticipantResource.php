<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ConversationParticipantResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'user_id' => $this->user_id,
            'role' => $this->role,
            'joined_at' => $this->joined_at,
            'last_seen_at' => $this->last_seen_at,
            'is_muted' => $this->is_muted,
            'left_at' => $this->left_at,
            'user' => new UserResource($this->whenLoaded('user')),
        ];
    }
}
