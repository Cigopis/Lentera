<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            'view users',
            'create users',
            'edit users',
            'delete users',
            'manage roles',
            'deactivate users',
            'view content',
            'manage content',
            'view auctions',
            'manage auctions',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission, 'guard_name' => 'web']);
        }

        // Create roles and assign permissions
        
        // Super Admin - full access
        $superAdmin = Role::create(['name' => 'super admin', 'guard_name' => 'web']);
        $superAdmin->givePermissionTo(Permission::all());

        // Admin - cannot create super admin, cannot delete super admin
        $admin = Role::create(['name' => 'admin', 'guard_name' => 'web']);
        $admin->givePermissionTo([
            'view users',
            'create users',
            'edit users',
            'delete users', // tapi dibatasi via policy
            'deactivate users', // hanya staff
            'view content',
            'manage content',
            'view auctions',
            'manage auctions',
        ]);

        // Staff - limited access
        $staff = Role::create(['name' => 'staff', 'guard_name' => 'web']);
        $staff->givePermissionTo([
            'view content',
            'manage content',
            'view auctions',
            'manage auctions',
        ]);
    }
}