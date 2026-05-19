<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class BrandingController extends Controller
{
    public function index()
    {
        $settings = Setting::allAsArray();
        return view('admin.branding.index', compact('settings'));
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
        ]);

        foreach ($validated as $key => $value) {
            Setting::set($key, $value);
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
            ->with('success', 'Configuración de marca guardada correctamente.');
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
}
