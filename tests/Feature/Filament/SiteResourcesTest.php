<?php

use App\Filament\Resources\BlogPosts\Pages\ListBlogPosts;
use App\Filament\Resources\ContentPages\Pages\ListPages;
use App\Filament\Resources\Roles\Pages\ViewRole;
use App\Filament\Resources\SiteModules\Pages\ListSiteModules;
use App\Filament\Resources\Users\Pages\ViewUser;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Database\Seeders\SiteModulesSeeder;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;

beforeEach(function () {
    $this->seed(RolesAndPermissionsSeeder::class);
    $this->seed(SiteModulesSeeder::class);
});

test('admin can view filament site module list', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin);

    Livewire::test(ListSiteModules::class)->assertSuccessful();
});

test('admin can view filament pages list', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin);

    Livewire::test(ListPages::class)->assertSuccessful();
});

test('admin can view filament blog posts list', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin);

    Livewire::test(ListBlogPosts::class)->assertSuccessful();
});

test('admin can view a user record page', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin);

    Livewire::test(ViewUser::class, ['record' => $admin->id])
        ->assertSuccessful()
        ->assertSee($admin->email);
});

test('admin can view a role record page', function () {
    $admin = User::factory()->admin()->create();
    $role = Role::findByName('admin', 'web');

    $this->actingAs($admin);

    Livewire::test(ViewRole::class, ['record' => $role->id])
        ->assertSuccessful()
        ->assertSee('admin');
});

test('guest cannot access filament site modules', function () {
    $this->get('/admin/site-modules')->assertRedirect();
});
