<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

#[Fillable([
    'meta_title',
    'meta_description',
    'meta_keywords',
    'canonical_url',
    'robots',
    'og_title',
    'og_description',
    'og_image',
    'og_type',
    'og_url',
    'og_site_name',
    'meta_author',
    'meta_extra',
])]
class SeoMeta extends Model
{
    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'meta_extra' => 'array',
        ];
    }

    /**
     * @return MorphTo<Model, $this>
     */
    public function seoable(): MorphTo
    {
        return $this->morphTo();
    }
}
