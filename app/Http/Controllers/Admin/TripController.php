<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Trip;
use App\Models\Bus;
use App\Models\TripStop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class TripController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 5);
        $perPage = in_array($perPage, [5, 10, 25, 50, 'all']) ? $perPage : 5;

        $query = Trip::with('bus.driver', 'tickets', 'stops');

        if ($request->filled('city')) {
            $query->where(function ($q) use ($request) {
                $q->where('departure_city', $request->city)
                  ->orWhere('arrival_city', $request->city)
                  ->orWhereHas('stops', fn ($sq) => $sq->where('city', $request->city));
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

    public function create(Request $request)
    {
        $buses = Bus::with('driver')->orderBy('id')->get();
        $departureCity = $request->query('departure_city', '');
        return view('admin.trips.form', ['trip' => null, 'buses' => $buses, 'departureCity' => $departureCity]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'bus_id'             => 'required|exists:buses,id',
            'departure_terminal' => 'required|string|max:50',
            'departure_city'     => 'required|string|max:45',
            'departure_date'     => 'required|date|after_or_equal:today',
            'departure_time'     => 'required',
            'arrival_terminal'   => 'required|string|max:50',
            'arrival_city'       => 'required|string|max:45',
            'arrival_date'       => 'required|date|after_or_equal:departure_date',
            'arrival_time'       => 'required',
            'price'              => 'required|numeric|min:0',
            'stops'              => 'nullable|array',
            'stops.*.city'       => 'required_with:stops|string|max:45',
            'stops.*.terminal'   => 'required_with:stops|string|max:50',
            'stops.*.arrival_time'   => 'nullable',
            'stops.*.departure_time' => 'nullable',
        ]);

        $trip = Trip::create($validated);

        if (!empty($validated['stops'])) {
            foreach ($validated['stops'] as $i => $stop) {
                $trip->stops()->create([
                    'city'           => $stop['city'],
                    'terminal'       => $stop['terminal'],
                    'stop_order'     => $i + 1,
                    'arrival_time'   => $stop['arrival_time'] ?? null,
                    'departure_time' => $stop['departure_time'] ?? null,
                ]);
            }
        }

        return redirect()->route('admin.trips.show', $trip)
            ->with('success', 'Viaje creado correctamente.');
    }

    public function show(Trip $trip)
    {
        $trip->load('bus.driver', 'tickets', 'stops');
        return view('admin.trips.show', compact('trip'));
    }

    public function edit(Trip $trip)
    {
        $trip->load('stops');
        $buses = Bus::with('driver')->orderBy('id')->get();
        return view('admin.trips.form', compact('trip', 'buses'));
    }

    public function update(Request $request, Trip $trip)
    {
        $validated = $request->validate([
            'bus_id'             => 'required|exists:buses,id',
            'departure_terminal' => 'required|string|max:50',
            'departure_city'     => 'required|string|max:45',
            'departure_date'     => 'required|date',
            'departure_time'     => 'required',
            'arrival_terminal'   => 'required|string|max:50',
            'arrival_city'       => 'required|string|max:45',
            'arrival_date'       => 'required|date|after_or_equal:departure_date',
            'arrival_time'       => 'required',
            'price'              => 'required|numeric|min:0',
            'stops'              => 'nullable|array',
            'stops.*.city'       => 'required_with:stops|string|max:45',
            'stops.*.terminal'   => 'required_with:stops|string|max:50',
            'stops.*.arrival_time'   => 'nullable',
            'stops.*.departure_time' => 'nullable',
        ]);

        $trip->update($validated);

        $trip->stops()->delete();
        if (!empty($validated['stops'])) {
            foreach ($validated['stops'] as $i => $stop) {
                $trip->stops()->create([
                    'city'           => $stop['city'],
                    'terminal'       => $stop['terminal'],
                    'stop_order'     => $i + 1,
                    'arrival_time'   => $stop['arrival_time'] ?? null,
                    'departure_time' => $stop['departure_time'] ?? null,
                ]);
            }
        }

        return redirect()->route('admin.trips.show', $trip)
            ->with('success', 'Viaje actualizado correctamente.');
    }

    public function pasajeros(Trip $trip)
    {
        $trip->load('tickets');

        $csv = "\xEF\xBB\xBF";
        $csv .= __('messages.admin_folio') . ',' . __('messages.admin_passenger') . ',' . __('messages.admin_seat') . ',' . __('messages.admin_sale_date') . ',' . __('messages.admin_email') . "\n";

        foreach ($trip->tickets as $ticket) {
            $csv .= implode(',', [
                $ticket->folio,
                '"' . str_replace('"', '""', $ticket->passenger_name) . '"',
                $ticket->seat_number,
                $ticket->sale_date->format('Y-m-d'),
                $ticket->email ?? '',
            ]) . "\n";
        }

        $filename = 'pasajeros_viaje_' . $trip->id . '_' . now()->format('Ymd') . '.csv';

        return Response::make($csv, 200, [
            'Content-Type'        => 'text/csv; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    public function destroy(Trip $trip)
    {
        $trip->tickets()->delete();
        $trip->stops()->delete();
        $trip->delete();

        return redirect()->route('admin.trips.index')
            ->with('success', 'Viaje eliminado correctamente.');
    }
}
