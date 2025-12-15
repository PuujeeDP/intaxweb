<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // General Settings
            ['key' => 'general_site_name', 'value' => 'MagicCMS', 'type' => 'text', 'group' => 'general'],
            ['key' => 'general_site_description', 'value' => 'Multi-language Content Management System', 'type' => 'text', 'group' => 'general'],
            ['key' => 'general_primary_color', 'value' => '#dc2626', 'type' => 'text', 'group' => 'general'],

            // Contact Settings
            ['key' => 'contact_email', 'value' => 'info@magiccms.com', 'type' => 'text', 'group' => 'contact'],
            ['key' => 'contact_phone', 'value' => '+976 11 123456', 'type' => 'text', 'group' => 'contact'],
            ['key' => 'contact_address', 'value' => 'Ulaanbaatar, Mongolia', 'type' => 'text', 'group' => 'contact'],

            // Social Media Settings
            ['key' => 'social_facebook', 'value' => 'https://facebook.com/magiccms', 'type' => 'text', 'group' => 'social'],
            ['key' => 'social_twitter', 'value' => 'https://twitter.com/magiccms', 'type' => 'text', 'group' => 'social'],
            ['key' => 'social_instagram', 'value' => 'https://instagram.com/magiccms', 'type' => 'text', 'group' => 'social'],
            ['key' => 'social_linkedin', 'value' => 'https://linkedin.com/company/magiccms', 'type' => 'text', 'group' => 'social'],
            ['key' => 'social_youtube', 'value' => 'https://youtube.com/@magiccms', 'type' => 'text', 'group' => 'social'],

            // Footer Settings
            ['key' => 'footer_copyright', 'value' => '© 2025 MagicCMS. All rights reserved.', 'type' => 'text', 'group' => 'footer'],
            ['key' => 'footer_about_text', 'value' => 'MagicCMS is a powerful multi-language content management system built with Laravel.', 'type' => 'text', 'group' => 'footer'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
