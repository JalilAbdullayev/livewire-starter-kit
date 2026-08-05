<?php

use App\Enums\PermissionsEnum;
use App\Enums\RolesEnum;
use Database\Seeders\RolesAndPermissionsSeeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

test('roles and permissions seeder creates base roles and permissions', function () {
    $this->seed(RolesAndPermissionsSeeder::class);

    foreach (RolesEnum::cases() as $role) {
        expect(Role::findByName($role->value, 'web'))->not->toBeNull();
    }

    foreach (PermissionsEnum::cases() as $permission) {
        expect(Permission::findByName($permission->value, 'web'))->not->toBeNull();
    }

    $admin = Role::findByName(RolesEnum::Admin->value, 'web');

    expect($admin->hasPermissionTo(PermissionsEnum::AccessAdminPanel))->toBeTrue()
        ->and($admin->hasPermissionTo(PermissionsEnum::ManageUsers))->toBeTrue()
        ->and($admin->hasPermissionTo(PermissionsEnum::ManageRoles))->toBeTrue();
});
