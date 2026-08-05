<?php

namespace Database\Seeders;

use App\Enums\RolesEnum;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // $this->call(RolesAndPermissionsSeeder::class);
        $this->call(SiteModulesSeeder::class);

        $admin = User::query()->firstOrCreate(
            ['email' => 'admin@mail.com'],
            [
                'name' => 'Admin',
                'password' => 'password',
                'email_verified_at' => now(),
            ],
        );

        // $admin->assignRole(RolesEnum::SuperAdmin);
    }
}
