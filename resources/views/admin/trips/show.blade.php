@extends('admin.layouts.app')

@section('title', "Viaje #$trip->id")
@section('content')
<div class="d-flex justify-content-between align-items-center page-title flex-wrap gap-2">
    <div><i class="bi bi-ticket-perforated-fill"></i> Viaje #{{ $trip->id }}</div>
    <a href="{{ route('admin.trips.index') }}" class="btn btn-admin-outline btn-sm">
        <i class="bi bi-arrow-left"></i> Volver
    </a>
</div>

<div class="row g-4">
    <div class="col-md-6">
        <div class="card card-admin h-100">
            <div class="card-header bg-white">
                <i class="bi bi-info-circle text-primary me-1"></i> Detalle del viaje
            </div>
            <div class="card-body">
                <table class="table table-admin">
                    <tr>
                        <td class="text-muted" style="width:40%;">Ruta</td>
                        <td class="fw-semibold">
                            <span class="badge bg-primary bg-opacity-10 text-primary badge-status">{{ $trip->departure_city }}</span>
                            <i class="bi bi-arrow-right mx-1"></i>
                            <span class="badge bg-success bg-opacity-10 text-success badge-status">{{ $trip->arrival_city }}</span>
                        </td>
                    </tr>
                    <tr><td class="text-muted">Fecha salida</td><td><i class="bi bi-calendar3 me-1 text-muted"></i>{{ $trip->departure_date->format('d-m-Y') }}</td></tr>
                    <tr><td class="text-muted">Hora salida</td><td><i class="bi bi-clock me-1 text-muted"></i>{{ substr($trip->departure_time, 0, 5) }}</td></tr>
                    <tr><td class="text-muted">Terminal salida</td><td><i class="bi bi-geo me-1 text-muted"></i>{{ $trip->departure_terminal }}</td></tr>
                    <tr><td class="text-muted">Terminal llegada</td><td><i class="bi bi-geo-alt me-1 text-muted"></i>{{ $trip->arrival_terminal }}</td></tr>
                    <tr>
                        <td class="text-muted">Precio</td>
                        <td class="fw-bold" style="color:var(--admin-success);">${{ number_format($trip->price, 2) }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Autobús</td>
                        <td>
                            <span class="badge bg-secondary bg-opacity-10 text-secondary badge-status">#{{ $trip->bus_id }}</span>
                            <small class="text-muted ms-1">{{ $trip->bus->driver->name ?? 'Sin chofer' }}</small>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted">Boletos vendidos</td>
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

    <div class="col-md-6">
        <div class="card card-admin h-100">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <span><i class="bi bi-people text-primary me-1"></i> Pasajeros</span>
                <span class="badge bg-primary badge-status">{{ $trip->tickets->count() }} boleto(s)</span>
            </div>
            <div class="card-body p-0">
                @if($trip->tickets->isEmpty())
                    <div class="text-center text-muted py-5">
                        <i class="bi bi-inbox" style="font-size:2rem;"></i>
                        <div class="mt-2">Sin boletos vendidos</div>
                    </div>
                @else
                    <div class="table-responsive" style="max-height:400px;">
                        <table class="table table-admin">
                            <thead>
                                <tr><th>Folio</th><th>Asiento</th><th>Pasajero</th><th>Fecha venta</th></tr>
                            </thead>
                            <tbody>
                                @foreach($trip->tickets as $tk)
                                <tr>
                                    <td class="text-muted">{{ $tk->folio }}</td>
                                    <td><span class="badge bg-info bg-opacity-10 text-info badge-status">{{ $tk->seat_number }}</span></td>
                                    <td><i class="bi bi-person me-1 text-muted"></i>{{ $tk->passenger_name }}</td>
                                    <td>{{ $tk->sale_date->format('d-m-Y') }}</td>
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
@endsection
