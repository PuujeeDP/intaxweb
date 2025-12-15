<?php

namespace App\Models;

use App\Models\Traits\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PageSection extends Model
{
    use Translatable;

    protected $translatable = ['title', 'content'];

    protected $fillable = [
        'page_id',
        'type',
        'icon',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * Get the page that owns the section.
     */
    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }

    /**
     * Accessor for title (current locale).
     */
    public function getTitleAttribute(): ?string
    {
        return $this->translate('title', app()->getLocale());
    }

    /**
     * Accessor for content (current locale).
     */
    public function getContentAttribute(): ?string
    {
        return $this->translate('content', app()->getLocale());
    }
}
