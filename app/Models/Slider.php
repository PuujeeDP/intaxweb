<?php

namespace App\Models;

use App\Models\Traits\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Slider extends Model
{
    use HasFactory, Translatable;

    protected $translatable = ['title', 'subtitle', 'description'];

    protected $fillable = [
        'image_id',
        'button_text',
        'button_url',
        'button_target',
        'is_active',
        'order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * Get the image for the slider.
     */
    public function image(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'image_id');
    }

    /**
     * Accessor for title (current locale).
     */
    public function getTitleAttribute(): ?string
    {
        return $this->translate('title', app()->getLocale());
    }

    /**
     * Accessor for subtitle (current locale).
     */
    public function getSubtitleAttribute(): ?string
    {
        return $this->translate('subtitle', app()->getLocale());
    }

    /**
     * Accessor for description (current locale).
     */
    public function getDescriptionAttribute(): ?string
    {
        return $this->translate('description', app()->getLocale());
    }
}
