<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Trip;
use App\Models\Ticket;
use App\Models\Bus;
use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $today = now()->format('Y-m-d');

        $tripsToday = Trip::where('departure_date', $today)->count();
        $ticketsToday = Ticket::where('sale_date', $today)->count();
        $revenueToday = Ticket::where('sale_date', $today)
            ->join('trips', 'tickets.trip_id', '=', 'trips.id')
            ->sum('trips.price') ?: 0;

        $activeBuses = Bus::count();
        $totalDrivers = Driver::count();

        $occupancyTrips = Trip::where('departure_date', $today)
            ->withCount('tickets')
            ->get();
        $occupancyRate = $occupancyTrips->count() > 0
            ? $occupancyTrips->avg(fn ($t) => $t->tickets_count / max($t->bus->seat_count ?? 36, 1) * 100)
            : 0;

        $topRoutes = Trip::select('trips.departure_city', 'trips.arrival_city',
                DB::raw('count(distinct trips.id) as trip_count'),
                DB::raw('count(tickets.folio) as ticket_count'))
            ->leftJoin('tickets', 'trips.id', '=', 'tickets.trip_id')
            ->where('trips.departure_date', $today)
            ->groupBy('trips.departure_city', 'trips.arrival_city')
            ->orderByDesc('ticket_count')
            ->limit(5)
            ->get();

        $revenueWeek = collect();
        for ($i = 6; $i >= 0; $i--) {
            $day = now()->subDays($i)->format('Y-m-d');
            $rev = Ticket::where('tickets.sale_date', $day)
                ->join('trips', 'tickets.trip_id', '=', 'trips.id')
                ->sum('trips.price') ?: 0;
            $revenueWeek->push(['date' => now()->subDays($i)->format('d-m-Y'), 'revenue' => $rev]);
        }

        if (DB::getDriverName() === 'sqlite') {
            $ticketsByHour = Ticket::where('sale_date', $today)
                ->select(DB::raw("strftime('%H', created_at) as hour"), DB::raw('count(*) as total'))
                ->groupBy(DB::raw("strftime('%H', created_at)"))
                ->orderBy('hour')
                ->pluck('total', 'hour');
        } else {
            $ticketsByHour = Ticket::where('sale_date', $today)
                ->select(DB::raw("EXTRACT(HOUR FROM created_at)::int as hour"), DB::raw('count(*)::int as total'))
                ->groupBy(DB::raw("EXTRACT(HOUR FROM created_at)::int"))
                ->orderBy('hour')
                ->pluck('total', 'hour');
        }

        return view('admin.dashboard', compact(
            'tripsToday', 'ticketsToday', 'revenueToday',
            'activeBuses', 'totalDrivers', 'occupancyRate',
            'topRoutes', 'revenueWeek', 'ticketsByHour'
        ));
    }
}
