<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Models\Setting;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->groupBy('group');

        // Get logo and favicon media
        $logoId = Setting::get('general_logo');
        $faviconId = Setting::get('general_favicon');

        $logo = $logoId ? Media::find($logoId) : null;
        $favicon = $faviconId ? Media::find($faviconId) : null;

        return Inertia::render('Admin/Settings/Index', [
            'settings' => $settings,
            'logo' => $logo,
            'favicon' => $favicon,
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'general' => 'nullable|array',
            'general.site_name' => 'nullable|string|max:255',
            'general.site_description' => 'nullable|string',
            'general.logo' => 'nullable',
            'general.favicon' => 'nullable',
            'general.primary_color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'general.default_locale' => 'nullable|string|in:en,mn,zh',
            'general.enabled_locales' => 'nullable|string',
            'general.editor_type' => 'nullable|string|in:tiptap,tinymce',

            'contact' => 'nullable|array',
            'contact.email' => 'nullable|email',
            'contact.phone' => 'nullable|string',
            'contact.address' => 'nullable|string',

            'social' => 'nullable|array',
            'social.facebook' => 'nullable|url',
            'social.twitter' => 'nullable|url',
            'social.instagram' => 'nullable|url',
            'social.linkedin' => 'nullable|url',
            'social.youtube' => 'nullable|url',

            'footer' => 'nullable|array',
            'footer.copyright' => 'nullable|string',
            'footer.about_text' => 'nullable|string',
        ]);

        // Update or create settings
        foreach ($validated as $group => $settings) {
            if (!is_array($settings)) {
                continue;
            }

            foreach ($settings as $key => $value) {
                $fullKey = "{$group}_{$key}";
                $type = in_array($key, ['logo', 'favicon']) ? 'image' : 'text';

                // Convert empty strings to null
                if ($value === '' || $value === null) {
                    $value = null;
                }

                Setting::set($fullKey, $value, $type, $group);
            }
        }

        // Clear cache
        Setting::clearCache();

        return redirect()->back()->with('success', 'Settings updated successfully!');
    }
}
