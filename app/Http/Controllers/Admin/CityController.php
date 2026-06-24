<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Trip;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $perPage = in_array($perPage, [5, 10, 25, 50, 'all']) ? $perPage : 10;

        $allCities = Trip::select('departure_city')->distinct()->pluck('departure_city')
            ->merge(Trip::select('arrival_city')->distinct()->pluck('arrival_city'))
            ->unique()
            ->sort()
            ->values();

        if ($perPage === 'all') {
            $legacyCities = new \Illuminate\Pagination\LengthAwarePaginator(
                $allCities,
                $allCities->count(),
                $allCities->count(),
                1,
                ['path' => $request->url(), 'query' => array_merge($request->query(), ['per_page' => 'all'])]
            );
        } else {
            $currentPage = $request->input('page', 1);
            $offset = ($currentPage - 1) * $perPage;
            $sliced = $allCities->slice($offset, $perPage);
            $legacyCities = new \Illuminate\Pagination\LengthAwarePaginator(
                $sliced,
                $allCities->count(),
                $perPage,
                $currentPage,
                ['path' => $request->url(), 'query' => $request->query()]
            );
        }

        $allCityNames = $allCities->implode(', ');

        return view('admin.cities.index', compact('legacyCities', 'perPage', 'allCityNames'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:45',
        ]);

        $city = trim($request->name);

        $exists = Trip::where('departure_city', $city)
            ->orWhere('arrival_city', $city)
            ->exists();

        if ($exists) {
            return back()->with('error', "La ciudad \"{$city}\" ya existe.");
        }

        return redirect()->route('admin.trips.create', ['departure_city' => $city])
            ->with('info', "Ciudad \"{$city}\" registrada. Crea un viaje para que aparezca en el listado.");
    }

    public function trips($city)
    {
        $trips = Trip::where('departure_city', $city)
            ->orWhere('arrival_city', $city)
            ->with('bus.driver', 'stops')
            ->withCount('tickets')
            ->orderByDesc('departure_date')
            ->orderBy('departure_time')
            ->paginate(15);

        return view('admin.cities.trips', compact('trips', 'city'));
    }
}
