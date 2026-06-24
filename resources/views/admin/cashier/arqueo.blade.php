@extends('admin.layouts.app')

@section('title', 'Arqueo')
@section('content')
<div class="d-flex justify-content-between align-items-center page-title flex-wrap gap-2">
    <div><i class="bi bi-calculator-fill"></i> Arqueo de caja</div>
    <div class="d-flex align-items-center gap-2 flex-wrap">
        <form method="GET" class="d-flex gap-2 filter-bar p-2 m-0">
            <input type="hidden" name="per_page" value="{{ $perPage }}">
            <div class="input-group input-group-sm" style="width:auto;">
                <span class="input-group-text bg-white"><i class="bi bi-calendar-range text-muted"></i></span>
                <input type="date" name="start" class="form-control border-start-0" style="width:auto;"
                       value="{{ $startDate }}">
            </div>
            <div class="input-group input-group-sm" style="width:auto;">
                <span class="input-group-text bg-white"><i class="bi bi-calendar-check text-muted"></i></span>
                <input type="date" name="end" class="form-control border-start-0" style="width:auto;"
                       value="{{ $endDate }}">
            </div>
            <button class="btn btn-admin-primary btn-sm"><i class="bi bi-search"></i> Consultar</button>
        </form>
        <div class="d-flex align-items-center gap-1">
            <label class="small text-muted mb-0">Mostrar:</label>
            <select class="form-select form-select-sm per-page-select" style="width:auto;">
                @foreach([5, 10, 25, 50] as $size)
                    <option value="{{ $size }}" {{ $perPage == $size ? 'selected' : '' }}>{{ $size }}</option>
                @endforeach
                <option value="all" {{ $perPage == 'all' ? 'selected' : '' }}>Todos</option>
            </select>
        </div>
    </div>
</div>

@if($summary)
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card card-admin position-relative">
            <div class="card-body card-gradient-success" style="border-radius:12px;">
                <div class="kpi-value">{{ $summary->total_tickets }}</div>
                <div class="kpi-label"><i class="bi bi-ticket me-1"></i> Boletos vendidos</div>
                <i class="bi bi-ticket-perforated-fill kpi-icon"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-admin position-relative">
            <div class="card-body card-gradient-warning" style="border-radius:12px;">
                <div class="kpi-value">${{ number_format($summary->total_revenue, 2) }}</div>
                <div class="kpi-label"><i class="bi bi-currency-dollar me-1"></i> Ingreso total</div>
                <i class="bi bi-cash-stack kpi-icon"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-admin position-relative">
            <div class="card-body card-gradient-info" style="border-radius:12px;">
                <div class="kpi-value">{{ $summary->total_trips }}</div>
                <div class="kpi-label"><i class="bi bi-bus-front me-1"></i> Viajes con ventas</div>
                <i class="bi bi-bus-front-fill kpi-icon"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-admin position-relative">
            <div class="card-body card-gradient-primary" style="border-radius:12px;">
                <div class="kpi-value" style="font-size:1.2rem;">
                    {{ \Carbon\Carbon::parse($summary->first_date)->format('d-m') }}
                    <i class="bi bi-arrow-right mx-1" style="font-size:1rem;"></i>
                    {{ \Carbon\Carbon::parse($summary->last_date)->format('d-m-Y') }}
                </div>
                <div class="kpi-label"><i class="bi bi-calendar-range me-1"></i> Período</div>
                <i class="bi bi-clock-history kpi-icon"></i>
            </div>
        </div>
    </div>
</div>
@endif

<div class="card card-admin">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <span><i class="bi bi-list-check text-primary me-1"></i> Detalle de transacciones</span>
        <span class="badge bg-primary badge-status">{{ $tickets->total() }} registro(s)</span>
    </div>
    <div class="table-responsive" style="max-height:550px;">
        <table class="table table-admin">
            <thead>
                <tr><th>Folio</th><th>Fecha venta</th><th>Pasajero</th><th>Ruta</th><th>Fecha viaje</th><th>Hora</th><th class="text-center">Asiento</th><th class="text-end">Monto</th></tr>
            </thead>
            <tbody>
                @forelse($tickets as $t)
                <tr>
                    <td class="text-muted">{{ $t->folio }}</td>
                    <td><i class="bi bi-calendar3 me-1 text-muted"></i>{{ $t->sale_date->format('d-m-Y') }}</td>
                    <td><i class="bi bi-person me-1 text-muted"></i>{{ $t->passenger_name }}</td>
                    <td>
                        <span class="badge bg-primary bg-opacity-10 text-primary badge-status" style="font-size:10px;">{{ $t->trip->departure_city }}</span>
                        <i class="bi bi-arrow-right mx-1 text-muted" style="font-size:9px;"></i>
                        <span class="badge bg-success bg-opacity-10 text-success badge-status" style="font-size:10px;">{{ $t->trip->arrival_city }}</span>
                    </td>
                    <td>{{ $t->trip->departure_date->format('d-m-Y') }}</td>
                    <td>{{ substr($t->trip->departure_time, 0, 5) }}</td>
                    <td class="text-center"><span class="badge bg-info bg-opacity-10 text-info badge-status">{{ $t->seat_number }}</span></td>
                    <td class="text-end fw-semibold" style="color:var(--admin-success);">${{ number_format($t->trip->price, 2) }}</td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center text-muted py-4">
                    <i class="bi bi-inbox me-2" style="font-size:1.5rem;"></i><br>Sin transacciones en este período
                </td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($tickets->hasPages())
    <div class="card-footer bg-white border-top d-flex justify-content-center py-3">
        {{ $tickets->links('vendor.pagination.bootstrap-5') }}
    </div>
    @endif
</div>

<script>
document.querySelectorAll('.per-page-select').forEach(function(el) {
    el.addEventListener('change', function() {
        var url = new URL(window.location);
        url.searchParams.set('per_page', this.value);
        url.searchParams.delete('page');
        window.location = url;
    });
});
</script>
@endsection
