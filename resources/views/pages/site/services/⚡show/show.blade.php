<article class="space-y-6">
    <h1 class="text-3xl font-semibold tracking-tight">{{ $card->title }}</h1>

    @if ($card->imageUrl())
        <img src="{{ $card->imageUrl() }}" alt="{{ $card->title }}" class="max-h-96 w-full rounded-lg object-cover">
    @endif

    <div class="prose prose-zinc dark:prose-invert max-w-none">
        {!! $card->text !!}
    </div>
</article>
