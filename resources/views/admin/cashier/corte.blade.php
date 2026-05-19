@extends('admin.layouts.app')

@section('title', 'Corte de Caja')
@section('content')
<div class="d-flex justify-content-between align-items-center page-title flex-wrap gap-2">
    <div><i class="bi bi-cash-stack"></i> Corte de caja</div>
    <form method="GET" class="d-flex gap-2 filter-bar p-2 m-0">
        <div class="input-group input-group-sm" style="width:auto;">
            <span class="input-group-text bg-white"><i class="bi bi-calendar3 text-muted"></i></span>
            <input type="date" name="date" class="form-control border-start-0" style="width:auto;"
                   value="{{ $date }}">
        </div>
        <button class="btn btn-admin-primary btn-sm"><i class="bi bi-search"></i> Consultar</button>
    </form>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card card-admin position-relative">
            <div class="card-body card-gradient-success" style="border-radius:12px;">
                <div class="kpi-value">{{ $totalTickets }}</div>
                <div class="kpi-label"><i class="bi bi-ticket me-1"></i> Boletos vendidos</div>
                <i class="bi bi-ticket-perforated-fill kpi-icon"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-admin position-relative">
            <div class="card-body card-gradient-warning" style="border-radius:12px;">
                <div class="kpi-value">${{ number_format($totalRevenue, 2) }}</div>
                <div class="kpi-label"><i class="bi bi-currency-dollar me-1"></i> Ingreso total</div>
                <i class="bi bi-cash-stack kpi-icon"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-admin position-relative">
            <div class="card-body card-gradient-info" style="border-radius:12px;">
                <div class="kpi-value">${{ number_format($revenueYesterday, 2) }}</div>
                <div class="kpi-label"><i class="bi bi-arrow-left-circle me-1"></i> Ingreso ayer</div>
                <i class="bi bi-calendar2-day kpi-icon"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-admin position-relative">
            <div class="card-body card-gradient-secondary" style="border-radius:12px;">
                <div class="kpi-value">${{ number_format($revenueWeek, 2) }}</div>
                <div class="kpi-label"><i class="bi bi-calendar-range me-1"></i> Últimos 7 días</div>
                <i class="bi bi-graph-up kpi-icon"></i>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-5">
        <div class="card card-admin h-100">
            <div class="card-header bg-white">
                <i class="bi bi-pie-chart text-primary me-1"></i> Resumen por ruta
            </div>
            <div class="card-body p-0">
                <table class="table table-admin">
                    <thead><tr><th>Ruta</th><th class="text-center">Boletos</th><th class="text-end">Ingreso</th></tr></thead>
                    <tbody>
                        @forelse($byRoute as $route => $data)
                        <tr>
                            <td>
                                @php $parts = explode(' → ', $route); @endphp
                                <span class="badge bg-primary bg-opacity-10 text-primary badge-status">{{ $parts[0] }}</span>
                                <i class="bi bi-arrow-right mx-1 text-muted"></i>
                                <span class="badge bg-success bg-opacity-10 text-success badge-status">{{ $parts[1] ?? '' }}</span>
                            </td>
                            <td class="text-center"><span class="badge bg-info bg-opacity-10 text-info badge-status">{{ $data['count'] }}</span></td>
                            <td class="text-end fw-semibold" style="color:var(--admin-success);">${{ number_format($data['revenue'], 2) }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="text-center text-muted py-3">Sin ventas en esta fecha</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-7">
        <div class="card card-admin h-100">
            <div class="card-header bg-white">
                <i class="bi bi-receipt text-warning me-1"></i> Detalle de ventas
            </div>
            <div class="card-body p-0">
                <div class="table-responsive" style="max-height:350px;">
                    <table class="table table-admin">
                        <thead>
                            <tr><th>Folio</th><th>Pasajero</th><th>Ruta</th><th class="text-center">Asiento</th><th class="text-end">Monto</th></tr>
                        </thead>
                        <tbody>
                            @forelse($tickets as $t)
                            <tr>
                                <td class="text-muted">{{ $t->folio }}</td>
                                <td><i class="bi bi-person me-1 text-muted"></i>{{ $t->passenger_name }}</td>
                                <td>
                                    <span class="badge bg-primary bg-opacity-10 text-primary badge-status" style="font-size:10px;">{{ $t->trip->departure_city }}</span>
                                    <i class="bi bi-arrow-right mx-1 text-muted" style="font-size:9px;"></i>
                                    <span class="badge bg-success bg-opacity-10 text-success badge-status" style="font-size:10px;">{{ $t->trip->arrival_city }}</span>
                                </td>
                                <td class="text-center"><span class="badge bg-info bg-opacity-10 text-info badge-status">{{ $t->seat_number }}</span></td>
                                <td class="text-end fw-semibold" style="color:var(--admin-success);">${{ number_format($t->trip->price, 2) }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="text-center text-muted py-4">Sin ventas en esta fecha</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
