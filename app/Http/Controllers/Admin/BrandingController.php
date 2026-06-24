<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\Translation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class BrandingController extends Controller
{
    public function index()
    {
        $settings = Setting::allAsArray();

        try {
            $translations = Translation::getForGroup('messages');
            $transKeys = Translation::getAllKeys('messages');
            $transLocales = Translation::getLocales();
        } catch (\Exception $e) {
            $translations = [];
            $transKeys = [];
            $transLocales = ['es', 'en', 'de', 'fr'];
        }

        if (empty($transLocales)) {
            $transLocales = ['es', 'en', 'de', 'fr'];
        }

        $categories = [
            'Genéricos'  => ['title','title2','title3','title4','title5','home','search','continue','back','buy','contact','error','exception','select_language','select_origin','select_destination','company'],
            'Búsqueda'   => ['date','date_label','time','origin','destination','schedule','price','travel_time','arrival_time','select_trip','from','to'],
            'Asientos'   => ['select_seats','seats','seat','seat_occupied','seat_available','seat_selected','seat_taken','select_ticket_count'],
            'Boletos'    => ['buy_tickets','purchased','tickets','print','passenger_name','fare','name','terminal_origin','terminal_destination','departure_date','departure_time','issue_place','suggestion'],
            'Mensajes'   => ['no_trips'],
        ];

        $grouped = [];
        foreach ($categories as $cat => $keys) {
            $grouped[$cat] = array_filter($keys, fn($k) => in_array($k, $transKeys));
        }

        $uncategorized = array_diff($transKeys, ...array_values($categories));
        if (!empty($uncategorized)) {
            $grouped['Otros'] = array_values($uncategorized);
        }

        return view('admin.branding.index', compact('settings', 'translations', 'transKeys', 'transLocales', 'grouped'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'company_name'       => 'required|string|max:100',
            'company_slogan'     => 'nullable|string|max:200',
            'primary_color'      => 'required|regex:/^#[a-fA-F0-9]{6}$/',
            'secondary_color'    => 'required|regex:/^#[a-fA-F0-9]{6}$/',
            'accent_color'       => 'required|regex:/^#[a-fA-F0-9]{6}$/',
            'admin_primary_color' => 'required|regex:/^#[a-fA-F0-9]{6}$/',
            'admin_accent_color'  => 'required|regex:/^#[a-fA-F0-9]{6}$/',
            'enabled_languages'  => 'nullable|array',
            'enabled_languages.*' => 'in:es,en,de,fr',
            'default_language'   => 'required|in:es,en,de,fr',
        ]);

        foreach ($validated as $key => $value) {
            if ($key === 'enabled_languages') {
                Setting::set($key, json_encode($value ?? []));
            } else {
                Setting::set($key, $value);
            }
        }

        if ($request->hasFile('logo')) {
            $request->validate(['logo' => 'image|mimes:jpeg,png,gif,webp|max:2048']);
            $file = $request->file('logo');
            $filename = 'logo_custom.' . $file->extension();
            $file->move(public_path('images'), $filename);
            Setting::set('logo', $filename);
        }

        if ($request->hasFile('favicon')) {
            $request->validate(['favicon' => 'image|mimes:ico,png|max:512']);
            $file = $request->file('favicon');
            $filename = 'favicon_custom.' . $file->extension();
            $file->move(public_path('images'), $filename);
            Setting::set('favicon', $filename);
        }

        return redirect()->route('admin.branding')
            ->with('success', 'Personalización guardada correctamente.');
    }

    public function resetLogo()
    {
        Setting::set('logo', 'logo.jpg');
        return redirect()->route('admin.branding')
            ->with('success', 'Logo restaurado al valor por defecto.');
    }

    public function resetFavicon()
    {
        Setting::set('favicon', 'favicon.ico');
        return redirect()->route('admin.branding')
            ->with('success', 'Favicon restaurado al valor por defecto.');
    }

    public function translationStore(Request $request)
    {
        $request->validate([
            'key' => 'required|string|max:255|regex:/^[a-z][a-z0-9_.]*$/',
            'values' => 'required|array',
            'values.*' => 'required|string',
        ]);

        foreach ($request->values as $locale => $value) {
            Translation::updateOrCreate(
                ['locale' => $locale, 'group' => 'messages', 'key' => $request->key],
                ['value' => $value]
            );
        }

        foreach (array_keys($request->values) as $locale) {
            Cache::forget("translations.{$locale}");
        }

        return redirect()->route('admin.branding')
            ->with('success', "Cadena \"{$request->key}\" creada correctamente.");
    }

    public function translationUpdate(Request $request, string $key)
    {
        $request->validate([
            'values' => 'required|array',
            'values.*' => 'required|string',
        ]);

        foreach ($request->values as $locale => $value) {
            Translation::updateOrCreate(
                ['locale' => $locale, 'group' => 'messages', 'key' => $key],
                ['value' => $value]
            );
        }

        foreach (array_keys($request->values) as $locale) {
            Cache::forget("translations.{$locale}");
        }

        return redirect()->route('admin.branding')
            ->with('success', "Cadena \"{$key}\" actualizada correctamente.");
    }

    public function translationDestroy(string $key)
    {
        Translation::where('key', $key)
            ->where('group', 'messages')
            ->delete();

        foreach (['es', 'en', 'de', 'fr'] as $locale) {
            Cache::forget("translations.{$locale}");
        }

        return redirect()->route('admin.branding')
            ->with('success', "Cadena \"{$key}\" eliminada.");
    }

    public function translationImport()
    {
        Translation::syncFromFiles();

        foreach (['es', 'en', 'de', 'fr'] as $locale) {
            Cache::forget("translations.{$locale}");
        }

        return redirect()->route('admin.branding')
            ->with('success', 'Traducciones importadas desde archivos PHP correctamente.');
    }
}
