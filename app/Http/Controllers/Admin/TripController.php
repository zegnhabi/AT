<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Trip;
use App\Models\Ticket;
use App\Models\Bus;
use App\Models\Driver;
use Illuminate\Http\Request;

class TripController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 5);
        $perPage = in_array($perPage, [5, 10, 25, 50, 'all']) ? $perPage : 5;

        $query = Trip::with('bus.driver', 'tickets');

        if ($request->filled('city')) {
            $query->where(function ($q) use ($request) {
                $q->where('departure_city', $request->city)
                  ->orWhere('arrival_city', $request->city);
            });
        }

        if ($request->filled('date')) {
            $query->where('departure_date', $request->date);
        }

        $trips = $query->orderByDesc('departure_date')
            ->orderBy('departure_time');

        if ($perPage === 'all') {
            $trips = $trips->get();
            $trips = new \Illuminate\Pagination\LengthAwarePaginator(
                $trips,
                $trips->count(),
                max($trips->count(), 1),
                1,
                ['path' => $request->url(), 'query' => array_merge($request->query(), ['per_page' => 'all'])]
            );
        } else {
            $trips = $trips->paginate($perPage)->withQueryString();
        }

        $cities = Trip::select('departure_city')->distinct()->orderBy('departure_city')->pluck('departure_city');

        return view('admin.trips.index', compact('trips', 'cities', 'perPage'));
    }

    public function show(Trip $trip)
    {
        $trip->load('bus.driver', 'tickets');
        return view('admin.trips.show', compact('trip'));
    }

    public function destroy(Trip $trip)
    {
        $trip->tickets()->delete();
        $trip->delete();

        return redirect()->route('admin.trips.index')
            ->with('success', 'Viaje eliminado correctamente.');
    }
}
