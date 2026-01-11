<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Widget extends Model
{
    protected $fillable = [
        'key',
        'name',
        'type',
        'content',
        'area',
        'order',
        'is_active',
    ];

    protected $casts = [
        'content' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Scope for active widgets
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for widgets in specific area
     */
    public function scopeInArea($query, string $area)
    {
        return $query->where('area', $area);
    }

    /**
     * Scope for ordered widgets
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    /**
     * Get widget by key
     */
    public static function byKey(string $key)
    {
        return static::where('key', $key)->first();
    }

    /**
     * Available widget types
     */
    public static function availableTypes(): array
    {
        return [
            'html' => 'HTML Content',
            'text' => 'Text Block',
            'cta' => 'Call to Action',
            'stats' => 'Statistics Counter',
            'contact' => 'Contact Info',
            'social' => 'Social Links',
            'youtube' => 'YouTube Video',
        ];
    }

    /**
     * Available widget areas
     */
    public static function availableAreas(): array
    {
        return [
            'sidebar' => 'Sidebar',
            'footer' => 'Footer',
            'header' => 'Header',
            'before_content' => 'Before Content',
            'after_content' => 'After Content',
            'custom' => 'Custom',
        ];
    }
}
