<?php

namespace App\Http\Middleware;

use App\Enums\LocaleEnum;
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
        $locale = $request->session()->get('locale', config('app.locale'));

        if (LocaleEnum::isSupported($locale)) {
            app()->setLocale($locale);
        }

        return $next($request);
    }
}
