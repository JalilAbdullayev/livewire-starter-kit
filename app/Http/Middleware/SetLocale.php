<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use function in_array;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (in_array($request->segment(1), ['en', 'ru'], true)) {
            app()->setLocale($request->segment(1));
            session()->put('locale', $request->segment(1));
        } else {
            app()->setLocale('az');
            session()->put('locale', 'az');
        }

        return $next($request);
    }
}
