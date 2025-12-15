<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackActiveNavigationMenu
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Skip this middleware for admin routes (including login and logout)
        if ($request->is('admin') || $request->is('admin/*') || $request->is('logout')) {
            return $next($request);
        }

        // Check if menu parameter is passed (clicked from top menu)
        if ($request->has('menu')) {
            $request->session()->put('active_navigation_menu', $request->input('menu'));
        }

        // Auto-detect menu based on current URL if not in session
        if (! $request->session()->has('active_navigation_menu')) {
            $detectedMenu = $this->detectMenuFromUrl($request);
            $request->session()->put('active_navigation_menu', $detectedMenu);
        }

        return $next($request);
    }

    /**
     * Detect which navigation menu the current URL belongs to
     */
    private function detectMenuFromUrl(Request $request): string
    {
        $currentUrl = $request->url();
        $locale = current_locale();

        // Get all available menu slugs from topmenu
        $topMenuItems = \App\Helpers\MenuHelper::getData('topmenu', $locale);
        $menuSlugs = ['primary']; // default fallback

        if (! empty($topMenuItems)) {
            $menuSlugs = [];
            foreach ($topMenuItems as $topMenuItem) {
                $slug = $topMenuItem['navigation_menu_slug'] ?? 'primary';
                if (! in_array($slug, $menuSlugs)) {
                    $menuSlugs[] = $slug;
                }
            }
        }

        // If no menu slugs found, use defaults
        if (empty($menuSlugs)) {
            $menuSlugs = ['primary', 'course', 'audit', 'tax', 'software'];
        }

        // Special cases for single pages that belong to primary menu
        if ($request->is('*/service/*') || $request->is('*/post/*') || $request->is('*/page/*')) {
            return 'primary';
        }

        // Check each menu to find which one contains the current URL
        foreach ($menuSlugs as $slug) {
            $menuItems = \App\Helpers\MenuHelper::getData($slug, $locale);
            if (! empty($menuItems)) {
                foreach ($menuItems as $item) {
                    // Check main item URL
                    if ($currentUrl === $item['url'] || str_starts_with($currentUrl, rtrim($item['url'], '/').'/')) {
                        return $slug;
                    }
                    // Check children URLs
                    if (! empty($item['children'])) {
                        foreach ($item['children'] as $child) {
                            if ($currentUrl === $child['url'] || str_starts_with($currentUrl, rtrim($child['url'], '/').'/')) {
                                return $slug;
                            }
                        }
                    }
                }
            }
        }

        return 'primary'; // default fallback
    }
}
