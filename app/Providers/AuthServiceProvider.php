<?php

namespace App\Providers;

use App\Models\User;
use App\Policies\UserManagementPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        User::class => UserPolicy::class,
        User::class => UserManagementPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
