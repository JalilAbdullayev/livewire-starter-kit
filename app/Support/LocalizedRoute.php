<?php

namespace App\Support;

use App\Enums\LocaleEnum;
use App\Enums\SiteModuleEnum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use InvalidArgumentException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use function in_array;
use function is_array;

class LocalizedRoute
{
    /**
     * @param  list<array{name: string, component: string, middleware?: list<string>}>  $routes
     */
    public static function register(array $routes): void
    {
        foreach ($routes as $route) {
            $paths = config('site-routes')[$route['name']] ?? null;

            if (! is_array($paths)) {
                throw new InvalidArgumentException("Missing localized paths for route [{$route['name']}].");
            }

            foreach ($paths as $localeValue => $uri) {
                $locale = LocaleEnum::from($localeValue);
                $normalizedUri = self::normalizeUri($uri);

                $registration = Route::livewire($normalizedUri, $route['component'])
                    ->name(self::routeName($route['name'], $locale));

                if (! empty($route['middleware'])) {
                    $registration->middleware($route['middleware']);
                }
            }
        }
    }

    public static function routeName(string $baseName, ?LocaleEnum $locale = null): string
    {
        $locale ??= LocaleEnum::current();

        if ($locale->isDefault()) {
            return $baseName;
        }

        return "{$locale->value}.{$baseName}";
    }

    /**
     * @param  array<string, mixed>  $parameters
     */
    public static function url(string $name, array $parameters = [], ?LocaleEnum $locale = null): string
    {
        if (! self::isSiteRoute($name)) {
            return route($name, $parameters);
        }

        $locale ??= LocaleEnum::current();

        return route(self::routeName($name, $locale), $parameters);
    }

    public static function isSiteRoute(string $name): bool
    {
        return array_key_exists($name, config('site-routes', []));
    }

    public static function localeFromRequest(Request $request): LocaleEnum
    {
        $segment = $request->segment(1);

        if (is_string($segment) && in_array($segment, LocaleEnum::prefixedValues(), true)) {
            return LocaleEnum::from($segment);
        }

        return LocaleEnum::default();
    }

    public static function baseRouteName(?string $routeName): string
    {
        if ($routeName === null) {
            return 'home';
        }

        foreach (LocaleEnum::prefixed() as $locale) {
            $prefix = "{$locale->value}.";

            if (str_starts_with($routeName, $prefix)) {
                return substr($routeName, strlen($prefix));
            }
        }

        return $routeName;
    }

    public static function switchLocaleUrl(LocaleEnum $targetLocale): string
    {
        $currentRoute = request()->route();

        if ($currentRoute !== null) {
            $baseName = self::baseRouteName($currentRoute->getName());

            if (self::isSiteRoute($baseName)) {
                return self::url(
                    $baseName,
                    $currentRoute->parameters(),
                    $targetLocale,
                );
            }
        }

        $referer = request()->header('Referer');

        if (is_string($referer) && $referer !== '') {
            $path = parse_url($referer, PHP_URL_PATH);

            if (is_string($path) && $path !== '') {
                $matchedRoute = self::matchSiteRouteFromPath($path);

                if ($matchedRoute !== null) {
                    return self::url(
                        $matchedRoute['name'],
                        $matchedRoute['parameters'],
                        $targetLocale,
                    );
                }
            }
        }

        return self::url('home', [], $targetLocale);
    }

    /**
     * @return array{name: string, parameters: array<string, mixed>}|null
     */
    public static function matchSiteRouteFromPath(string $path): ?array
    {
        try {
            $route = Route::getRoutes()->match(Request::create($path, 'GET'));
            $baseName = self::baseRouteName($route->getName());

            if (! self::isSiteRoute($baseName)) {
                return null;
            }

            return [
                'name' => $baseName,
                'parameters' => $route->parameters(),
            ];
        } catch (NotFoundHttpException|MethodNotAllowedHttpException) {
            return null;
        }
    }

    public static function routeIs(string $baseName, bool $wildcard = false): bool
    {
        return request()->routeIs(self::patterns($baseName, $wildcard));
    }

    /**
     * @return list<string>
     */
    public static function patterns(string $baseName, bool $wildcard = false): array
    {
        return array_map(
            fn (LocaleEnum $locale): string => self::routeName($baseName, $locale).($wildcard ? '*' : ''),
            LocaleEnum::cases(),
        );
    }

    public static function matchesModule(SiteModuleEnum $module): bool
    {
        $patterns = self::patterns($module->routeName());

        if (in_array($module, [SiteModuleEnum::Blog, SiteModuleEnum::Services], true)) {
            $showRoute = match ($module) {
                SiteModuleEnum::Blog => 'site.blog.show',
                SiteModuleEnum::Services => 'site.services.show',
            };

            $patterns = [...$patterns, ...self::patterns($showRoute)];
        }

        return request()->routeIs($patterns);
    }

    private static function normalizeUri(string $uri): string
    {
        if ($uri === '/') {
            return '/';
        }

        return trim($uri, '/');
    }
}
