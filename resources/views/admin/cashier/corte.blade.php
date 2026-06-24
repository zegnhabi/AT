@extends('admin.layouts.app')

@section('title', 'Corte de Caja')
@section('content')
<div class="d-flex justify-content-between align-items-center page-title flex-wrap gap-2">
    <div><i class="bi bi-cash-stack"></i> Corte de caja</div>
    <div class="d-flex align-items-center gap-2 flex-wrap">
        <form method="GET" class="d-flex gap-2 filter-bar p-2 m-0">
            <div class="input-group input-group-sm" style="width:auto;">
                <span class="input-group-text bg-white"><i class="bi bi-calendar3 text-muted"></i></span>
                <input type="date" name="date" class="form-control border-start-0" style="width:auto;"
                       value="{{ $date }}">
            </div>
            <button class="btn btn-admin-primary btn-sm"><i class="bi bi-search"></i> Consultar</button>
        </form>
        <a href="{{ route('admin.cashier.corte.export', ['date' => $date]) }}" class="btn btn-sm btn-admin-outline" title="Exportar CSV">
            <i class="bi bi-download"></i> Exportar
        </a>
        <button onclick="window.print()" class="btn btn-sm btn-admin-outline" title="Imprimir">
            <i class="bi bi-printer"></i> Imprimir
        </button>
    </div>
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

<style>
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
        <h2>Corte de Caja</h2>
        <p>Fecha: {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}</p>
    </div>

    <div class="print-summary">
        <table>
            <tr><td><strong>Boletos vendidos:</strong></td><td>{{ $totalTickets }}</td></tr>
            <tr><td><strong>Ingreso total:</strong></td><td>${{ number_format($totalRevenue, 2) }}</td></tr>
            <tr><td><strong>Ingreso ayer:</strong></td><td>${{ number_format($revenueYesterday, 2) }}</td></tr>
            <tr><td><strong>Últimos 7 días:</strong></td><td>${{ number_format($revenueWeek, 2) }}</td></tr>
        </table>
    </div>

    @if(!$byRoute->isEmpty())
    <h3 style="font-size:1rem;margin:15px 0 5px;">Resumen por ruta</h3>
    <table class="print-table">
        <thead><tr><th>Ruta</th><th>Boletos</th><th>Ingreso</th></tr></thead>
        <tbody>
            @foreach($byRoute as $route => $data)
            <tr>
                <td>{{ $route }}</td>
                <td>{{ $data['count'] }}</td>
                <td>${{ number_format($data['revenue'], 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    <h3 style="font-size:1rem;margin:15px 0 5px;">Detalle de ventas</h3>
    <table class="print-table">
        <thead>
            <tr><th>#</th><th>Folio</th><th>Pasajero</th><th>Ruta</th><th>Asiento</th><th>Monto</th></tr>
        </thead>
        <tbody>
            @foreach($tickets as $idx => $t)
            <tr>
                <td>{{ $idx + 1 }}</td>
                <td>{{ $t->folio }}</td>
                <td>{{ $t->passenger_name }}</td>
                <td>{{ $t->trip->departure_city }} → {{ $t->trip->arrival_city }}</td>
                <td>{{ $t->seat_number }}</td>
                <td>${{ number_format($t->trip->price, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top:15px;font-size:.75rem;text-align:right;color:#666;">
        Impreso: {{ now()->format('d/m/Y H:i') }} · Total: {{ $totalTickets }} boleto(s) · Ingreso: ${{ number_format($totalRevenue, 2) }}
    </div>
</div>
@endsection
