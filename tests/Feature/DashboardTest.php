<?php

use App\Enums\PermissionsEnum;
use App\Models\BlogPost;
use App\Models\ContactMessage;
use App\Models\SiteModule;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Database\Seeders\SiteModulesSeeder;
use Livewire\Livewire;

beforeEach(function () {
    $this->seed(RolesAndPermissionsSeeder::class);
    $this->seed(SiteModulesSeeder::class);
});

test('guests are redirected to the login page', function () {
    $this->get(route('dashboard'))->assertRedirect(route('login'));
});

test('authenticated users can visit the dashboard', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('dashboard'))
        ->assertOk()
        ->assertSee('Welcome back, '.$user->name, false);
});

test('dashboard shows account status cards', function () {
    $user = User::factory()->unverified()->create();

    $this->actingAs($user);

    Livewire::test('pages::dashboard')
        ->assertSee(__('Email verification'))
        ->assertSee(__('Not verified'))
        ->assertSee(__('Two-factor authentication'))
        ->assertSee(__('Passkeys'));
});

test('dashboard shows getting started checklist for all users', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    Livewire::test('pages::dashboard')
        ->assertSee(__('Getting started'))
        ->assertSee(__('Verify your email address'))
        ->assertSee(__('Visit your public site'));
});

test('dashboard hides admin overview for regular users', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    Livewire::test('pages::dashboard')
        ->assertDontSee(__('Site overview'))
        ->assertDontSee(__('Admin panel'));
});

test('dashboard shows admin overview and quick action for admins', function () {
    $admin = User::factory()->admin()->create();

    ContactMessage::factory()->create(['read_at' => null]);
    ContactMessage::factory()->create(['read_at' => now()]);

    $this->actingAs($admin);

    Livewire::test('pages::dashboard')
        ->assertSee(__('Admin panel'))
        ->assertSee(__('Site overview'))
        ->assertSee(__('Unread messages'))
        ->assertSee(__('Enable at least one site module'))
        ->assertSee('1', false);
});

test('dashboard marks published content step complete when blog post is published', function () {
    $admin = User::factory()->admin()->create();

    BlogPost::factory()->create(['is_published' => true]);

    $this->actingAs($admin);

    Livewire::test('pages::dashboard')
        ->assertSet('gettingStartedSteps', function (array $steps): bool {
            $publishStep = collect($steps)->firstWhere('label', __('Publish content for your site'));

            return $publishStep !== null && $publishStep['done'] === true;
        });
});

test('dashboard shows active modules count for admins', function () {
    $admin = User::factory()->admin()->create();

    SiteModule::query()->update(['is_active' => false]);
    SiteModule::query()->limit(2)->update(['is_active' => true]);
    SiteModule::clearActiveCache();

    $this->actingAs($admin);

    Livewire::test('pages::dashboard')
        ->assertSet('adminSnapshot.activeModules', 2)
        ->assertSet('adminSnapshot.inactiveModules', SiteModule::query()->count() - 2);
});

test('regular users cannot access admin panel permission', function () {
    $user = User::factory()->create();

    expect($user->can(PermissionsEnum::AccessAdminPanel))->toBeFalse();
});
