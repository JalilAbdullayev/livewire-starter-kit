<?php

use App\Enums\PermissionsEnum;
use App\Enums\RolesEnum;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;

beforeEach(function () {
    $this->seed(RolesAndPermissionsSeeder::class);
});

test('super admin can perform any ability via gate', function () {
    $user = User::factory()->superAdmin()->create();

    expect($user->can(PermissionsEnum::AccessAdminPanel))->toBeTrue()
        ->and($user->can(PermissionsEnum::ManageUsers))->toBeTrue()
        ->and($user->can(PermissionsEnum::ManageRoles))->toBeTrue()
        ->and($user->can('nonexistent-ability'))->toBeTrue()
        ->and($user->hasRole(RolesEnum::SuperAdmin))->toBeTrue();
});

test('admin can only use assigned permissions', function () {
    $user = User::factory()->admin()->create();

    expect($user->can(PermissionsEnum::AccessAdminPanel))->toBeTrue()
        ->and($user->can(PermissionsEnum::ManageUsers))->toBeTrue()
        ->and($user->can(PermissionsEnum::ManageRoles))->toBeTrue()
        ->and($user->can('nonexistent-ability'))->toBeFalse();
});

test('regular users cannot use admin permissions', function () {
    $user = User::factory()->create();

    expect($user->can(PermissionsEnum::AccessAdminPanel))->toBeFalse()
        ->and($user->can(PermissionsEnum::ManageUsers))->toBeFalse()
        ->and($user->can(PermissionsEnum::ManageRoles))->toBeFalse();
});
