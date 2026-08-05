<?php

namespace App\Http\Middleware;

use App\Enums\SiteModuleEnum;
use App\Models\SiteModule;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureSiteModuleIsActive
{
    /**
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string $module): Response
    {
        $key = SiteModuleEnum::tryFrom($module);

        if ($key === null || ! SiteModule::isActive($key)) {
            abort(404);
        }

        return $next($request);
    }
}
