<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->has('lang')) {
            $lang = $request->get('lang');
            if (in_array($lang, ['es', 'en', 'de', 'fr'])) {
                session(['locale' => $lang]);
            }
        }

        $locale = session('locale', 'es');
        app()->setLocale($locale);

        return $next($request);
    }
}
