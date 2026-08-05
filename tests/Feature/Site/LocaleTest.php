<?php

use Livewire\Livewire;

test('locale can be switched via livewire action and persists in session', function () {
    Livewire::test('site.locale-switcher')
        ->call('switchLocale', 'az')
        ->assertRedirect()
        ->assertSessionHas('locale', 'az');
});

test('switching to azerbaijani translates home page strings', function () {
    $this->withSession(['locale' => 'az'])
        ->get(route('home'))
        ->assertOk()
        ->assertSee('Daxil ol', false)
        ->assertSee('Modul bölmələrlə müasir saytlar qurun', false);
});

test('switching to russian translates home page strings', function () {
    $this->withSession(['locale' => 'ru'])
        ->get(route('home'))
        ->assertOk()
        ->assertSee('Войти', false)
        ->assertSee('Создавайте современные сайты с модульными разделами', false);
});

test('unsupported locale aborts with not found', function () {
    Livewire::test('site.locale-switcher')
        ->call('switchLocale', 'fr')
        ->assertStatus(404);
});

test('site layout includes appearance and language controls', function () {
    $this->get(route('home'))
        ->assertOk()
        ->assertSee(__('Appearance'), false)
        ->assertSee(__('Language'), false)
        ->assertSee(__('Light'), false)
        ->assertSee('EN', false)
        ->assertSee('__fluxApplyAppearance', false)
        ->assertSee('reapplyFluxAppearance', false)
        ->assertSee('x-effect="window.__fluxApplyAppearance($flux.appearance)"', false);
});
