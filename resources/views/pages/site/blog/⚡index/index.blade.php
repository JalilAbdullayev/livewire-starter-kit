<div class="space-y-8">
    <h1 class="text-3xl font-semibold tracking-tight">{{ $siteModule->label }}</h1>

    <div class="grid gap-6">
        @forelse ($this->posts as $post)
            <article class="rounded-lg border border-zinc-200 p-5 dark:border-zinc-700">
                <h2 class="text-xl font-semibold">
                    <a href="{{ localized_route('site.blog.show', $post->slug) }}" class="hover:text-amber-600"
                        wire:navigate>
                        {{ $post->title }}
                    </a>
                </h2>
                @if (filled($post->excerpt))
                    <p class="mt-2 text-zinc-600 dark:text-zinc-300">{{ $post->excerpt }}</p>
                @endif
            </article>
        @empty
            <p class="text-zinc-500">{{ __('No posts published yet.') }}</p>
        @endforelse
    </div>

    {{ $this->posts->links() }}
</div>
