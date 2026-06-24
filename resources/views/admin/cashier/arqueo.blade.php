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
        <a href="{{ route('admin.cashier.arqueo.export', ['start' => $startDate, 'end' => $endDate]) }}" class="btn btn-sm btn-admin-outline" title="Exportar CSV">
            <i class="bi bi-download"></i> Exportar
        </a>
        <button onclick="window.print()" class="btn btn-sm btn-admin-outline" title="Imprimir">
            <i class="bi bi-printer"></i> Imprimir
        </button>
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
    <div class="card-footer bg-white border-top d-flex justify-content-center py-3">
        {{ $tickets->links('vendor.pagination.bootstrap-5') }}
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
    .print-table { width: 100%; border-collapse: collapse; font-size: .8rem; margin-top: 10px; }
    .print-table th { background: #eee !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
    .print-table th, .print-table td { border: 1px solid #333; padding: 4px 8px; text-align: left; }
    .print-summary { margin-top: 10px; font-size: .8rem; }
    .print-summary td { padding: 2px 8px; }
}
</style>

<div id="print-area">
    <div class="print-header">
        <h2>Arqueo de Caja</h2>
        <p>Período: {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} al {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}</p>
    </div>

    @if($summary)
    <div class="print-summary">
        <table>
            <tr><td><strong>Boletos vendidos:</strong></td><td>{{ $summary->total_tickets }}</td></tr>
            <tr><td><strong>Ingreso total:</strong></td><td>${{ number_format($summary->total_revenue, 2) }}</td></tr>
            <tr><td><strong>Viajes con ventas:</strong></td><td>{{ $summary->total_trips }}</td></tr>
        </table>
    </div>
    @endif

    <h3 style="font-size:1rem;margin:15px 0 5px;">Detalle de transacciones</h3>
    <table class="print-table">
        <thead>
            <tr><th>#</th><th>Folio</th><th>Fecha venta</th><th>Pasajero</th><th>Ruta</th><th>Fecha viaje</th><th>Hora</th><th>Asiento</th><th>Monto</th></tr>
        </thead>
        <tbody>
            @foreach($tickets as $idx => $t)
            <tr>
                <td>{{ $idx + 1 }}</td>
                <td>{{ $t->folio }}</td>
                <td>{{ $t->sale_date->format('d/m/Y') }}</td>
                <td>{{ $t->passenger_name }}</td>
                <td>{{ $t->trip->departure_city }} → {{ $t->trip->arrival_city }}</td>
                <td>{{ $t->trip->departure_date->format('d/m/Y') }}</td>
                <td>{{ substr($t->trip->departure_time, 0, 5) }}</td>
                <td>{{ $t->seat_number }}</td>
                <td>${{ number_format($t->trip->price, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top:15px;font-size:.75rem;text-align:right;color:#666;">
        Impreso: {{ now()->format('d/m/Y H:i') }} · Total: {{ $tickets->total() }} registro(s)
    </div>
</div>
@endsection
