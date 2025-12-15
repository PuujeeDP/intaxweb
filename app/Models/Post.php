<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\Translatable;

class Post extends Model
{
    use SoftDeletes, Translatable;

    // Fields that can be translated
    public $translatable = ['title', 'excerpt', 'content', 'meta_title', 'meta_description'];

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'category_id',
        'author_id',
        'featured_image_id',
        'status',
        'published_at',
        'meta_tags',
        'meta_title',
        'meta_description',
        'views',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'meta_tags' => 'array',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function featuredImage()
    {
        return $this->belongsTo(Media::class, 'featured_image_id');
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                     ->where('published_at', '<=', now());
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    // Accessors for translatable fields
    public function getTitleAttribute($value)
    {
        if (in_array('title', $this->translatable ?? [])) {
            return $this->translate('title');
        }
        return $value;
    }

    public function getExcerptAttribute($value)
    {
        if (in_array('excerpt', $this->translatable ?? [])) {
            return $this->translate('excerpt');
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

    public function getMetaTitleAttribute($value)
    {
        if (in_array('meta_title', $this->translatable ?? [])) {
            return $this->translate('meta_title');
        }
        return $value;
    }

    public function getMetaDescriptionAttribute($value)
    {
        if (in_array('meta_description', $this->translatable ?? [])) {
            return $this->translate('meta_description');
        }
        return $value;
    }
}
