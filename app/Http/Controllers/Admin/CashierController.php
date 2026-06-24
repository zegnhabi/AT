<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CashierController extends Controller
{
    public function corte(Request $request)
    {
        $date = $request->input('date', now()->format('Y-m-d'));

        $tickets = Ticket::where('sale_date', $date)
            ->with('trip')
            ->orderBy('created_at')
            ->get();

        $totalTickets = $tickets->count();
        $totalRevenue = $tickets->sum(function ($t) { return $t->trip->price; });

        $byRoute = $tickets->groupBy(function ($t) {
            return $t->trip->departure_city . ' → ' . $t->trip->arrival_city;
        })->map(function ($group) {
            return [
                'count'   => $group->count(),
                'revenue' => $group->sum(function ($t) { return $t->trip->price; }),
            ];
        });

        $revenueYesterday = Ticket::where('sale_date', now()->subDay()->format('Y-m-d'))
            ->join('trips', 'tickets.trip_id', '=', 'trips.id')
            ->sum('trips.price') ?: 0;

        $revenueWeek = Ticket::where('sale_date', '>=', now()->subDays(6)->format('Y-m-d'))
            ->join('trips', 'tickets.trip_id', '=', 'trips.id')
            ->sum('trips.price') ?: 0;

        return view('admin.cashier.corte', compact(
            'date', 'tickets', 'totalTickets', 'totalRevenue',
            'byRoute', 'revenueYesterday', 'revenueWeek'
        ));
    }

    public function arqueo(Request $request)
    {
        $startDate = $request->input('start', now()->startOfMonth()->format('Y-m-d'));
        $endDate   = $request->input('end', now()->format('Y-m-d'));
        $perPage   = $request->input('per_page', 30);
        $perPage   = in_array($perPage, [5, 10, 25, 50, 'all']) ? $perPage : 30;

        $query = Ticket::whereBetween('sale_date', [$startDate, $endDate])
            ->with('trip')
            ->orderBy('sale_date')
            ->orderBy('created_at');

        if ($perPage === 'all') {
            $tickets = $query->get();
            $tickets = new \Illuminate\Pagination\LengthAwarePaginator(
                $tickets, $tickets->count(), $tickets->count(), 1,
                ['path' => $request->url(), 'query' => array_merge($request->query(), ['per_page' => 'all'])]
            );
        } else {
            $tickets = $query->paginate($perPage)->withQueryString();
        }

        $summary = Ticket::whereBetween('sale_date', [$startDate, $endDate])
            ->join('trips', 'tickets.trip_id', '=', 'trips.id')
            ->select(
                DB::raw('COUNT(*) as total_tickets'),
                DB::raw('SUM(trips.price) as total_revenue'),
                DB::raw('COUNT(DISTINCT tickets.trip_id) as total_trips'),
                DB::raw('MIN(tickets.sale_date) as first_date'),
                DB::raw('MAX(tickets.sale_date) as last_date')
            )->first();

        return view('admin.cashier.arqueo', compact(
            'tickets', 'summary', 'startDate', 'endDate', 'perPage'
        ));
    }
}
