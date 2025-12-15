<?php

namespace App\Models;

use App\Models\Traits\Translatable;
use Illuminate\Database\Eloquent\Model;

class CompanyHistory extends Model
{
    use Translatable;

    protected $fillable = [
        'year',
        'image_id',
        'is_active',
        'order',
    ];

    protected $casts = [
        'year' => 'integer',
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    protected $translatable = [
        'title',
        'description',
    ];

    public function image()
    {
        return $this->belongsTo(Media::class, 'image_id');
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

    // Scope for active records
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope for ordered records
    public function scopeOrdered($query)
    {
        return $query->orderBy('year', 'desc');
    }
}
