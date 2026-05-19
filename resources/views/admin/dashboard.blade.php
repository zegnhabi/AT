@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('content')
<div class="page-title"><i class="bi bi-grid-1x2-fill"></i> Dashboard</div>

<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card card-admin position-relative">
            <div class="card-body card-gradient-primary" style="border-radius:12px;">
                <div class="kpi-value">{{ $tripsToday }}</div>
                <div class="kpi-label"><i class="bi bi-bus-front me-1"></i> Viajes hoy</div>
                <i class="bi bi-bus-front-fill kpi-icon"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-admin position-relative">
            <div class="card-body card-gradient-success" style="border-radius:12px;">
                <div class="kpi-value">{{ $ticketsToday }}</div>
                <div class="kpi-label"><i class="bi bi-ticket me-1"></i> Boletos vendidos hoy</div>
                <i class="bi bi-ticket-perforated-fill kpi-icon"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-admin position-relative">
            <div class="card-body card-gradient-warning" style="border-radius:12px;">
                <div class="kpi-value">${{ number_format($revenueToday, 2) }}</div>
                <div class="kpi-label"><i class="bi bi-currency-dollar me-1"></i> Ingresos hoy</div>
                <i class="bi bi-cash-stack kpi-icon"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-admin position-relative">
            <div class="card-body card-gradient-info" style="border-radius:12px;">
                <div class="kpi-value">{{ number_format($occupancyRate, 1) }}%</div>
                <div class="kpi-label"><i class="bi bi-graph-up-arrow me-1"></i> Ocupación promedio</div>
                <i class="bi bi-bar-chart-fill kpi-icon"></i>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-2">
        <div class="card card-admin text-center">
            <div class="card-body py-3">
                <div style="font-size:1.8rem;font-weight:700;color:var(--admin-accent);">{{ $activeBuses }}</div>
                <small class="text-muted"><i class="bi bi-truck-front me-1"></i> Autobuses</small>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card card-admin text-center">
            <div class="card-body py-3">
                <div style="font-size:1.8rem;font-weight:700;color:var(--admin-success);">{{ $totalDrivers }}</div>
                <small class="text-muted"><i class="bi bi-people me-1"></i> Choferes</small>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-6">
        <div class="card card-admin h-100">
            <div class="card-header bg-white">
                <i class="bi bi-route text-primary me-1"></i> Rutas más populares hoy
            </div>
            <div class="card-body p-0">
                <table class="table table-admin">
                    <thead>
                        <tr><th>Ruta</th><th class="text-center">Viajes</th><th class="text-center">Boletos</th></tr>
                    </thead>
                    <tbody>
                        @forelse($topRoutes as $route)
                        <tr>
                            <td><i class="bi bi-arrow-right-circle text-success me-1"></i> {{ $route->departure_city }} <i class="bi bi-arrow-right mx-1 text-muted"></i> {{ $route->arrival_city }}</td>
                            <td class="text-center"><span class="badge bg-info bg-opacity-10 text-info badge-status">{{ $route->trip_count }}</span></td>
                            <td class="text-center"><span class="badge bg-success bg-opacity-10 text-success badge-status">{{ $route->ticket_count }}</span></td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="text-center text-muted py-3">Sin datos hoy</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card card-admin h-100">
            <div class="card-header bg-white">
                <i class="bi bi-graph-up text-warning me-1"></i> Ingresos últimos 7 días
            </div>
            <div class="card-body">
                <table class="table table-admin">
                    <thead><tr><th>Fecha</th><th class="text-end">Ingreso</th></tr></thead>
                    <tbody>
                        @foreach($revenueWeek as $day)
                        <tr>
                            <td><i class="bi bi-calendar3 text-muted me-1"></i> {{ $day['date'] }}</td>
                            <td class="text-end fw-semibold" style="color:var(--admin-success);">${{ number_format($day['revenue'], 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card card-admin h-100">
            <div class="card-header bg-white">
                <i class="bi bi-bar-chart-fill text-info me-1"></i> Boletos vendidos por hora (hoy)
            </div>
            <div class="card-body">
                @php $maxCount = $ticketsByHour->max() ?: 1; @endphp
                @if($ticketsByHour->isEmpty())
                    <div class="text-center text-muted py-4"><i class="bi bi-inbox me-2"></i>Sin ventas hoy</div>
                @else
                    <div style="display:flex;align-items:flex-end;gap:3px;height:150px;padding-top:10px;">
                        @foreach(range(0, 23) as $h)
                            @php
                                $count = $ticketsByHour->get($h, 0);
                                $pct = $count / $maxCount * 100;
                            @endphp
                            <div style="flex:1;display:flex;flex-direction:column;align-items:center;">
                                <div class="chart-bar" style="height:{{ max($pct, 0) }}%;background:linear-gradient(to top, #3498db, #1abc9c);width:100%;{{ $count > 0 ? '' : 'opacity:0.3;' }}"></div>
                                <small style="font-size:8px;color:#95a5a6;margin-top:4px;">{{ $h }}h</small>
                            </div>
                        @endforeach
                    </div>
                    <div class="text-center text-muted mt-2 small">
                        <span class="badge bg-primary bg-opacity-10 text-primary me-2">Pico: {{ $maxCount }} boletos</span>
                        <span class="badge bg-info bg-opacity-10 text-info">Total: {{ $ticketsByHour->sum() }}</span>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
