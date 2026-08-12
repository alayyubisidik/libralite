<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * No default admin is created here. The first admin must be
     * created through the secure setup-admin process.
     */
    public function run(): void
    {
        $this->call([
            RolePermissionSeeder::class,
        ]);

        if (app()->environment(['local', 'staging'])) {
            $this->call(DevelopmentDataSeeder::class);
        }
    }
}
