<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\Ticket;
use App\Mail\TicketMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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
            'email'   => 'required|email|max:120',
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
                ])->with('purchase_failed', [
                    'reason'  => 'seat_taken',
                    'seat'    => (int)$seat,
                    'trip_id' => $trip->id,
                ]);
            }
        }

        $today = now()->format('Y-m-d');

        $email = $request->input('email');

        $tickets = [];
        foreach ($request->seats as $i => $seat) {
            $tickets[] = Ticket::create([
                'trip_id'        => $trip->id,
                'seat_number'    => (int)$seat,
                'passenger_name' => $request->names[$i],
                'email'          => $email,
                'sale_date'      => $today,
            ]);
        }

        $totalAmount = count($request->seats) * $trip->price;

        try {
            Mail::to($email)->send(new TicketMail($trip, $tickets, $request->names));
        } catch (\Exception $e) {
            logger()->error('Failed to send ticket email: ' . $e->getMessage());
        }

        return redirect()->route('tickets.print', [
            'trip_id' => $trip->id,
            'seats'   => implode(',', $request->seats),
            'names'   => implode(',', $request->names),
        ])->with('purchase_completed', [
            'trip_id'      => $trip->id,
            'origin'       => $trip->departure_city,
            'destination'  => $trip->arrival_city,
            'ticket_count' => count($request->seats),
            'total_amount' => $totalAmount,
            'folio'        => $tickets[0]->folio ?? null,
            'email_sent'   => true,
        ]);
    }
}
