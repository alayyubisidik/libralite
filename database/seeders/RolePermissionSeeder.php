<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    private const ADMIN_PERMISSIONS = [
        'view dashboard',

        'view members',
        'create members',
        'edit members',
        'delete members',

        'view books',
        'create books',
        'edit books',
        'delete books',

        'view categories',
        'create categories',
        'edit categories',
        'delete categories',

        'view borrowings',
        'create borrowings',
        'manage borrowings',
        'process returns',

        'manage fines',

        'view attendance',

        'view payments',
        'create payments',
        'manage payments',

        'view reports',

        'view activity logs',
    ];

    private const MEMBER_PERMISSIONS = [
        'view dashboard',
        'view books',
        'view borrowings',
        'create borrowings',
        'view attendance',
        'view payments',
        'create payments',
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (self::ADMIN_PERMISSIONS as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $admin = Role::firstOrCreate(['name' => 'admin']);
        $member = Role::firstOrCreate(['name' => 'member']);

        $admin->syncPermissions(self::ADMIN_PERMISSIONS);
        $member->syncPermissions(self::MEMBER_PERMISSIONS);
    }
}
