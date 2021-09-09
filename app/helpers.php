<?php

if (!function_exists('__route')) {
    function __route(string $name, array $parameters = [], bool $absolute = true, ?string $locale = null)
    {
        $locale ??= app()->getLocale();

        if (! in_array($locale, config()->get('app.allowed_locales'), true)) {
            throw new InvalidArgumentException("Locale [{$locale}] in not allowed");
        }

        $baseName = Str::after($name, ':'); // "en:root" becomes "root"
        return route("$locale:$baseName", $parameters, $absolute);
    }
}
