<?php

namespace App\Models;

use App\Models\Traits\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use Translatable, SoftDeletes;

    protected $fillable = [
        'slug',
        'icon',
        'featured_image_id',
        'is_active',
        'order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    protected $translatable = [
        'title',
        'description',
        'content',
    ];

    public function featuredImage()
    {
        return $this->belongsTo(Media::class, 'featured_image_id');
    }

    public function sections()
    {
        return $this->hasMany(ServiceSection::class)->orderBy('order', 'asc');
    }

    public function widgets()
    {
        return $this->belongsToMany(Widget::class, 'service_widgets')->withPivot('order')->orderBy('service_widgets.order');
    }

    // Accessor methods for translations
    public function getTitleAttribute($value)
    {
        if (in_array('title', $this->translatable ?? [])) {
            return $this->translate('title');
        }
        return $value;
    }

    public function getDescriptionAttribute($value)
    {
        if (in_array('description', $this->translatable ?? [])) {
            return $this->translate('description');
        }
        return $value;
    }

    public function getContentAttribute($value)
    {
        if (in_array('content', $this->translatable ?? [])) {
            return $this->translate('content');
        }
        return $value;
    }
}
