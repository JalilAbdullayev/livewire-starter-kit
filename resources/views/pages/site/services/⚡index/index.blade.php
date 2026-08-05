<div class="space-y-10">
    <h1 class="text-3xl font-semibold tracking-tight">{{ $siteModule->label }}</h1>

    @if ($siteModule->show_page)
        <article class="prose prose-zinc dark:prose-invert max-w-none">
            <h2>{{ $page?->title ?? $siteModule->label }}</h2>
            @if (filled($page?->content))
                <div>{!! $page->content !!}</div>
            @else
                <p>{{ __('Content coming soon.') }}</p>
            @endif
        </article>
    @endif

    @if ($siteModule->show_cards)
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($this->cards as $card)
                <a
                    href="{{ route('site.services.show', $card->slug) }}"
                    class="block overflow-hidden rounded-lg border border-zinc-200 transition hover:border-amber-500 dark:border-zinc-700"
                    wire:navigate
                >
                    @if ($card->imageUrl())
                        <img src="{{ $card->imageUrl() }}" alt="{{ $card->title }}" class="aspect-video w-full object-cover">
                    @endif
                    <div class="space-y-2 p-4">
                        <h2 class="text-lg font-semibold">{{ $card->title }}</h2>
                        @if (filled($card->excerpt))
                            <p class="text-sm text-zinc-600 dark:text-zinc-300">{{ $card->excerpt }}</p>
                        @endif
                    </div>
                </a>
            @empty
                <p class="text-zinc-500 sm:col-span-2 lg:col-span-3">{{ __('No services published yet.') }}</p>
            @endforelse
        </div>
    @endif

    @if (! $siteModule->show_page && ! $siteModule->show_cards)
        <p class="text-zinc-500">{{ __('This section is active but has no page or cards enabled yet.') }}</p>
    @endif
</div>
