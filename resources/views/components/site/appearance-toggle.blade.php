<div wire:ignore>
    <flux:dropdown position="bottom" align="end" x-data>
        <flux:button variant="ghost" size="sm" icon="sun" square :label="__('Appearance')" />

        <flux:menu>
            <flux:menu.radio.group
                x-model="$flux.appearance"
                x-effect="window.__fluxApplyAppearance($flux.appearance)"
            >
                <flux:menu.radio value="light" icon="sun">{{ __('Light') }}</flux:menu.radio>
                <flux:menu.radio value="dark" icon="moon">{{ __('Dark') }}</flux:menu.radio>
                <flux:menu.radio value="system" icon="computer-desktop">{{ __('System') }}</flux:menu.radio>
            </flux:menu.radio.group>
        </flux:menu>
    </flux:dropdown>
</div>
