<?php

use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;

beforeEach(function () {
    $this->seed(RolesAndPermissionsSeeder::class);
});

test('guests are redirected from the admin panel', function () {
    $this->get('/admin')->assertRedirect();
});

test('regular users cannot access the admin panel', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get('/admin')
        ->assertForbidden();
});

test('admin users can access the admin panel', function () {
    $user = User::factory()->admin()->create();

    $this->actingAs($user)
        ->get('/admin')
        ->assertOk();
});

test('super admin users can access the admin panel', function () {
    $user = User::factory()->superAdmin()->create();

    $this->actingAs($user)
        ->get('/admin')
        ->assertOk();
});
