@extends('admin.layouts.app')

@section('title', 'Ciudades')
@section('content')
<div class="page-title"><i class="bi bi-geo-alt-fill"></i> Ciudades</div>

<div class="card card-admin">
    <div class="table-responsive">
        <table class="table table-admin">
            <thead>
                <tr><th>#</th><th>Ciudad</th><th class="text-center">Viajes disponibles</th></tr>
            </thead>
            <tbody>
                @forelse($legacyCities as $city)
                <tr>
                    <td class="text-muted">{{ $loop->iteration }}</td>
                    <td>
                        <i class="bi bi-geo-alt-fill text-danger me-1"></i>
                        <a href="{{ route('admin.cities.trips', $city) }}" class="text-decoration-none fw-semibold">{{ $city }}</a>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('admin.cities.trips', $city) }}" class="btn btn-sm btn-admin-outline">
                            <i class="bi bi-eye"></i> Ver viajes
                        </a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="3" class="text-center text-muted py-4">No hay ciudades registradas</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
