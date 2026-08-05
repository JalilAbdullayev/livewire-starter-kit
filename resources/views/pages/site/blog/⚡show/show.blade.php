<article class="prose prose-zinc dark:prose-invert max-w-none">
    <h1>{{ $post->title }}</h1>
    @if (filled($post->excerpt))
        <p class="lead">{{ $post->excerpt }}</p>
    @endif
    <div>{!! $post->content !!}</div>
</article>
