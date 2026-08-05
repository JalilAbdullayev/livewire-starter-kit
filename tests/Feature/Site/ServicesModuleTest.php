<?php

use App\Enums\SiteModuleEnum;
use App\Models\ServiceCard;
use App\Models\SiteModule;
use Database\Seeders\SiteModulesSeeder;

beforeEach(function () {
    $this->seed(SiteModulesSeeder::class);

    $this->services = SiteModule::findByKey(SiteModuleEnum::Services);
    $this->services->update(['is_active' => true]);
});

test('services page content renders when show_page is enabled', function () {
    $this->services->update(['show_page' => true, 'show_cards' => false]);
    $this->services->page->update([
        'title' => 'Our Services',
        'content' => '<p>Service page body</p>',
    ]);

    $this->get(route('site.services.index'))
        ->assertOk()
        ->assertSee('Our Services')
        ->assertSee('Service page body', false);
});

test('services cards render when show_cards is enabled', function () {
    $this->services->update(['show_page' => false, 'show_cards' => true]);

    $card = ServiceCard::factory()->create([
        'title' => 'Consulting',
        'excerpt' => 'Expert advice',
        'is_published' => true,
    ]);

    $this->get(route('site.services.index'))
        ->assertOk()
        ->assertSee('Consulting')
        ->assertSee('Expert advice');

    $this->get(route('site.services.show', $card->slug))
        ->assertOk()
        ->assertSee('Consulting');
});

test('service detail returns 404 when show_cards is disabled', function () {
    $this->services->update(['show_page' => true, 'show_cards' => false]);

    $card = ServiceCard::factory()->create(['is_published' => true]);

    $this->get(route('site.services.show', $card->slug))->assertNotFound();
});

test('services can show page and cards together', function () {
    $this->services->update(['show_page' => true, 'show_cards' => true]);
    $this->services->page->update(['title' => 'Services Intro']);

    ServiceCard::factory()->create([
        'title' => 'Design',
        'is_published' => true,
    ]);

    $this->get(route('site.services.index'))
        ->assertOk()
        ->assertSee('Services Intro')
        ->assertSee('Design');
});
