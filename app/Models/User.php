<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'verification_code',
        'verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function sentMessages(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function conversations(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Conversation::class, 'conversation_participants')
            ->withPivot(['role', 'joined_at', 'last_seen_at', 'is_muted', 'left_at'])
            ->withTimestamps();
    }

    public function conversationParticipants(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ConversationParticipant::class);
    }

    public function readReceipts(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ReadReceipt::class);
    }

    public function typingStatuses(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(TypingStatus::class);
    }

    public function onlineStatus(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(OnlineStatus::class);
    }
}
