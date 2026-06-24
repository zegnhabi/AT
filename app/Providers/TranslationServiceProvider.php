<?php

namespace App\Providers;

use App\Models\Translation;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;
use Illuminate\Translation\Translator;

class TranslationServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->extend('translator', function ($translator) {
            return new class($translator) extends Translator {
                protected array $dbLoaded = [];

                public function get($key, array $replace = [], $locale = null, $fallback = true)
                {
                    $locale = $locale ?? $this->getLocale();

                    if (!in_array($locale, $this->dbLoaded)) {
                        $this->loadDbTranslations($locale);
                        $this->dbLoaded[] = $locale;
                    }

                    return parent::get($key, $replace, $locale, $fallback);
                }

                protected function loadDbTranslations(string $locale): void
                {
                    $translations = Cache::remember("translations.{$locale}", 3600, function () use ($locale) {
                        return Translation::where('locale', $locale)
                            ->where('group', 'messages')
                            ->pluck('value', 'key')
                            ->toArray();
                    });

                    foreach ($translations as $item => $value) {
                        Arr::set($this->loaded, "messages.messages.$locale.$item", $value);
                    }
                }
            };
        });
    }

    public function boot(): void
    {
    }
}
