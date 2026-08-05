<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <x-seo :model="$seoable ?? null" :fallback-title="$fallbackTitle ?? null" :fallback-description="$fallbackDescription ?? null" />

        <link rel="icon" href="/favicon.ico" sizes="any">
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">

        @fonts
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @include('partials.flux-appearance')
    </head>
    <body class="min-h-screen bg-white text-zinc-900 antialiased dark:bg-zinc-900 dark:text-zinc-100">
        <header class="border-b border-zinc-200 dark:border-zinc-800">
            <div class="mx-auto flex max-w-5xl items-center justify-between gap-4 px-4 py-4">
                <a href="{{ route('home') }}" class="text-lg font-semibold tracking-tight" wire:navigate>
                    {{ config('app.name') }}
                </a>

                <nav class="flex flex-wrap items-center gap-2 text-sm sm:gap-4">
                    @foreach (\App\Models\SiteModule::query()->active()->orderBy('sort_order')->get() as $navModule)
                        <a
                            href="{{ route($navModule->key->routeName()) }}"
                            @class([
                                'hover:text-amber-600',
                                'font-semibold text-amber-600' => request()->routeIs($navModule->key->routeName()) || request()->routeIs($navModule->key->value.'.*'),
                            ])
                            wire:navigate
                        >
                            {{ $navModule->label }}
                        </a>
                    @endforeach

                    <div class="flex items-center gap-1 border-s border-zinc-200 ps-2 dark:border-zinc-700">
                        <x-site.appearance-toggle />
                        <livewire:site.locale-switcher />
                    </div>

                    @auth
                        <a href="{{ route('dashboard') }}" class="hover:text-amber-600" wire:navigate>{{ __('Dashboard') }}</a>
                    @else
                        <a href="{{ route('login') }}" class="hover:text-amber-600" wire:navigate>{{ __('Log in') }}</a>
                    @endauth
                </nav>
            </div>
        </header>

        <main class="mx-auto max-w-5xl px-4 py-10">
            {{ $slot }}
        </main>

        <footer class="border-t border-zinc-200 py-8 text-center text-sm text-zinc-500 dark:border-zinc-800">
            &copy; {{ now()->year }} {{ config('app.name') }}
        </footer>

        @fluxScripts
    </body>
</html>
