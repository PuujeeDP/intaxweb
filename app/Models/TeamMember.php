<?php

namespace App\Models;

use App\Models\Traits\Translatable;
use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    use Translatable;

    protected $fillable = [
        'slug',
        'email',
        'phone',
        'facebook',
        'twitter',
        'linkedin',
        'photo_id',
        'is_active',
        'order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    protected $translatable = [
        'name',
        'position',
        'bio',
    ];

    public function photo()
    {
        return $this->belongsTo(Media::class, 'photo_id');
    }

    // Accessor methods for translations
    public function getNameAttribute($value)
    {
        if (in_array('name', $this->translatable ?? [])) {
            return $this->translate('name');
        }
        return $value;
    }

    public function getPositionAttribute($value)
    {
        if (in_array('position', $this->translatable ?? [])) {
            return $this->translate('position');
        }
        return $value;
    }

    public function getBioAttribute($value)
    {
        if (in_array('bio', $this->translatable ?? [])) {
            return $this->translate('bio');
        }
        return $value;
    }
}
