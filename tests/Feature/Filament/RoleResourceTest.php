<?php

use App\Enums\RolesEnum;
use App\Filament\Resources\Roles\Pages\CreateRole;
use App\Filament\Resources\Roles\Pages\EditRole;
use App\Filament\Resources\Roles\Pages\ListRoles;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;

beforeEach(function () {
    $this->seed(RolesAndPermissionsSeeder::class);
});

test('admin can list roles in filament', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin);

    Livewire::test(ListRoles::class)
        ->assertSuccessful()
        ->assertCanSeeTableRecords(Role::all());
});

test('regular users cannot list roles in filament', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    Livewire::test(ListRoles::class)
        ->assertForbidden();
});

test('admin can create a role in filament', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin);

    Livewire::test(CreateRole::class)
        ->fillForm([
            'name' => 'editor',
            'guard_name' => 'web',
        ])
        ->call('create')
        ->assertHasNoFormErrors()
        ->assertNotified()
        ->assertRedirect();

    expect(Role::findByName('editor', 'web'))->not->toBeNull();
});

test('admin can update a role in filament', function () {
    $admin = User::factory()->admin()->create();
    $role = Role::findByName(RolesEnum::User->value, 'web');

    $this->actingAs($admin);

    Livewire::test(EditRole::class, ['record' => $role->id])
        ->fillForm([
            'name' => 'member',
            'guard_name' => 'web',
        ])
        ->call('save')
        ->assertHasNoFormErrors()
        ->assertNotified();

    expect(Role::findByName('member', 'web'))->not->toBeNull();
});
