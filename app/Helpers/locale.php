<?php

use Illuminate\Support\Facades\Route;

if (!function_exists('current_locale')) {
    /**
     * Get the current locale from the route or session.
     */
    function current_locale(): string
    {
        return request()->route('locale') ?? session('locale', 'mn');
    }
}

if (!function_exists('localized_route')) {
    /**
     * Generate a localized route URL.
     */
    function localized_route(string $name, array $parameters = [], ?string $locale = null): string
    {
        $locale = $locale ?? current_locale();

        // Add locale to parameters
        $parameters = array_merge(['locale' => $locale], $parameters);

        return route($name, $parameters);
    }
}

if (!function_exists('switch_locale_url')) {
    /**
     * Generate URL for switching to a different locale while keeping the same page.
     */
    function switch_locale_url(string $newLocale): string
    {
        $currentRoute = Route::currentRouteName();
        $currentParams = Route::current()->parameters();

        // Remove the old locale parameter
        unset($currentParams['locale']);

        // Add the new locale
        $currentParams = array_merge(['locale' => $newLocale], $currentParams);

        return route($currentRoute, $currentParams);
    }
}

if (!function_exists('available_locales')) {
    /**
     * Get enabled locales from settings.
     */
    function available_locales(): array
    {
        $allLocales = [
            'mn' => 'Монгол',
            'en' => 'English',
            'zh' => '中文',
        ];

        try {
            // Get enabled locales from settings
            $enabledLocalesStr = \App\Models\Setting::get('general_enabled_locales', 'en,mn,zh');
            $enabledLocales = array_filter(explode(',', $enabledLocalesStr));

            // Filter to only return enabled locales
            return array_filter($allLocales, function($key) use ($enabledLocales) {
                return in_array($key, $enabledLocales);
            }, ARRAY_FILTER_USE_KEY);
        } catch (\Exception $e) {
            // Return all locales if there's any error (e.g., during admin requests without locale)
            return $allLocales;
        }
    }
}

if (!function_exists('locale_name')) {
    /**
     * Get the display name of a locale.
     */
    function locale_name(string $locale): string
    {
        $locales = available_locales();
        return $locales[$locale] ?? $locale;
    }
}
