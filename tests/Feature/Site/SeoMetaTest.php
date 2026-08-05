<?php

use App\Enums\SiteModuleEnum;
use App\Models\SiteModule;
use Database\Seeders\SiteModulesSeeder;

beforeEach(function () {
    $this->seed(SiteModulesSeeder::class);

    $module = SiteModule::findByKey(SiteModuleEnum::About);
    $module->update(['is_active' => true]);

    $page = $module->page;
    $page->ensureSeoMeta()->update([
        'meta_title' => 'About SEO Title',
        'meta_description' => 'About SEO Description',
        'og_title' => 'About OG Title',
        'og_description' => 'About OG Description',
        'og_image' => 'https://example.com/og.png',
    ]);
});

test('public pages render seo meta and twitter tags from open graph', function () {
    $response = $this->get(route('site.about'));

    $response->assertOk()
        ->assertSee('<title>About SEO Title</title>', false)
        ->assertSee('name="description" content="About SEO Description"', false)
        ->assertSee('property="og:title" content="About OG Title"', false)
        ->assertSee('property="og:description" content="About OG Description"', false)
        ->assertSee('property="og:image" content="https://example.com/og.png"', false)
        ->assertSee('name="twitter:title" content="About OG Title"', false)
        ->assertSee('name="twitter:description" content="About OG Description"', false)
        ->assertSee('name="twitter:image" content="https://example.com/og.png"', false);
});
