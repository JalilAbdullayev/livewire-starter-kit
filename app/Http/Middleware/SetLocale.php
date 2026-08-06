<?php

namespace App\Http\Middleware;

use App\Support\LocalizedRoute;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = LocalizedRoute::localeFromRequest($request);

        $request->session()->put('locale', $locale->value);
        app()->setLocale($locale->value);

        return $next($request);
    }
}
