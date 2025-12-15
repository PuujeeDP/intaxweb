<?php

use App\Models\Widget;
use Illuminate\Support\Facades\Cache;

if (!function_exists('render_widget')) {
    /**
     * Render a widget by key
     */
    function render_widget(string $key): string
    {
        $widget = Cache::remember("widget_{$key}", 3600, function () use ($key) {
            return Widget::where('key', $key)->where('is_active', true)->first();
        });

        if (!$widget) {
            return '';
        }

        return view('frontend.widgets.' . $widget->type, ['widget' => $widget])->render();
    }
}

if (!function_exists('get_widgets')) {
    /**
     * Get widgets by area
     */
    function get_widgets(string $area)
    {
        return Cache::remember("widgets_area_{$area}", 3600, function () use ($area) {
            return Widget::where('area', $area)
                ->where('is_active', true)
                ->ordered()
                ->get();
        });
    }
}

if (!function_exists('render_widgets_area')) {
    /**
     * Render all widgets in an area
     */
    function render_widgets_area(string $area): string
    {
        $widgets = get_widgets($area);

        if ($widgets->isEmpty()) {
            return '';
        }

        $html = '';
        foreach ($widgets as $widget) {
            $html .= view('frontend.widgets.' . $widget->type, ['widget' => $widget])->render();
        }

        return $html;
    }
}
