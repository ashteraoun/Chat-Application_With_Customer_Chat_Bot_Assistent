<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->role === 'admin' || $user->role === 'support_agent';
    }

    public function view(User $user, User $model): bool
    {
        return $user->id === $model->id || $user->role === 'admin' || $user->role === 'support_agent';
    }
}
