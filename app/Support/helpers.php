<?php

use App\Enums\LocaleEnum;
use App\Support\LocalizedRoute;

if (! function_exists('localized_route')) {
    /**
     * @param  array<string, mixed>|string|int  $parameters
     */
    function localized_route(string $name, array|string|int $parameters = [], ?LocaleEnum $locale = null): string
    {
        if (! is_array($parameters)) {
            $parameters = [$parameters];
        }

        return LocalizedRoute::url($name, $parameters, $locale);
    }
}
