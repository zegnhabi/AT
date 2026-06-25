<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;

class CancellationController extends Controller
{
    public function index(Ticket $ticket)
    {
        $ticket->load('trip.bus');
        return view('admin.cancellations.index', compact('ticket'));
    }

    public function destroy(Request $request, Ticket $ticket)
    {
        $ticket->load('trip');

        $trip = $ticket->trip;

        $ticket->delete();

        return redirect()->route('admin.trips.show', $trip)
            ->with('success', __('messages.admin_cancel_success', ['folio' => $ticket->folio]));
    }
}
