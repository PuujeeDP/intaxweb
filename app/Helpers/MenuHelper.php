<?php

namespace App\Helpers;

use App\Models\Menu;

class MenuHelper
{
    /**
     * Get menu by location and render as HTML.
     */
    public static function render(string $location, ?string $locale = null, array $options = []): string
    {
        $locale = $locale ?? app()->getLocale();
        $menu = Menu::getByLocation($location);

        if (! $menu) {
            return '';
        }

        $tree = $menu->getTree();

        if (empty($tree)) {
            return '';
        }

        // Default options
        $defaults = [
            'ul_class' => 'menu',
            'li_class' => 'menu-item',
            'a_class' => 'menu-link',
            'submenu_class' => 'submenu',
            'show_icons' => true,
        ];

        $options = array_merge($defaults, $options);

        return static::renderTree($tree, $locale, $options);
    }

    /**
     * Render menu tree recursively.
     */
    protected static function renderTree(array $items, string $locale, array $options, int $depth = 0): string
    {
        if (empty($items)) {
            return '';
        }

        $ulClass = $depth === 0 ? $options['ul_class'] : $options['submenu_class'];
        $html = sprintf('<ul class="%s">', esc($ulClass));

        foreach ($items as $item) {
            $html .= static::renderItem($item, $locale, $options, $depth);
        }

        $html .= '</ul>';

        return $html;
    }

    /**
     * Render a single menu item.
     */
    protected static function renderItem(array $item, string $locale, array $options, int $depth): string
    {
        $hasChildren = ! empty($item['children']);

        // Build li class
        $liClass = $options['li_class'];
        if ($hasChildren) {
            $liClass .= ' has-submenu';
        }
        if ($item['css_class']) {
            $liClass .= ' '.esc($item['css_class']);
        }

        // Build link
        $title = esc($item['title']);
        $url = esc($item['url']);
        $target = $item['target'] === '_blank' ? ' target="_blank" rel="noopener noreferrer"' : '';
        $icon = $options['show_icons'] && $item['icon'] ? '<span class="menu-icon">'.esc($item['icon']).'</span> ' : '';

        $html = sprintf(
            '<li class="%s"><a href="%s" class="%s"%s>%s%s</a>',
            $liClass,
            $url,
            esc($options['a_class']),
            $target,
            $icon,
            $title
        );

        // Render children if any
        if ($hasChildren) {
            $html .= static::renderTree($item['children'], $locale, $options, $depth + 1);
        }

        $html .= '</li>';

        return $html;
    }

    /**
     * Get menu data as array (for JavaScript/Alpine.js).
     */
    public static function getData(string $location, ?string $locale = null): array
    {
        $locale = $locale ?? app()->getLocale();
        $menu = Menu::getByLocation($location);

        if (! $menu) {
            return [];
        }

        return $menu->getTree();
    }
}

/**
 * Helper function to escape HTML.
 */
if (! function_exists('esc')) {
    function esc(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }
}
