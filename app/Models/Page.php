<?php

namespace App\Models;

use App\Models\Concerns\HasSeoMeta;
use Database\Factories\PageFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'site_module_id',
    'title',
    'slug',
    'content',
])]
class Page extends Model
{
    /** @use HasFactory<PageFactory> */
    use HasFactory, HasSeoMeta;

    /**
     * @return BelongsTo<SiteModule, $this>
     */
    public function siteModule(): BelongsTo
    {
        return $this->belongsTo(SiteModule::class);
    }
}
