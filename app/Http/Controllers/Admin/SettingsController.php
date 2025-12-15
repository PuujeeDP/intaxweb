<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = [
            'app_name' => config('app.name'),
            'app_env' => config('app.env'),
            'app_debug' => config('app.debug'),
            'app_url' => config('app.url'),
            'db_connection' => config('database.default'),
            'cache_driver' => config('cache.default'),
            'queue_connection' => config('queue.default'),
            'mail_mailer' => config('mail.default'),
        ];

        $stats = [
            'users' => \App\Models\User::count(),
            'posts' => \App\Models\Post::count(),
            'pages' => \App\Models\Page::count(),
            'categories' => \App\Models\Category::count(),
            'media' => \App\Models\Media::count(),
            'database_size' => $this->getDatabaseSize(),
        ];

        return Inertia::render('Admin/Settings/Index', [
            'settings' => $settings,
            'stats' => $stats,
        ]);
    }

    public function clearCache()
    {
        try {
            Artisan::call('cache:clear');
            Artisan::call('config:clear');
            Artisan::call('route:clear');
            Artisan::call('view:clear');

            return back()->with('success', 'Cache cleared successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to clear cache: ' . $e->getMessage());
        }
    }

    public function optimizeApp()
    {
        try {
            Artisan::call('optimize');
            Artisan::call('config:cache');
            Artisan::call('route:cache');

            return back()->with('success', 'Application optimized successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to optimize: ' . $e->getMessage());
        }
    }

    private function getDatabaseSize()
    {
        try {
            if (config('database.default') === 'pgsql') {
                $result = DB::select("
                    SELECT pg_size_pretty(pg_database_size(current_database())) as size
                ");
                return $result[0]->size ?? 'N/A';
            }
            return 'N/A';
        } catch (\Exception $e) {
            return 'N/A';
        }
    }
}
