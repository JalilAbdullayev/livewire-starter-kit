<section class="w-full space-y-8">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
        <div class="space-y-1">
            <flux:heading size="xl">{{ __('Welcome back, :name', ['name' => auth()->user()->name]) }}</flux:heading>
            <flux:text>{{ __('Manage your account and site from here.') }}</flux:text>
        </div>

        <div class="flex flex-wrap gap-2">
            <flux:button :href="localized_route('home')" variant="ghost" icon="globe-alt" wire:navigate>
                {{ __('View site') }}
            </flux:button>

            <flux:button :href="route('profile.edit')" variant="ghost" icon="cog-6-tooth" wire:navigate>
                {{ __('Settings') }}
            </flux:button>

            @if ($this->canAccessAdminPanel)
                <flux:button :href="route('filament.admin.pages.dashboard')" variant="primary" icon="squares-2x2">
                    {{ __('Admin panel') }}
                </flux:button>
            @endif
        </div>
    </div>

    <div class="grid gap-4 md:grid-cols-3">
        <div class="rounded-xl border border-zinc-200 p-5 dark:border-zinc-700">
            <div class="flex items-start justify-between gap-3">
                <div class="space-y-2">
                    <flux:text class="text-zinc-500">{{ __('Email verification') }}</flux:text>
                    <flux:heading size="lg">
                        {{ $this->emailIsVerified ? __('Verified') : __('Not verified') }}
                    </flux:heading>
                </div>
                <flux:icon.envelope class="size-5 text-zinc-400" />
            </div>
            @if (!$this->emailIsVerified)
                <flux:text class="mt-3 text-sm">
                    <flux:link :href="route('profile.edit')" wire:navigate>{{ __('Verify in profile settings') }}
                    </flux:link>
                </flux:text>
            @endif
        </div>

        <div class="rounded-xl border border-zinc-200 p-5 dark:border-zinc-700">
            <div class="flex items-start justify-between gap-3">
                <div class="space-y-2">
                    <flux:text class="text-zinc-500">{{ __('Two-factor authentication') }}</flux:text>
                    <flux:heading size="lg">
                        {{ $this->twoFactorEnabled ? __('Enabled') : __('Disabled') }}
                    </flux:heading>
                </div>
                <flux:icon.shield-check class="size-5 text-zinc-400" />
            </div>
            @if (!$this->twoFactorEnabled)
                <flux:text class="mt-3 text-sm">
                    <flux:link :href="route('security.edit')" wire:navigate>{{ __('Enable in security settings') }}
                    </flux:link>
                </flux:text>
            @endif
        </div>

        <div class="rounded-xl border border-zinc-200 p-5 dark:border-zinc-700">
            <div class="flex items-start justify-between gap-3">
                <div class="space-y-2">
                    <flux:text class="text-zinc-500">{{ __('Passkeys') }}</flux:text>
                    <flux:heading size="lg">
                        {{ trans_choice(':count passkey|:count passkeys', $this->passkeysCount, ['count' => $this->passkeysCount]) }}
                    </flux:heading>
                </div>
                <flux:icon.key class="size-5 text-zinc-400" />
            </div>
            @if ($this->passkeysCount === 0)
                <flux:text class="mt-3 text-sm">
                    <flux:link :href="route('security.edit')" wire:navigate>
                        {{ __('Add a passkey in security settings') }}</flux:link>
                </flux:text>
            @endif
        </div>
    </div>

    <div class="rounded-xl border border-zinc-200 p-6 dark:border-zinc-700">
        <div class="mb-4 space-y-1">
            <flux:heading size="lg">{{ __('Getting started') }}</flux:heading>
            <flux:text>{{ __('Complete these steps to get the most out of your starter kit.') }}</flux:text>
        </div>

        <ul class="space-y-3">
            @foreach ($this->gettingStartedSteps as $step)
                <li class="flex items-start gap-3">
                    <span @class([
                        'mt-0.5 flex size-5 shrink-0 items-center justify-center rounded-full text-xs font-semibold',
                        'bg-emerald-100 text-emerald-700 dark:bg-emerald-950 dark:text-emerald-300' =>
                            $step['done'],
                        'bg-zinc-100 text-zinc-500 dark:bg-zinc-800 dark:text-zinc-400' => !$step[
                            'done'
                        ],
                    ])>
                        @if ($step['done'])
                            <flux:icon.check class="size-3.5" />
                        @endif
                    </span>

                    <div class="min-w-0 flex-1">
                        @if ($step['href'])
                            <flux:link :href="$step['href']" class="font-medium" wire:navigate>
                                {{ $step['label'] }}
                            </flux:link>
                        @else
                            <flux:text class="font-medium">{{ $step['label'] }}</flux:text>
                        @endif
                    </div>
                </li>
            @endforeach
        </ul>
    </div>

    @if ($this->canAccessAdminPanel)
        <div class="space-y-4">
            <div class="space-y-1">
                <flux:heading size="lg">{{ __('Site overview') }}</flux:heading>
                <flux:text>{{ __('A quick snapshot of your site content and modules.') }}</flux:text>
            </div>

            <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
                <div class="rounded-xl border border-zinc-200 p-5 dark:border-zinc-700">
                    <flux:text class="text-zinc-500">{{ __('Unread messages') }}</flux:text>
                    <flux:heading size="xl" class="mt-2">{{ $this->adminSnapshot['unreadContactMessages'] }}
                    </flux:heading>
                </div>

                <div class="rounded-xl border border-zinc-200 p-5 dark:border-zinc-700">
                    <flux:text class="text-zinc-500">{{ __('Active modules') }}</flux:text>
                    <flux:heading size="xl" class="mt-2">{{ $this->adminSnapshot['activeModules'] }}
                    </flux:heading>
                </div>

                <div class="rounded-xl border border-zinc-200 p-5 dark:border-zinc-700">
                    <flux:text class="text-zinc-500">{{ __('Inactive modules') }}</flux:text>
                    <flux:heading size="xl" class="mt-2">{{ $this->adminSnapshot['inactiveModules'] }}
                    </flux:heading>
                </div>

                <div class="rounded-xl border border-zinc-200 p-5 dark:border-zinc-700">
                    <flux:text class="text-zinc-500">{{ __('Unpublished blog posts') }}</flux:text>
                    <flux:heading size="xl" class="mt-2">{{ $this->adminSnapshot['unpublishedBlogPosts'] }}
                    </flux:heading>
                </div>

                <div class="rounded-xl border border-zinc-200 p-5 dark:border-zinc-700">
                    <flux:text class="text-zinc-500">{{ __('Unpublished FAQ items') }}</flux:text>
                    <flux:heading size="xl" class="mt-2">{{ $this->adminSnapshot['unpublishedFaqItems'] }}
                    </flux:heading>
                </div>

                <div class="rounded-xl border border-zinc-200 p-5 dark:border-zinc-700">
                    <flux:text class="text-zinc-500">{{ __('Unpublished service cards') }}</flux:text>
                    <flux:heading size="xl" class="mt-2">{{ $this->adminSnapshot['unpublishedServiceCards'] }}
                    </flux:heading>
                </div>
            </div>

            <div class="rounded-xl border border-zinc-200 p-6 dark:border-zinc-700">
                <flux:heading size="md" class="mb-4">{{ __('Manage in admin') }}</flux:heading>

                <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($this->adminLinks as $link)
                        <a href="{{ $link['href'] }}"
                            class="flex items-center justify-between rounded-lg border border-zinc-200 px-4 py-3 transition hover:border-amber-500 dark:border-zinc-700 dark:hover:border-amber-500">
                            <span class="font-medium">{{ $link['label'] }}</span>
                            <flux:badge>{{ $link['value'] }}</flux:badge>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</section>
