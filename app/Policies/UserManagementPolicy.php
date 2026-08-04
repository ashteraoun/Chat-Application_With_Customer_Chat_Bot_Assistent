<?php

namespace App\Policies;

use App\Models\User;

class UserManagementPolicy
{
    public function manage(User $user): bool
    {
        return $user->hasRole('admin');
    }
}
