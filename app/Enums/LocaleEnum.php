<?php

namespace App\Enums;

enum LocaleEnum: string
{
    case Azerbaijani = 'az';
    case English = 'en';
    case Russian = 'ru';

    public static function default(): self
    {
        return self::Azerbaijani;
    }

    public static function current(): self
    {
        return self::from(app()->getLocale());
    }

    /**
     * @return list<self>
     */
    public static function prefixed(): array
    {
        return array_values(array_filter(
            self::cases(),
            fn (self $locale): bool => ! $locale->isDefault(),
        ));
    }

    /**
     * @return list<string>
     */
    public static function prefixedValues(): array
    {
        return array_map(
            fn (self $locale): string => $locale->value,
            self::prefixed(),
        );
    }

    public function isDefault(): bool
    {
        return $this === self::default();
    }

    public function label(): string
    {
        return match ($this) {
            self::Azerbaijani => 'Azərbaycan',
            self::English => 'English',
            self::Russian => 'Русский',
        };
    }

    public static function isSupported(string $locale): bool
    {
        return self::tryFrom($locale) !== null;
    }

    /**
     * @return list<string>
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
