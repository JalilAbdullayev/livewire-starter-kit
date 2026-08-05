<div class="space-y-8">
    <h1 class="text-3xl font-semibold tracking-tight">{{ $siteModule->label }}</h1>

    <div class="space-y-4">
        @forelse ($this->items as $item)
            <details class="rounded-lg border border-zinc-200 p-4 dark:border-zinc-700">
                <summary class="cursor-pointer font-medium">{{ $item->question }}</summary>
                <div class="prose prose-zinc dark:prose-invert mt-3 max-w-none text-sm">
                    {!! nl2br(e($item->answer)) !!}
                </div>
            </details>
        @empty
            <p class="text-zinc-500">{{ __('No FAQs published yet.') }}</p>
        @endforelse
    </div>
</div>
