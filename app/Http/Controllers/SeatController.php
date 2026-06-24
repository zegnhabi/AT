<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\Ticket;
use Illuminate\Http\Request;

class SeatController extends Controller
{
    public function select($id)
    {
        $trip = Trip::with('tickets', 'bus')->findOrFail($id);
        $bus = $trip->bus;
        $totalSeats = $bus->seat_count;
        $decks = $bus->decks;
        $seatsPerDeck = $bus->seatsPerDeck();

        $occupiedSeats = $trip->tickets->pluck('seat_number')->toArray();

        if (count($occupiedSeats) >= $totalSeats) {
            return redirect()->route('home')
                ->withErrors(['error' => __('messages.run_full')]);
        }

        $seatDecks = [];
        for ($d = 0; $d < $decks; $d++) {
            $offset = $d * $seatsPerDeck;
            $deckSeatCount = min($seatsPerDeck, $totalSeats - $offset);
            $cols = 4;
            $rows = (int) ceil($deckSeatCount / $cols);
            $seatRows = [];

            for ($r = 0; $r < $rows; $r++) {
                $row = [];
                for ($c = 0; $c < $cols; $c++) {
                    $seatNum = $offset + ($r * $cols) + $c + 1;
                    if ($seatNum <= $totalSeats) {
                        $row[] = str_pad($seatNum, 2, '0', STR_PAD_LEFT);
                    } else {
                        $row[] = null;
                    }
                }
                $seatRows[] = $row;
            }

            $seatDecks[$d + 1] = $seatRows;
        }

        return view('seats', compact('trip', 'seatDecks', 'occupiedSeats', 'totalSeats', 'decks'));
    }

    public function purchase(Request $request)
    {
        $request->validate([
            'trip_id' => 'required|exists:trips,id',
            'seats'   => 'required|array',
            'seats.*' => 'required|integer|min:1',
            'names'   => 'required|array',
            'names.*' => 'required|string|max:65',
        ]);

        $trip = Trip::with('tickets', 'bus')->findOrFail($request->trip_id);
        $maxSeats = $trip->bus->seat_count;

        $request->validate([
            'seats.*' => "max:{$maxSeats}",
        ]);

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
