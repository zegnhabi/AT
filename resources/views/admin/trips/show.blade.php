@extends('admin.layouts.app')

@section('title', __('messages.admin_trip_show_title', ['id' => $trip->id]))
@section('content')
<div class="d-flex justify-content-between align-items-center page-title flex-wrap gap-2">
    <div><i class="bi bi-ticket-perforated-fill"></i> {{ __('messages.admin_trip_show_title', ['id' => $trip->id]) }}</div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.trips.edit', $trip) }}" class="btn btn-admin-primary btn-sm">
            <i class="bi bi-pencil"></i> {{ __('messages.admin_edit') }}
        </a>
        <a href="{{ route('admin.trips.index') }}" class="btn btn-admin-outline btn-sm">
            <i class="bi bi-arrow-left"></i> {{ __('messages.admin_back') }}
        </a>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-6">
        <div class="card card-admin h-100">
            <div class="card-header bg-white">
                <i class="bi bi-info-circle text-primary me-1"></i> {{ __('messages.admin_trip_show_detail_header') }}
            </div>
            <div class="card-body">
                <table class="table table-admin">
                    <tr>
                        <td class="text-muted" style="width:40%;">{{ __('messages.admin_route') }}</td>
                        <td class="fw-semibold">
                            <span class="badge bg-primary bg-opacity-10 text-primary badge-status">{{ $trip->departure_city }}</span>
                            <i class="bi bi-arrow-right mx-1"></i>
                            <span class="badge bg-success bg-opacity-10 text-success badge-status">{{ $trip->arrival_city }}</span>
                        </td>
                    </tr>
                    <tr><td class="text-muted">{{ __('messages.admin_departure_date') }}</td><td><i class="bi bi-calendar3 me-1 text-muted"></i>{{ $trip->departure_date->format('d-m-Y') }}</td></tr>
                    <tr><td class="text-muted">{{ __('messages.admin_departure_time') }}</td><td><i class="bi bi-clock me-1 text-muted"></i>{{ substr($trip->departure_time, 0, 5) }}</td></tr>
                    <tr><td class="text-muted">{{ __('messages.admin_departure_terminal') }}</td><td><i class="bi bi-geo me-1 text-muted"></i>{{ $trip->departure_terminal }}</td></tr>
                    <tr><td class="text-muted">{{ __('messages.admin_arrival_terminal') }}</td><td><i class="bi bi-geo-alt me-1 text-muted"></i>{{ $trip->arrival_terminal }}</td></tr>
                    <tr>
                        <td class="text-muted">{{ __('messages.admin_price') }}</td>
                        <td class="fw-bold" style="color:var(--admin-success);">${{ number_format($trip->price, 2) }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">{{ __('messages.admin_bus') }}</td>
                        <td>
                            <span class="badge bg-secondary bg-opacity-10 text-secondary badge-status">#{{ $trip->bus_id }}</span>
                            <small class="text-muted ms-1">{{ $trip->bus->driver->name ?? __('messages.admin_no_driver') }}</small>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted">{{ __('messages.admin_tickets_sold') }}</td>
                        <td>
                            @php $pct = $trip->bus->seat_count ? round($trip->tickets->count() / $trip->bus->seat_count * 100) : 0; @endphp
                            <div class="d-flex align-items-center gap-2">
                                <div style="width:100px;height:8px;background:#e9ecef;border-radius:4px;overflow:hidden;">
                                    <div style="width:{{ $pct }}%;height:100%;background:{{ $pct > 80 ? 'var(--admin-danger)' : ($pct > 50 ? 'var(--admin-warning)' : 'var(--admin-success)') }};border-radius:4px;"></div>
                                </div>
                                <span class="fw-semibold">{{ $trip->tickets->count() }}/{{ $trip->bus->seat_count ?? 36 }}</span>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    @if($trip->stops->isNotEmpty())
    <div class="col-12">
        <div class="card card-admin">
            <div class="card-header bg-white">
                <i class="bi bi-signpost-split text-primary me-1"></i> {{ __('messages.admin_stops') }}
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-admin mb-0">
                        <thead>
                            <tr><th>#</th><th>{{ __('messages.admin_city') }}</th><th>{{ __('messages.admin_terminal') }}</th><th>{{ __('messages.admin_arrival_time') }}</th><th>{{ __('messages.admin_departure_time') }}</th></tr>
                        </thead>
                        <tbody>
                            @foreach($trip->stops as $stop)
                            <tr>
                                <td class="text-muted">{{ $stop->stop_order }}</td>
                                <td><span class="badge bg-info bg-opacity-10 text-info badge-status">{{ $stop->city }}</span></td>
                                <td>{{ $stop->terminal }}</td>
                                <td>{{ $stop->arrival_time ? substr($stop->arrival_time, 0, 5) : '—' }}</td>
                                <td>{{ $stop->departure_time ? substr($stop->departure_time, 0, 5) : '—' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="col-md-6">
        <div class="card card-admin h-100">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-people text-primary me-1"></i> {{ __('messages.admin_passengers') }}</span>
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-primary badge-status">{{ $trip->tickets->count() }} {{ __('messages.admin_tickets_count') }}</span>
                        @if(!$trip->tickets->isEmpty())
                        <a href="{{ route('admin.trips.pasajeros', $trip) }}" class="btn btn-sm btn-admin-outline" title="{{ __('messages.admin_export_csv') }}">
                            <i class="bi bi-download"></i> CSV
                        </a>
                        <button onclick="window.print()" class="btn btn-sm btn-admin-outline" title="{{ __('messages.admin_trip_show_print_title_attr') }}">
                            <i class="bi bi-printer"></i> {{ __('messages.admin_print') }}
                        </button>
                        @endif
                    </div>
                </div>
            <div class="card-body p-0">
                @if($trip->tickets->isEmpty())
                    <div class="text-center text-muted py-5">
                        <i class="bi bi-inbox" style="font-size:2rem;"></i>
                        <div class="mt-2">{{ __('messages.admin_trip_show_no_tickets') }}</div>
                    </div>
                @else
                    <div class="table-responsive" style="max-height:400px;">
                        <table class="table table-admin">
                            <thead>
                                <tr><th>{{ __('messages.admin_folio') }}</th><th>{{ __('messages.admin_seat') }}</th><th>{{ __('messages.admin_passenger') }}</th><th>{{ __('messages.admin_sale_date') }}</th><th style="width:40px;"></th></tr>
                            </thead>
                            <tbody>
                                @foreach($trip->tickets as $tk)
                                <tr>
                                    <td class="text-muted">{{ $tk->folio }}</td>
                                    <td><span class="badge bg-info bg-opacity-10 text-info badge-status">{{ $tk->seat_number }}</span></td>
                                    <td><i class="bi bi-person me-1 text-muted"></i>{{ $tk->passenger_name }}</td>
                                    <td>{{ $tk->sale_date->format('d-m-Y') }}</td>
                                    <td>
                                        <a href="{{ route('admin.cancellations.index', $tk) }}"
                                           class="btn btn-sm btn-admin-outline text-danger"
                                           title="{{ __('messages.admin_cancel_ticket') }}">
                                            <i class="bi bi-x-circle"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
#print-area { display: none; }
@media print {
    body * { visibility: hidden !important; }
    body::before { content: none !important; }
    #print-area, #print-area * { visibility: visible !important; }
    #print-area { display: block !important; position: absolute; left: 0; top: 0; width: 100%; padding: 20px; background: #fff !important; }
    .print-header { text-align: center; margin-bottom: 15px; border-bottom: 2px solid #000; padding-bottom: 10px; }
    .print-header h2 { font-size: 1.2rem; margin: 0; }
    .print-header p { font-size: .85rem; margin: 2px 0 0; color: #333; }
    .print-table { width: 100%; border-collapse: collapse; font-size: .8rem; }
    .print-table th { background: #eee !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
    .print-table th, .print-table td { border: 1px solid #333; padding: 4px 8px; text-align: left; }
    .print-footer { margin-top: 15px; font-size: .75rem; text-align: right; color: #666; }
}
</style>

<div id="print-area">
    <div class="print-header">
        <h2>{{ __('messages.admin_trip_show_print_title') }}</h2>
        <p>
            Viaje #{{ $trip->id }} ·
            {{ $trip->departure_city }} → {{ $trip->arrival_city }} ·
            {{ $trip->departure_date->format('d-m-Y') }} {{ substr($trip->departure_time, 0, 5) }}
        </p>
        <p>{{ __('messages.admin_bus') }} #{{ $trip->bus_id }} · {{ __('messages.admin_driver') }}: {{ $trip->bus->driver->name ?? '—' }}</p>
    </div>
    @if(!$trip->tickets->isEmpty())
    <table class="print-table">
        <thead>
            <tr><th>#</th><th>{{ __('messages.admin_folio') }}</th><th>{{ __('messages.admin_seat') }}</th><th>{{ __('messages.admin_passenger') }}</th><th>{{ __('messages.admin_sale_date') }}</th></tr>
        </thead>
        <tbody>
            @foreach($trip->tickets as $idx => $tk)
            <tr>
                <td>{{ $idx + 1 }}</td>
                <td>{{ $tk->folio }}</td>
                <td>{{ $tk->seat_number }}</td>
                <td>{{ $tk->passenger_name }}</td>
                <td>{{ $tk->sale_date->format('d-m-Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="print-footer">
        {{ __('messages.admin_trip_show_printed') }} {{ now()->format('d-m-Y H:i') }} · {{ __('messages.admin_trip_show_total') }} {{ $trip->tickets->count() }} {{ __('messages.admin_trip_show_passenger_count') }}
    </div>
    @else
    <p style="text-align:center;color:#999;">{{ __('messages.admin_trip_show_no_passengers') }}</p>
    @endif
</div>
@endsection
