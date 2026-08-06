<?php

use App\Enums\LocaleEnum;
use App\Enums\SiteModuleEnum;
use App\Models\SiteModule;
use App\Support\LocalizedRoute;
use Database\Seeders\SiteModulesSeeder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

beforeEach(function () {
    $this->seed(SiteModulesSeeder::class);
});

test('azerbaijani routes use localized slugs without prefix', function () {
    SiteModule::query()->where('key', SiteModuleEnum::About)->update(['is_active' => true]);
    SiteModule::clearActiveCache();

    $this->get('/haqqimizda')
        ->assertOk();

    expect(localized_route('site.about'))->toEndWith('/haqqimizda');
});

test('english routes use locale prefix and localized slug', function () {
    SiteModule::query()->where('key', SiteModuleEnum::About)->update(['is_active' => true]);
    SiteModule::clearActiveCache();

    $this->get('/en/about-us')
        ->assertOk()
        ->assertSessionHas('locale', 'en');

    expect(localized_route('site.about', [], LocaleEnum::English))
        ->toEndWith('/en/about-us');
});

test('russian routes use locale prefix and localized slug', function () {
    SiteModule::query()->where('key', SiteModuleEnum::About)->update(['is_active' => true]);
    SiteModule::clearActiveCache();

    $this->get('/ru/o-nas')
        ->assertOk()
        ->assertSessionHas('locale', 'ru');
});

test('legacy english slugs are not registered', function () {
    SiteModule::query()->where('key', SiteModuleEnum::About)->update(['is_active' => true]);
    SiteModule::clearActiveCache();

    $this->get('/about')->assertNotFound();
});

test('localized route names are registered for each locale', function () {
    expect(Route::has('home'))->toBeTrue()
        ->and(Route::has('en.home'))->toBeTrue()
        ->and(Route::has('ru.home'))->toBeTrue()
        ->and(Route::has('site.about'))->toBeTrue()
        ->and(Route::has('en.site.about'))->toBeTrue()
        ->and(Route::has('ru.site.about'))->toBeTrue();
});

test('locale switcher renders wire navigate links to localized equivalent urls', function () {
    SiteModule::query()->where('key', SiteModuleEnum::About)->update(['is_active' => true]);
    SiteModule::clearActiveCache();

    $this->get(localized_route('site.about', [], LocaleEnum::Azerbaijani))
        ->assertOk()
        ->assertSee('wire:navigate', false)
        ->assertSee(localized_route('site.about', [], LocaleEnum::English), false)
        ->assertSee(localized_route('site.about', [], LocaleEnum::Russian), false);
});

test('switching to azerbaijani translates home page strings', function () {
    $this->get(localized_route('home', [], LocaleEnum::Azerbaijani))
        ->assertOk()
        ->assertSee('Daxil ol', false)
        ->assertSee('Modul bölmələrlə müasir saytlar qurun', false);
});

test('switching to russian translates home page strings', function () {
    $this->get(localized_route('home', [], LocaleEnum::Russian))
        ->assertOk()
        ->assertSee('Войти', false)
        ->assertSee('Создавайте современные сайты с модульными разделами', false);
});

test('visiting localized url syncs locale in session', function () {
    $this->get('/en')
        ->assertOk()
        ->assertSessionHas('locale', 'en');
});

test('site layout includes appearance and language controls', function () {
    $this->get(localized_route('home', [], LocaleEnum::Azerbaijani))
        ->assertOk()
        ->assertSee(__('Appearance'), false)
        ->assertSee(__('Language'), false)
        ->assertSee(__('Light'), false)
        ->assertSee('AZ', false);
});

test('localized route helper resolves current locale from application', function () {
    app()->setLocale('en');

    expect(localized_route('site.contact'))->toEndWith('/en/contact');
});

test('english home page exposes a valid livewire update endpoint', function () {
    $response = $this->get('/en')->assertOk();

    expect($response->getContent())
        ->toContain('data-update-uri="')
        ->not->toContain('en.default-livewire.update');

    expect(Route::has('default-livewire.update'))->toBeTrue()
        ->and(Route::has('en.default-livewire.update'))->toBeFalse();
});

test('switch locale url maps current route to target locale', function () {
    SiteModule::query()->where('key', SiteModuleEnum::About)->update(['is_active' => true]);
    SiteModule::clearActiveCache();

    $this->get(localized_route('site.about', [], LocaleEnum::Azerbaijani))->assertOk();

    expect(request()->route()?->getName())->toBe('site.about')
        ->and(LocalizedRoute::switchLocaleUrl(LocaleEnum::English))
        ->toBe(localized_route('site.about', [], LocaleEnum::English));
});

test('switch locale url ignores livewire update route and uses referer page', function () {
    SiteModule::query()->where('key', SiteModuleEnum::About)->update(['is_active' => true]);
    SiteModule::clearActiveCache();

    $aboutUrl = localized_route('site.about', [], LocaleEnum::Azerbaijani);
    $updatePath = parse_url(route('default-livewire.update'), PHP_URL_PATH);

    $request = Request::create($updatePath, 'POST', server: [
        'HTTP_REFERER' => $aboutUrl,
    ]);
    $request->setRouteResolver(fn () => Route::getRoutes()->getByName('default-livewire.update'));
    app()->instance('request', $request);

    expect(LocalizedRoute::switchLocaleUrl(LocaleEnum::English))
        ->toBe(localized_route('site.about', [], LocaleEnum::English));
});
