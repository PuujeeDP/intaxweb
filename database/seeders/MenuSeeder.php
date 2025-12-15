<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Primary Menu
        $primaryMenu = Menu::create([
            'name' => 'Primary Menu',
            'location' => 'primary',
            'description' => 'Main navigation menu in header',
            'is_active' => true,
        ]);

        // Create menu items for primary menu
        $menuItems = [
            [
                'type' => 'custom',
                'url' => '/{locale}/',
                'title' => [
                    'en' => 'Home',
                    'mn' => 'Нүүр',
                    'zh' => '首页',
                ],
                'icon' => '🏠',
                'order' => 0,
            ],
            [
                'type' => 'custom',
                'url' => '/{locale}/about',
                'title' => [
                    'en' => 'About',
                    'mn' => 'Бидний тухай',
                    'zh' => '关于我们',
                ],
                'order' => 1,
            ],
            [
                'type' => 'custom',
                'url' => '/{locale}/services',
                'title' => [
                    'en' => 'Services',
                    'mn' => 'Үйлчилгээ',
                    'zh' => '服务',
                ],
                'order' => 2,
            ],
            [
                'type' => 'custom',
                'url' => '/{locale}/posts',
                'title' => [
                    'en' => 'Blog',
                    'mn' => 'Блог',
                    'zh' => '博客',
                ],
                'order' => 3,
            ],
            [
                'type' => 'custom',
                'url' => '/{locale}/contact',
                'title' => [
                    'en' => 'Contact',
                    'mn' => 'Холбоо барих',
                    'zh' => '联系我们',
                ],
                'order' => 4,
            ],
        ];

        foreach ($menuItems as $itemData) {
            $menuItem = MenuItem::create([
                'menu_id' => $primaryMenu->id,
                'type' => $itemData['type'],
                'url' => $itemData['url'],
                'order' => $itemData['order'],
                'target' => '_self',
                'icon' => $itemData['icon'] ?? null,
                'is_active' => true,
            ]);

            // Save translations
            foreach ($itemData['title'] as $locale => $title) {
                $menuItem->setTranslation('title', $locale, $title);
            }
        }

        // Create Footer Menu
        $footerMenu = Menu::create([
            'name' => 'Footer Menu',
            'location' => 'footer',
            'description' => 'Quick links in footer',
            'is_active' => true,
        ]);

        $footerItems = [
            [
                'type' => 'custom',
                'url' => '/{locale}/',
                'title' => [
                    'en' => 'Home',
                    'mn' => 'Нүүр',
                    'zh' => '首页',
                ],
                'order' => 0,
            ],
            [
                'type' => 'custom',
                'url' => '/{locale}/posts',
                'title' => [
                    'en' => 'News & Articles',
                    'mn' => 'Мэдээ ба нийтлэл',
                    'zh' => '新闻与文章',
                ],
                'order' => 1,
            ],
            [
                'type' => 'custom',
                'url' => '/admin/dashboard',
                'title' => [
                    'en' => 'Admin Dashboard',
                    'mn' => 'Админ хяналт',
                    'zh' => '管理面板',
                ],
                'order' => 2,
            ],
        ];

        foreach ($footerItems as $itemData) {
            $menuItem = MenuItem::create([
                'menu_id' => $footerMenu->id,
                'type' => $itemData['type'],
                'url' => $itemData['url'],
                'order' => $itemData['order'],
                'target' => '_self',
                'is_active' => true,
            ]);

            foreach ($itemData['title'] as $locale => $title) {
                $menuItem->setTranslation('title', $locale, $title);
            }
        }

        $this->command->info('Menus created successfully!');
    }
}
