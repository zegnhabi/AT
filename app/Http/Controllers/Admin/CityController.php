<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\Bus;
use App\Models\Trip;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $perPage = in_array($perPage, [5, 10, 25, 50, 'all']) ? $perPage : 10;

        $cities = Trip::select('departure_city')
            ->distinct()
            ->orderBy('departure_city')
            ->get()
            ->pluck('departure_city');

        if ($perPage === 'all') {
            $legacyCities = new \Illuminate\Pagination\LengthAwarePaginator(
                $cities,
                $cities->count(),
                $cities->count(),
                1,
                ['path' => $request->url(), 'query' => array_merge($request->query(), ['per_page' => 'all'])]
            );
        } else {
            $currentPage = $request->input('page', 1);
            $offset = ($currentPage - 1) * $perPage;
            $sliced = $cities->slice($offset, $perPage);
            $legacyCities = new \Illuminate\Pagination\LengthAwarePaginator(
                $sliced,
                $cities->count(),
                $perPage,
                $currentPage,
                ['path' => $request->url(), 'query' => $request->query()]
            );
        }

        return view('admin.cities.index', compact('legacyCities', 'perPage'));
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
