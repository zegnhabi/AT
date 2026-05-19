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
            ->orderBy('departure_time')
            ->paginate(15);

        $cities = Trip::select('departure_city')->distinct()->orderBy('departure_city')->pluck('departure_city');

        return view('admin.trips.index', compact('trips', 'cities'));
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
