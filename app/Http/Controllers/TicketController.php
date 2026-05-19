<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class TicketController extends Controller
{
    public function print(Request $request)
    {
        $request->validate([
            'trip_id' => 'required|exists:trips,id',
            'seats'   => 'required|string',
            'names'   => 'required|string',
        ]);

        $trip  = Trip::findOrFail($request->trip_id);
        $seats = explode(',', $request->seats);
        $names = explode(',', $request->names);
        $today = now()->format('Y-m-d');

        $tickets = [];

        foreach ($seats as $i => $seat) {
            $code = sprintf(
                'Ticket: %s. Origin: %s. Destination: %s. Passenger: %s. Date: %s. Seat: %s.',
                $trip->id,
                $trip->departure_city,
                $trip->arrival_city,
                $names[$i],
                $trip->departure_date,
                $seat
            );

            $qrCode = base64_encode(
                QrCode::format('svg')
                    ->errorCorrection('H')
                    ->size(120)
                    ->margin(1)
                    ->generate($code)
            );

            $tickets[] = [
                'trip'   => $trip,
                'seat'   => $seat,
                'name'   => $names[$i],
                'qrCode' => $qrCode,
            ];
        }

        return view('tickets', compact('tickets', 'today'));
    }
}
