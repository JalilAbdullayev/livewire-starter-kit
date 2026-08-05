<div class="space-y-16">
    <section class="space-y-6 text-center">
        <p class="text-sm font-medium uppercase tracking-widest text-amber-600">{{ config('app.name') }}</p>

        <h1 class="text-4xl font-semibold tracking-tight sm:text-5xl">
            {{ __('Build modern sites with modular sections') }}
        </h1>

        <p class="mx-auto max-w-2xl text-lg text-zinc-600 dark:text-zinc-300">
            {{ __('Enable only the pages you need, manage content from the admin panel, and ship landing pages, portfolios, and more on the TALL stack.') }}
        </p>

        @if ($this->primaryAction)
            <div class="flex flex-wrap items-center justify-center gap-3">
                <flux:button :href="$this->primaryAction['href']" variant="primary" wire:navigate>
                    {{ $this->primaryAction['label'] }}
                </flux:button>

                @auth
                    <flux:button :href="route('dashboard')" variant="ghost" wire:navigate>
                        {{ __('Dashboard') }}
                    </flux:button>
                @else
                    <flux:button :href="route('login')" variant="ghost" wire:navigate>
                        {{ __('Log in') }}
                    </flux:button>
                @endauth
            </div>
        @endif
    </section>

    @if ($this->activeModules->isNotEmpty())
        <section class="space-y-6">
            <div class="space-y-2 text-center">
                <h2 class="text-2xl font-semibold tracking-tight">{{ __('Explore') }}</h2>
                <p class="text-zinc-600 dark:text-zinc-300">{{ __('Browse the sections currently live on this site.') }}</p>
            </div>

            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($this->activeModules as $module)
                    <a
                        href="{{ route($module->key->routeName()) }}"
                        class="rounded-xl border border-zinc-200 p-5 transition hover:border-amber-500 dark:border-zinc-700 dark:hover:border-amber-500"
                        wire:navigate
                    >
                        <h3 class="text-lg font-semibold">{{ $module->label }}</h3>
                        @if (filled($module->page?->content))
                            <p class="mt-2 line-clamp-3 text-sm text-zinc-600 dark:text-zinc-300">
                                {{ \Illuminate\Support\Str::limit(strip_tags($module->page->content), 120) }}
                            </p>
                        @else
                            <p class="mt-2 text-sm text-zinc-500">{{ __('Learn more about :label.', ['label' => strtolower($module->label)]) }}</p>
                        @endif
                    </a>
                @endforeach
            </div>
        </section>
    @else
        <section class="rounded-xl border border-dashed border-zinc-300 p-8 text-center dark:border-zinc-700">
            <p class="text-zinc-600 dark:text-zinc-300">{{ __('No public sections are live yet. Check back soon.') }}</p>
        </section>
    @endif

    @if ($this->latestPosts->isNotEmpty())
        <section class="space-y-6">
            <div class="flex items-end justify-between gap-4">
                <div class="space-y-2">
                    <h2 class="text-2xl font-semibold tracking-tight">{{ __('Latest posts') }}</h2>
                    <p class="text-zinc-600 dark:text-zinc-300">{{ __('Fresh updates from the blog.') }}</p>
                </div>

                <flux:link :href="route('site.blog.index')" wire:navigate>
                    {{ __('View all') }}
                </flux:link>
            </div>

            <div class="grid gap-4 md:grid-cols-3">
                @foreach ($this->latestPosts as $post)
                    <article class="rounded-xl border border-zinc-200 p-5 dark:border-zinc-700">
                        <h3 class="text-lg font-semibold">
                            <a href="{{ route('site.blog.show', $post->slug) }}" class="hover:text-amber-600" wire:navigate>
                                {{ $post->title }}
                            </a>
                        </h3>
                        @if (filled($post->excerpt))
                            <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-300">{{ $post->excerpt }}</p>
                        @endif
                    </article>
                @endforeach
            </div>
        </section>
    @endif

    @if ($this->featuredServiceCards->isNotEmpty())
        <section class="space-y-6">
            <div class="flex items-end justify-between gap-4">
                <div class="space-y-2">
                    <h2 class="text-2xl font-semibold tracking-tight">{{ __('Services') }}</h2>
                    <p class="text-zinc-600 dark:text-zinc-300">{{ __('What we can help you with.') }}</p>
                </div>

                <flux:link :href="route('site.services.index')" wire:navigate>
                    {{ __('View all') }}
                </flux:link>
            </div>

            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($this->featuredServiceCards as $card)
                    <a
                        href="{{ route('site.services.show', $card->slug) }}"
                        class="overflow-hidden rounded-xl border border-zinc-200 transition hover:border-amber-500 dark:border-zinc-700"
                        wire:navigate
                    >
                        @if ($card->imageUrl())
                            <img src="{{ $card->imageUrl() }}" alt="{{ $card->title }}" class="aspect-video w-full object-cover">
                        @endif
                        <div class="space-y-2 p-4">
                            <h3 class="text-lg font-semibold">{{ $card->title }}</h3>
                            @if (filled($card->excerpt))
                                <p class="text-sm text-zinc-600 dark:text-zinc-300">{{ $card->excerpt }}</p>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
        </section>
    @endif
</div>
