<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $cities = Trip::select('departure_city')
            ->distinct()
            ->orderBy('departure_city')
            ->pluck('departure_city');

        return view('home', compact('cities'));
    }

    public function search(Request $request)
    {
        $request->validate([
            'origin'      => 'required|string',
            'destination' => 'required|string',
            'date'        => 'required|date_format:Y-m-d|after_or_equal:today',
        ]);

        $origin       = $request->input('origin');
        $destination  = $request->input('destination');
        $formattedDate = $request->input('date');
        $today = now()->format('Y-m-d');

        $query = Trip::with('stops')
            ->where(function ($q) use ($origin, $destination) {
                $q->where(function ($q2) use ($origin, $destination) {
                    $q2->where('departure_city', $origin)
                       ->where('arrival_city', $destination);
                })->orWhere(function ($q2) use ($origin, $destination) {
                    $q2->where('departure_city', $origin)
                       ->whereHas('stops', fn ($sq) => $sq->where('city', $destination));
                })->orWhere(function ($q2) use ($origin, $destination) {
                    $q2->where('arrival_city', $destination)
                       ->whereHas('stops', fn ($sq) => $sq->where('city', $origin));
                })->orWhere(function ($q2) use ($origin, $destination) {
                    $q2->whereHas('stops', fn ($sq) => $sq->where('city', $origin))
                       ->whereHas('stops', fn ($sq) => $sq->where('city', $destination));
                });
            })
            ->where('departure_date', $formattedDate);

        if ($formattedDate === $today) {
            $query->where('departure_time', '>=', now()->format('H:i:s'));
        }

        $trips = $query->orderBy('departure_time')->get();

        return view('search', compact('trips', 'origin', 'destination', 'formattedDate'));
    }
}
