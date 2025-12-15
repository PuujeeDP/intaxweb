<?php

namespace App\Models;

use App\Models\Traits\Translatable;
use Illuminate\Database\Eloquent\Model;

class ServiceSection extends Model
{
    use Translatable;

    protected $fillable = [
        'service_id',
        'title',
        'content',
        'type',
        'icon',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    protected $translatable = [
        'title',
        'content',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    // Accessor methods for translations
    public function getTitleAttribute($value)
    {
        if (in_array('title', $this->translatable ?? [])) {
            return $this->translate('title');
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
