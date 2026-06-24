<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Translation extends Model
{
    protected $fillable = ['locale', 'group', 'key', 'value'];

    public static function getForGroup(string $group = 'messages'): array
    {
        $translations = static::where('group', $group)
            ->orderBy('key')
            ->orderBy('locale')
            ->get();

        $grouped = [];
        foreach ($translations as $t) {
            $grouped[$t->key][$t->locale] = $t->value;
        }
        return $grouped;
    }

    public static function getLocales(): array
    {
        return static::distinct()->pluck('locale')->sort()->values()->toArray();
    }

    public static function getAllKeys(string $group = 'messages'): array
    {
        return static::where('group', $group)
            ->distinct()
            ->pluck('key')
            ->sort()
            ->values()
            ->toArray();
    }

    public static function syncFromFiles(): void
    {
        $locales = ['es', 'en', 'de', 'fr'];

        foreach ($locales as $locale) {
            $path = resource_path("lang/{$locale}/messages.php");
            if (!file_exists($path)) continue;

            $strings = require $path;
            foreach ($strings as $key => $value) {
                static::updateOrCreate(
                    ['locale' => $locale, 'group' => 'messages', 'key' => $key],
                    ['value' => $value]
                );
            }
        }
    }

    public static function getTranslationsForJs(string $locale): array
    {
        return static::where('locale', $locale)
            ->where('group', 'messages')
            ->pluck('value', 'key')
            ->toArray();
    }
}
