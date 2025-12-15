<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Translatable;

class Category extends Model
{
    use Translatable;

    // Fields that can be translated
    public $translatable = ['name', 'description'];

    protected $fillable = [
        'name',
        'slug',
        'description',
        'parent_id',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Self-referencing relationship
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    // Accessors for translatable fields
    public function getNameAttribute($value)
    {
        if (in_array('name', $this->translatable ?? [])) {
            return $this->translate('name');
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
}
