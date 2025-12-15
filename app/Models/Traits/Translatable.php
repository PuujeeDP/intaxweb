<?php

namespace App\Models\Traits;

use App\Models\Translation;

trait Translatable
{
    public function translations()
    {
        return $this->morphMany(Translation::class, 'translatable');
    }

    public function getTranslatableFields()
    {
        return $this->translatable ?? [];
    }

    public function translate($field, $locale = null)
    {
        $locale = $locale ?? app()->getLocale();

        $translation = $this->translations()
            ->where('locale', $locale)
            ->where('field', $field)
            ->first();

        return $translation ? $translation->value : ($this->attributes[$field] ?? null);
    }

    public function setTranslation($field, $locale, $value)
    {
        return $this->translations()->updateOrCreate(
            [
                'locale' => $locale,
                'field' => $field,
            ],
            [
                'value' => $value,
            ]
        );
    }

    public function getTranslations($field)
    {
        return $this->translations()
            ->where('field', $field)
            ->get()
            ->pluck('value', 'locale')
            ->toArray();
    }

    public function getAllTranslations()
    {
        $translations = [];
        $locales = ['en', 'mn', 'zh'];

        foreach ($this->translatable ?? [] as $field) {
            foreach ($locales as $locale) {
                $translations[$locale][$field] = $this->translate($field, $locale);
            }
        }

        return $translations;
    }
}
