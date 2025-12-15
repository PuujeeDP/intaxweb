<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Available locales for the application.
     */
    protected array $availableLocales = ['mn', 'en', 'zh'];

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get enabled locales from settings (fallback to all locales)
        $enabledLocalesStr = Setting::get('general_enabled_locales', 'en,mn,zh');
        $enabledLocales = array_filter(explode(',', $enabledLocalesStr));

        // Get default locale from settings (fallback to 'mn')
        $defaultLocale = Setting::get('general_default_locale', 'mn');

        // Ensure default locale is in enabled locales
        if (!in_array($defaultLocale, $enabledLocales)) {
            $defaultLocale = !empty($enabledLocales) ? $enabledLocales[0] : 'mn';
        }

        // Get locale from route parameter
        $locale = $request->route('locale');

        // If locale is not in route, not valid, or not enabled, use default
        if (!$locale || !in_array($locale, $this->availableLocales) || !in_array($locale, $enabledLocales)) {
            $locale = $defaultLocale;
        }

        // Set application locale
        App::setLocale($locale);

        // Store locale in session for consistency
        Session::put('locale', $locale);

        // Share enabled locales with views
        view()->share('enabledLocales', $enabledLocales);

        return $next($request);
    }
}
