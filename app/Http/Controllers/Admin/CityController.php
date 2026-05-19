<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\Bus;
use App\Models\Trip;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index()
    {
        $legacyCities = Trip::select('departure_city')
            ->distinct()
            ->orderBy('departure_city')
            ->pluck('departure_city');

        return view('admin.cities.index', compact('legacyCities'));
    }

    public function trips($city)
    {
        $trips = Trip::where('departure_city', $city)
            ->orWhere('arrival_city', $city)
            ->with('bus.driver')
            ->withCount('tickets')
            ->orderByDesc('departure_date')
            ->orderBy('departure_time')
            ->paginate(15);

        return view('admin.cities.trips', compact('trips', 'city'));
    }
}
