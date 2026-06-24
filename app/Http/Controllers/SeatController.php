<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\Ticket;
use Illuminate\Http\Request;

class SeatController extends Controller
{
    public function select($id)
    {
        $trip = Trip::with('tickets')->findOrFail($id);

        $occupiedSeats = $trip->tickets->pluck('seat_number')->toArray();

        if ($trip->tickets->count() >= 36) {
            return redirect()->route('home')
                ->withErrors(['error' => __('messages.run_full')]);
        }

        $seatRows = [
            ['as01', 'as02', 'as03', 'as04'],
            ['as05', 'as06', 'as07', 'as08'],
            ['as09', 'as10', 'as11', 'as12'],
            ['as13', 'as14', 'as15', 'as16'],
            ['as17', 'as18', 'as19', 'as20'],
            ['as21', 'as22', 'as23', 'as24'],
            ['as25', 'as26', 'as27', 'as28'],
            ['as29', 'as30', 'as31', 'as32'],
            ['as33', 'as34', 'as35', 'as36'],
        ];

        return view('seats', compact('trip', 'seatRows', 'occupiedSeats'));
    }

    public function purchase(Request $request)
    {
        $request->validate([
            'trip_id' => 'required|exists:trips,id',
            'seats'   => 'required|array',
            'seats.*' => 'integer|min:1|max:36',
            'names'   => 'required|array',
            'names.*' => 'required|string|max:65',
        ]);

        $trip = Trip::with('tickets')->findOrFail($request->trip_id);
        $alreadyOccupied = $trip->tickets->pluck('seat_number')->toArray();

        foreach ($request->seats as $seat) {
            if (in_array((int)$seat, $alreadyOccupied)) {
                return back()->withErrors([
                    'error' => __('messages.seat_taken', ['seat' => $seat]),
                ]);
            }
        }

        $today = now()->format('Y-m-d');

        foreach ($request->seats as $i => $seat) {
            Ticket::create([
                'trip_id'        => $trip->id,
                'seat_number'    => (int)$seat,
                'passenger_name' => $request->names[$i],
                'sale_date'      => $today,
            ]);
        }

        return redirect()->route('tickets.print', [
            'trip_id' => $trip->id,
            'seats'   => implode(',', $request->seats),
            'names'   => implode(',', $request->names),
        ]);
    }
}
