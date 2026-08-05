@props([
    'model' => null,
    'fallbackTitle' => null,
    'fallbackDescription' => null,
])

@php
    use App\Models\Concerns\HasSeoMeta;
    use App\Models\SeoMeta;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Support\Facades\Storage;

    $seo = null;

    if ($model instanceof Model && in_array(HasSeoMeta::class, class_uses_recursive($model), true)) {
        $seo = $model->seoMeta;
    } elseif ($model instanceof SeoMeta) {
        $seo = $model;
    }

    $title = $seo?->meta_title
        ?: $fallbackTitle
        ?: (is_object($model) && isset($model->title) ? $model->title : null)
        ?: (is_object($model) && isset($model->label) ? (string) $model->label : null)
        ?: config('app.name');

    $description = $seo?->meta_description
        ?: $fallbackDescription
        ?: (is_object($model) && isset($model->excerpt) ? $model->excerpt : null);

    $keywords = $seo?->meta_keywords;
    $canonical = $seo?->canonical_url;
    $robots = $seo?->robots;
    $author = $seo?->meta_author;

    $ogTitle = $seo?->og_title ?: $title;
    $ogDescription = $seo?->og_description ?: $description;
    $ogImage = $seo?->og_image;
    $ogType = $seo?->og_type ?: 'website';
    $ogUrl = $seo?->og_url ?: url()->current();
    $ogSiteName = $seo?->og_site_name ?: config('app.name');

    $ogImageUrl = filled($ogImage)
        ? (str_starts_with($ogImage, 'http') ? $ogImage : Storage::disk('public')->url($ogImage))
        : null;

    $extras = is_array($seo?->meta_extra) ? $seo->meta_extra : [];
@endphp

<title>{{ $title }}</title>

@if (filled($description))
    <meta name="description" content="{{ $description }}">
@endif

@if (filled($keywords))
    <meta name="keywords" content="{{ $keywords }}">
@endif

@if (filled($author))
    <meta name="author" content="{{ $author }}">
@endif

@if (filled($robots))
    <meta name="robots" content="{{ $robots }}">
@endif

@if (filled($canonical))
    <link rel="canonical" href="{{ $canonical }}">
@endif

<meta property="og:title" content="{{ $ogTitle }}">
@if (filled($ogDescription))
    <meta property="og:description" content="{{ $ogDescription }}">
@endif
@if (filled($ogImageUrl))
    <meta property="og:image" content="{{ $ogImageUrl }}">
@endif
<meta property="og:type" content="{{ $ogType }}">
<meta property="og:url" content="{{ $ogUrl }}">
<meta property="og:site_name" content="{{ $ogSiteName }}">

<meta name="twitter:card" content="{{ filled($ogImageUrl) ? 'summary_large_image' : 'summary' }}">
<meta name="twitter:title" content="{{ $ogTitle }}">
@if (filled($ogDescription))
    <meta name="twitter:description" content="{{ $ogDescription }}">
@endif
@if (filled($ogImageUrl))
    <meta name="twitter:image" content="{{ $ogImageUrl }}">
@endif

@foreach ($extras as $name => $content)
    @if (filled($name) && filled($content))
        <meta name="{{ $name }}" content="{{ $content }}">
    @endif
@endforeach
