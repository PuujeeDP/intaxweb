<?php

namespace App\Providers;

use App\Models\Media;
use App\Models\Menu;
use App\Models\Setting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Share settings with all views
        View::composer('*', function ($view) {
            // Get site settings
            $siteName = Setting::get('general_site_name', 'MagicCMS');
            $siteDescription = Setting::get('general_site_description', '');
            $primaryColor = Setting::get('general_primary_color', '#dc2626');

            // Get logo and favicon
            $logoId = Setting::get('general_logo');
            $faviconId = Setting::get('general_favicon');

            $logo = $logoId ? Media::find($logoId) : null;
            $favicon = $faviconId ? Media::find($faviconId) : null;

            // Get contact info
            $contactEmail = Setting::get('contact_email', '');
            $contactPhone = Setting::get('contact_phone', '');
            $contactAddress = Setting::get('contact_address', '');

            // Get social media
            $socialFacebook = Setting::get('social_facebook', '');
            $socialTwitter = Setting::get('social_twitter', '');
            $socialInstagram = Setting::get('social_instagram', '');
            $socialLinkedin = Setting::get('social_linkedin', '');
            $socialYoutube = Setting::get('social_youtube', '');

            // Get footer settings
            $footerCopyright = Setting::get('footer_copyright', '');
            $footerAbout = Setting::get('footer_about_text', '');

            // Get footer menu
            $footerMenu = Menu::getByLocation('footer');

            $view->with([
                'siteName' => $siteName,
                'siteDescription' => $siteDescription,
                'primaryColor' => $primaryColor,
                'siteLogo' => $logo,
                'siteFavicon' => $favicon,
                'contactEmail' => $contactEmail,
                'contactPhone' => $contactPhone,
                'contactAddress' => $contactAddress,
                'socialFacebook' => $socialFacebook,
                'socialTwitter' => $socialTwitter,
                'socialInstagram' => $socialInstagram,
                'socialLinkedin' => $socialLinkedin,
                'socialYoutube' => $socialYoutube,
                'footerCopyright' => $footerCopyright,
                'footerAbout' => $footerAbout,
                'footerMenu' => $footerMenu,
            ]);
        });
    }
}
