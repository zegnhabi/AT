<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LocaleController extends Controller
{
    public function switch($lang)
    {
        if (in_array($lang, ['es', 'en', 'de', 'fr'])) {
            session(['locale' => $lang]);
        }

        return redirect()->back();
    }
}
