<?php

namespace App\Traits;

use Illuminate\Support\Facades\App;

trait HasTranslations
{
    /**
     * Get the translated value for a given attribute.
     *
     * @param string $attribute
     * @param string|null $locale
     * @return mixed
     */
    public function translate(string $attribute, ?string $locale = null)
    {
        $locale = $locale ?: App::getLocale();
        $defaultLocale = config('app.fallback_locale', 'id');

        // Jika locale yang diminta adalah default locale (ID), langsung kembalikan atribut asli
        if ($locale === $defaultLocale) {
            return $this->{$attribute};
        }

        // Ambil data translations
        $translations = $this->translations ?? [];
        if (is_string($translations)) {
            $translations = json_decode($translations, true) ?? [];
        }

        // Cek struktur translations. Biasanya kita akan simpan sebagai translations->{locale}->{attribute}
        if (isset($translations[$locale][$attribute]) && !empty($translations[$locale][$attribute])) {
            return $translations[$locale][$attribute];
        }

        // Jika tidak ada terjemahan yang spesifik, fallback ke bahasa original
        return $this->{$attribute};
    }
}
