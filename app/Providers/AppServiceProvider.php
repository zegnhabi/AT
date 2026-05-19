<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
    }

    public function boot(): void
    {
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        view()->composer('*', function ($view) {
            $locale = session('locale', 'es');
            app()->setLocale($locale);
            $view->with('locale', $locale);
        });

        try {
            $settings = Setting::allAsArray();
            View::share('brand', $settings);
        } catch (\Exception $e) {
            View::share('brand', [
                'company_name'       => 'Autobuses S.A. de C.V',
                'company_slogan'     => '',
                'primary_color'      => '#ffc107',
                'secondary_color'    => '#212529',
                'accent_color'       => '#0d6efd',
                'admin_primary_color' => '#2c3e50',
                'admin_accent_color'  => '#3498db',
                'logo'               => 'logo.jpg',
                'favicon'            => 'favicon.ico',
            ]);
        }
    }
}
