<div>
    <article class="prose prose-zinc dark:prose-invert max-w-none">
        <h1>{{ $page?->title ?? $siteModule->label }}</h1>
        @if (filled($page?->content))
            <div>{!! $page->content !!}</div>
        @else
            <p>{{ __('Content coming soon.') }}</p>
        @endif
    </article>
</div>
