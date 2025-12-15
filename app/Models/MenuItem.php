<?php

namespace App\Models;

use App\Models\Traits\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class MenuItem extends Model
{
    use Translatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'menu_id',
        'parent_id',
        'type',
        'linkable_id',
        'linkable_type',
        'url',
        'order',
        'target',
        'icon',
        'css_class',
        'navigation_menu_slug',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * Translatable fields.
     *
     * @var array<int, string>
     */
    protected $translatable = [
        'title',
    ];

    /**
     * Get the menu this item belongs to.
     */
    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class);
    }

    /**
     * Get the parent menu item.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(MenuItem::class, 'parent_id');
    }

    /**
     * Get child menu items.
     */
    public function children(): HasMany
    {
        return $this->hasMany(MenuItem::class, 'parent_id')
            ->where('is_active', true)
            ->orderBy('order');
    }

    /**
     * Get the linked model (Page, Post, Category, etc.).
     */
    public function linkable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get the URL for this menu item.
     */
    public function getUrl(?string $locale = null): string
    {
        $locale = $locale ?? app()->getLocale();

        // If custom URL is set, use it
        if ($this->url) {
            // Replace {locale} placeholder with actual locale
            return str_replace('{locale}', $locale, $this->url);
        }

        // Generate URL based on linked model
        if ($this->linkable) {
            return $this->getLinkableUrl($locale);
        }

        return '#';
    }

    /**
     * Get URL from linked model.
     */
    protected function getLinkableUrl(string $locale): string
    {
        $linkable = $this->linkable;

        if (! $linkable) {
            return '#';
        }

        return match ($this->linkable_type) {
            'App\Models\Page' => route('pages.show', ['locale' => $locale, 'slug' => $linkable->slug]),
            'App\Models\Post' => route('posts.show', ['locale' => $locale, 'slug' => $linkable->slug]),
            'App\Models\Category' => route('categories.show', ['locale' => $locale, 'slug' => $linkable->slug]),
            default => '#',
        };
    }

    /**
     * Get the title for this menu item in the specified locale.
     */
    public function getTitle(?string $locale = null): string
    {
        $locale = $locale ?? app()->getLocale();

        // Try to get translated title
        $title = $this->translate('title', $locale);

        // Fallback to linked model's title if no custom title
        if (! $title && $this->linkable) {
            $title = $this->linkable->translate('title', $locale) ?? $this->linkable->title ?? '';
        }

        return $title ?? 'Untitled';
    }

    /**
     * Convert menu item to tree structure with children.
     */
    public function toTree(?string $locale = null): array
    {
        $locale = $locale ?? app()->getLocale();

        return [
            'id' => $this->id,
            'title' => $this->getTitle($locale),
            'url' => $this->getUrl($locale),
            'target' => $this->target,
            'icon' => $this->icon,
            'css_class' => $this->css_class,
            'type' => $this->type,
            'navigation_menu_slug' => $this->navigation_menu_slug,
            'children' => $this->children->map(fn ($child) => $child->toTree($locale))->toArray(),
        ];
    }

    /**
     * Scope to get only root items.
     */
    public function scopeRootItems($query)
    {
        return $query->whereNull('parent_id');
    }

    /**
     * Scope to get only active items.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get depth level of this menu item.
     */
    public function getDepth(): int
    {
        $depth = 0;
        $parent = $this->parent;

        while ($parent) {
            $depth++;
            $parent = $parent->parent;
        }

        return $depth;
    }

    /**
     * Check if this item has children.
     */
    public function hasChildren(): bool
    {
        return $this->children()->exists();
    }
}
