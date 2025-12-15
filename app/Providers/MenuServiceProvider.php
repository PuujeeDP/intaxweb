<?php

namespace App\Providers;

use App\Helpers\MenuHelper;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class MenuServiceProvider extends ServiceProvider
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
        // Register Blade directive for menu rendering
        Blade::directive('menu', function ($expression) {
            return "<?php echo \App\Helpers\MenuHelper::render($expression); ?>";
        });

        // Register Blade directive for menu data (JSON)
        Blade::directive('menuData', function ($expression) {
            return "<?php echo json_encode(\App\Helpers\MenuHelper::getData($expression)); ?>";
        });
    }
}
