<flux:dropdown position="bottom" align="end">
    <flux:button variant="ghost" size="sm" square :label="__('Language')">
        {{ strtoupper($this->currentLocale()->value) }}
    </flux:button>

    <flux:menu>
        @foreach (\App\Enums\LocaleEnum::cases() as $locale)
            <flux:menu.item
                wire:click="switchLocale('{{ $locale->value }}')"
                @class(['font-semibold' => $locale === $this->currentLocale()])
            >
                {{ $locale->label() }}
            </flux:menu.item>
        @endforeach
    </flux:menu>
</flux:dropdown>
