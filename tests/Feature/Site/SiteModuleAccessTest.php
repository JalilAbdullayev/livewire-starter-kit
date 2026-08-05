<?php

use App\Enums\SiteModuleEnum;
use App\Models\SiteModule;
use Database\Seeders\SiteModulesSeeder;

beforeEach(function () {
    $this->seed(SiteModulesSeeder::class);
});

test('site modules seeder creates all modules and pages', function () {
    expect(SiteModule::query()->count())->toBe(count(SiteModuleEnum::cases()));

    foreach (SiteModuleEnum::cases() as $module) {
        $siteModule = SiteModule::findByKey($module);

        expect($siteModule)->not->toBeNull()
            ->and($siteModule->is_active)->toBeFalse();

        if ($module->hasPage()) {
            expect($siteModule->page)->not->toBeNull();
        }
    }
});

test('inactive modules return 404 on public routes', function () {
    $this->get(route('site.about'))->assertNotFound();
    $this->get(route('site.contact'))->assertNotFound();
    $this->get(route('site.blog.index'))->assertNotFound();
    $this->get(route('site.faq'))->assertNotFound();
    $this->get(route('site.services.index'))->assertNotFound();
});

test('active modules return 200 on public routes', function () {
    SiteModule::query()->update(['is_active' => true]);
    SiteModule::query()->where('key', SiteModuleEnum::Services)->update([
        'show_page' => true,
        'show_cards' => true,
    ]);
    SiteModule::clearActiveCache();

    $this->get(route('site.about'))->assertOk();
    $this->get(route('site.contact'))->assertOk();
    $this->get(route('site.blog.index'))->assertOk();
    $this->get(route('site.privacy'))->assertOk();
    $this->get(route('site.terms'))->assertOk();
    $this->get(route('site.faq'))->assertOk();
    $this->get(route('site.services.index'))->assertOk();
});
