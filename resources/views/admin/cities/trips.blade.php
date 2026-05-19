@extends('admin.layouts.app')

@section('title', "Viajes - $city")
@section('content')
<div class="page-title">
    <i class="bi bi-geo-alt-fill text-danger"></i>
    Viajes relacionados con <strong>{{ $city }}</strong>
</div>

<div class="card card-admin">
    <div class="table-responsive">
        <table class="table table-admin">
            <thead>
                <tr><th>ID</th><th>Ruta</th><th>Fecha</th><th>Hora</th><th>Autobús</th><th>Chofer</th><th>Precio</th><th class="text-center">Ocupación</th></tr>
            </thead>
            <tbody>
                @forelse($trips as $t)
                <tr>
                    <td class="text-muted">{{ $t->id }}</td>
                    <td>
                        <span class="badge bg-primary bg-opacity-10 text-primary badge-status">{{ $t->departure_city }}</span>
                        <i class="bi bi-arrow-right mx-1 text-muted"></i>
                        <span class="badge bg-success bg-opacity-10 text-success badge-status">{{ $t->arrival_city }}</span>
                    </td>
                    <td><i class="bi bi-calendar3 text-muted me-1"></i>{{ $t->departure_date->format('d-m-Y') }}</td>
                    <td><i class="bi bi-clock text-muted me-1"></i>{{ substr($t->departure_time, 0, 5) }}</td>
                    <td><span class="badge bg-secondary bg-opacity-10 text-secondary badge-status">#{{ $t->bus_id }}</span></td>
                    <td>{{ $t->bus->driver->name ?? '—' }}</td>
                    <td class="fw-semibold" style="color:var(--admin-success);">${{ number_format($t->price, 2) }}</td>
                    <td class="text-center">
                        @php $pct = $t->bus->seat_count ? round($t->tickets_count / $t->bus->seat_count * 100) : 0; @endphp
                        <div class="d-inline-flex align-items-center gap-1">
                            <div style="width:50px;height:6px;background:#e9ecef;border-radius:3px;overflow:hidden;">
                                <div style="width:{{ $pct }}%;height:100%;background:{{ $pct > 80 ? 'var(--admin-danger)' : ($pct > 50 ? 'var(--admin-warning)' : 'var(--admin-success)') }};border-radius:3px;"></div>
                            </div>
                            <small class="text-muted">{{ $t->tickets_count }}/{{ $t->bus->seat_count ?? 36 }}</small>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center text-muted py-4">Sin viajes para esta ciudad</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($trips->hasPages())
    <div class="card-footer bg-white border-top d-flex justify-content-center py-3">
        {{ $trips->links() }}
    </div>
    @endif
</div>

<a href="{{ route('admin.cities.index') }}" class="btn btn-admin-outline mt-3">
    <i class="bi bi-arrow-left"></i> Volver a ciudades
</a>
@endsection
