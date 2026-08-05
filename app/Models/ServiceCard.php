<?php

namespace App\Models;

use App\Models\Concerns\HasSeoMeta;
use Database\Factories\ServiceCardFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

#[Fillable([
    'title',
    'slug',
    'image',
    'excerpt',
    'text',
    'sort_order',
    'is_published',
])]
class ServiceCard extends Model
{
    /** @use HasFactory<ServiceCardFactory> */
    use HasFactory, HasSeoMeta;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    /**
     * @param  Builder<ServiceCard>  $query
     * @return Builder<ServiceCard>
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    public function imageUrl(): ?string
    {
        if ($this->image === null || $this->image === '') {
            return null;
        }

        return Storage::disk('public')->url($this->image);
    }
}
