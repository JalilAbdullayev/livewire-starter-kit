<?php

namespace App\Enums;

enum LocaleEnum: string
{
    case Azerbaijani = 'az';
    case English = 'en';
    case Russian = 'ru';

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
