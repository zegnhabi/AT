<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\Ticket;
use Illuminate\Http\Request;

class SeatController extends Controller
{
    public function select($id)
    {
        $trip = Trip::with('tickets', 'bus', 'stops')->findOrFail($id);
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
            $seatsPerRow = 4;
            $numCols = (int) ceil($deckSeatCount / $seatsPerRow);

            $columns = [];
            for ($col = 0; $col < $numCols; $col++) {
                $colSeats = [];
                for ($seat = 0; $seat < $seatsPerRow; $seat++) {
                    $seatNum = $offset + ($col * $seatsPerRow) + $seat + 1;
                    $colSeats[] = $seatNum <= $totalSeats ? $seatNum : null;
                }
                $columns[] = $colSeats;
            }

            $seatDecks[$d + 1] = $columns;
        }

        return view('seats', compact('trip', 'seatDecks', 'occupiedSeats', 'totalSeats', 'decks'));
    }

    public function purchase(Request $request)
    {
        $request->validate([
            'trip_id' => 'required|exists:trips,id',
            'seats'   => 'required|array',
            'seats.*' => 'required|numeric|min:1',
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
