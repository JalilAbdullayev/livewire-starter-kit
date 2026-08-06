@php
    use App\Enums\LocaleEnum;
    use App\Support\LocalizedRoute;

    $currentLocale = LocaleEnum::from(app()->getLocale());
@endphp

<flux:dropdown position="bottom" align="end">
    <flux:button variant="ghost" size="sm" square :label="__('Language')">
        {{ strtoupper($currentLocale->value) }}
    </flux:button>

    <flux:menu>
        @foreach (LocaleEnum::cases() as $locale)
            <flux:menu.item :href="LocalizedRoute::switchLocaleUrl($locale)" wire:navigate @class(['font-semibold' => $locale === $currentLocale])>
                {{ $locale->label() }}
            </flux:menu.item>
        @endforeach
    </flux:menu>
</flux:dropdown>
