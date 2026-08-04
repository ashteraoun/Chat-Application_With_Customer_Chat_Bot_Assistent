<?php

namespace Tests\Feature;

use App\Models\Conversation;
use App\Models\ConversationParticipant;
use App\Models\TypingStatus;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TypingStatusApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_fetch_active_typing_statuses_for_a_conversation(): void
    {
        $customer = User::factory()->create([
            'name' => 'Customer User',
            'email' => 'customer@example.com',
            'role' => 'customer',
        ]);

        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'role' => 'admin',
        ]);

        $conversation = Conversation::create([
            'uuid' => 'conversation-typing-id',
            'type' => 'private',
            'title' => 'Support thread',
            'created_by' => $customer->id,
        ]);

        ConversationParticipant::create([
            'conversation_id' => $conversation->id,
            'user_id' => $customer->id,
            'role' => 'owner',
            'joined_at' => now(),
        ]);

        ConversationParticipant::create([
            'conversation_id' => $conversation->id,
            'user_id' => $admin->id,
            'role' => 'participant',
            'joined_at' => now(),
        ]);

        TypingStatus::create([
            'conversation_id' => $conversation->id,
            'user_id' => $customer->id,
            'is_typing' => true,
            'updated_at' => now(),
        ]);

        $response = $this->actingAs($customer, 'sanctum')
            ->getJson('/api/typing-status?conversation_id=' . $conversation->id);

        $response->assertOk()
            ->assertJsonPath('typing_statuses.0.user_id', $customer->id)
            ->assertJsonPath('typing_statuses.0.is_typing', true);
    }
}
