<?php

use App\Enums\SiteModuleEnum;
use App\Models\BlogPost;
use App\Models\ServiceCard;
use App\Models\SiteModule;
use Database\Seeders\SiteModulesSeeder;

beforeEach(function () {
    $this->seed(SiteModulesSeeder::class);
});

test('home page returns a successful response', function () {
    $this->get(route('home'))
        ->assertOk()
        ->assertSee(config('app.name'), false)
        ->assertSee(__('Build modern sites with modular sections'), false);
});

test('home page shows empty state when no modules are active', function () {
    $this->get(route('home'))
        ->assertOk()
        ->assertSee(__('No public sections are live yet. Check back soon.'), false);
});

test('home page lists active modules', function () {
    SiteModule::query()->where('key', SiteModuleEnum::About)->update(['is_active' => true]);
    SiteModule::clearActiveCache();

    $this->get(route('home'))
        ->assertOk()
        ->assertSee(__('Explore'), false)
        ->assertSee('About', false);
});

test('home page shows latest blog posts when blog module is active', function () {
    SiteModule::query()->where('key', SiteModuleEnum::Blog)->update(['is_active' => true]);
    SiteModule::clearActiveCache();

    BlogPost::factory()->create([
        'title' => 'Homepage Featured Post',
        'is_published' => true,
    ]);

    $this->get(route('home'))
        ->assertOk()
        ->assertSee(__('Latest posts'), false)
        ->assertSee('Homepage Featured Post', false);
});

test('home page shows featured service cards when services cards are enabled', function () {
    SiteModule::query()->where('key', SiteModuleEnum::Services)->update([
        'is_active' => true,
        'show_cards' => true,
    ]);
    SiteModule::clearActiveCache();

    ServiceCard::factory()->create([
        'title' => 'Homepage Service',
        'is_published' => true,
    ]);

    $this->get(route('home'))
        ->assertOk()
        ->assertSee(__('Services'), false)
        ->assertSee('Homepage Service', false);
});

test('home page primary action links to contact when contact module is active', function () {
    SiteModule::query()->where('key', SiteModuleEnum::Contact)->update(['is_active' => true]);
    SiteModule::clearActiveCache();

    $this->get(route('home'))
        ->assertOk()
        ->assertSee(__('Get in touch'), false)
        ->assertSee(localized_route('site.contact'), false);
});
