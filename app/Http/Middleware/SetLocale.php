<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetLocale
{
    public function handle(Request $request, Closure $next, string $locale)
    {
        if (! in_array($locale, config()->get('app.allowed_locales'), true)) {
            throw new \InvalidArgumentException("Locale [{$locale}] isn't allowed.");
        }

        app()->setLocale($locale);

        return $next($request);
    }
}
