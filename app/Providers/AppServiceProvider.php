<?php

namespace App\Providers;

use App\Enums\LocaleEnum;
use App\Enums\RolesEnum;
use App\Models\User;
use App\Policies\RolePolicy;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;
use Livewire\Livewire;
use Livewire\Mechanisms\HandleRequests\RequireLivewireHeaders;
use Spatie\Permission\Models\Role;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureDefaults();
        $this->configureAuthorization();
        $this->configureLocalizedRouting();
    }

    protected function configureLocalizedRouting(): void
    {
        URL::resolveMissingNamedRoutesUsing(function (string $name, $parameters, bool $absolute): ?string {
            foreach (LocaleEnum::prefixedValues() as $locale) {
                $prefix = "{$locale}.";

                if (! str_starts_with($name, $prefix)) {
                    continue;
                }

                $baseName = substr($name, strlen($prefix));

                if (Route::has($baseName)) {
                    return route($baseName, $parameters, $absolute);
                }
            }

            return null;
        });

        Livewire::setUpdateRoute(function ($handle, $path) {
            $route = Route::post($path, $handle)
                ->middleware(['web', RequireLivewireHeaders::class]);

            // Force an absolute route name. Route::name() appends to any active
            // group prefix and would produce names like "en.default-livewire.update".
            $route->action['as'] = 'default-livewire.update';

            return $route;
        });
    }

    /**
     * Configure default behaviors for production-ready applications.
     */
    protected function configureDefaults(): void
    {
        Date::use(CarbonImmutable::class);

        DB::prohibitDestructiveCommands(
            app()->isProduction(),
        );

        Password::defaults(fn (): ?Password => app()->isProduction()
            ? Password::min(12)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised()
            : null,
        );
    }

    /**
     * Configure authorization defaults for the starter kit.
     */
    protected function configureAuthorization(): void
    {
        Gate::policy(Role::class, RolePolicy::class);

        Gate::before(function (?User $user, string $ability): ?bool {
            if (! $user instanceof User) {
                return null;
            }

            return $user->hasRole(RolesEnum::SuperAdmin) ? true : null;
        });
    }
}
