<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class ValidationController extends Controller
{
    public function index()
    {
        return view('validation.index');
    }

    public function validate(Request $request)
    {
        $request->validate([
            'folio' => 'required|numeric|exists:tickets,folio',
        ]);

        $ticket = Ticket::with('trip.bus')->findOrFail($request->folio);

        $tripDate = $ticket->trip->departure_date instanceof \Carbon\Carbon
            ? $ticket->trip->departure_date->format('Y-m-d')
            : $ticket->trip->departure_date;

        $isExpired = $tripDate < now()->format('Y-m-d');

        return view('validation.result', compact('ticket', 'isExpired'));
    }
}
