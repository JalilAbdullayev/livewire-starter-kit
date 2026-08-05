<?php

namespace Database\Seeders;

use App\Enums\PermissionsEnum;
use App\Enums\RolesEnum;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $registrar = app(PermissionRegistrar::class);
        $registrar->forgetCachedPermissions();

        foreach (PermissionsEnum::cases() as $permission) {
            Permission::findOrCreate($permission, 'web');
        }

        // findOrCreate loads an empty cache, then inserts rows that are not
        // added to that cache — clear again so syncPermissions can resolve names.
        $registrar->forgetCachedPermissions();

        Role::findOrCreate(RolesEnum::SuperAdmin, 'web');

        Role::findOrCreate(RolesEnum::Admin, 'web')
            ->syncPermissions(PermissionsEnum::cases());

        Role::findOrCreate(RolesEnum::User, 'web')
            ->syncPermissions([]);
    }
}
