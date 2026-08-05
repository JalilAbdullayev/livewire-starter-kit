<?php

namespace App\Models;

use App\Enums\SiteModuleEnum;
use App\Enums\SiteModuleTypeEnum;
use App\Models\Concerns\HasSeoMeta;
use Database\Factories\SiteModuleFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Cache;

/**
 * @property SiteModuleEnum $key
 * @property SiteModuleTypeEnum $type
 * @property string $label
 * @property bool $is_active
 * @property int $sort_order
 * @property bool $show_page
 * @property bool $show_cards
 */
#[Fillable([
    'key',
    'type',
    'label',
    'is_active',
    'sort_order',
    'show_page',
    'show_cards',
])]
class SiteModule extends Model
{
    /** @use HasFactory<SiteModuleFactory> */
    use HasFactory, HasSeoMeta;

    public const ACTIVE_CACHE_KEY = 'site_modules.active_keys';

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'key' => SiteModuleEnum::class,
            'type' => SiteModuleTypeEnum::class,
            'is_active' => 'boolean',
            'show_page' => 'boolean',
            'show_cards' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    protected static function booted(): void
    {
        static::saved(fn () => self::clearActiveCache());
        static::deleted(fn () => self::clearActiveCache());
    }

    /**
     * @return HasOne<Page, $this>
     */
    public function page(): HasOne
    {
        return $this->hasOne(Page::class);
    }

    /**
     * @param  Builder<SiteModule>  $query
     * @return Builder<SiteModule>
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public static function isActive(SiteModuleEnum $key): bool
    {
        /** @var list<string> $activeKeys */
        $activeKeys = Cache::rememberForever(self::ACTIVE_CACHE_KEY, function (): array {
            return self::query()
                ->active()
                ->pluck('key')
                ->map(fn (SiteModuleEnum|string $key): string => $key instanceof SiteModuleEnum ? $key->value : $key)
                ->all();
        });

        return in_array($key->value, $activeKeys, true);
    }

    public static function clearActiveCache(): void
    {
        Cache::forget(self::ACTIVE_CACHE_KEY);
    }

    public static function findByKey(SiteModuleEnum $key): ?self
    {
        return self::query()->where('key', $key)->first();
    }
}
