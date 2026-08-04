<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'manage users',
            'manage agents',
            'manage customers',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $supportAgentRole = Role::firstOrCreate(['name' => 'support_agent']);
        $customerRole = Role::firstOrCreate(['name' => 'customer']);

        $adminRole->syncPermissions($permissions);
        $supportAgentRole->givePermissionTo(['manage customers']);
        $customerRole->givePermissionTo([]);
    }
}
