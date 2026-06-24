@extends('admin.layouts.app')

@section('title', 'Ciudades')
@section('content')
<div class="d-flex justify-content-between align-items-center page-title flex-wrap gap-2">
    <div><i class="bi bi-geo-alt-fill"></i> Ciudades</div>
    <div class="d-flex align-items-center gap-2">
        <label class="small text-muted mb-0">Mostrar:</label>
        <select id="perPageSelect" class="form-select form-select-sm" style="width:auto;" onchange="changePerPage(this)">
            @foreach([5, 10, 25, 50] as $size)
                <option value="{{ $size }}" {{ $perPage == $size ? 'selected' : '' }}>{{ $size }}</option>
            @endforeach
            <option value="all" {{ $perPage == 'all' ? 'selected' : '' }}>Todos</option>
        </select>
    </div>
</div>

<div class="card card-admin">
    <div class="table-responsive">
        <table class="table table-admin">
            <thead>
                <tr><th>#</th><th>Ciudad</th><th class="text-center">Viajes disponibles</th></tr>
            </thead>
            <tbody>
                @forelse($legacyCities as $row)
                @php $cityName = is_object($row) ? $row->departure_city : $row; @endphp
                <tr>
                    <td class="text-muted">{{ $loop->iteration + ($legacyCities->currentPage() - 1) * $legacyCities->perPage() }}</td>
                    <td>
                        <i class="bi bi-geo-alt-fill text-danger me-1"></i>
                        <a href="{{ route('admin.cities.trips', $cityName) }}" class="text-decoration-none fw-semibold">{{ $cityName }}</a>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('admin.cities.trips', $cityName) }}" class="btn btn-sm btn-admin-outline">
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
    <div class="card-footer bg-white border-top d-flex justify-content-center py-3">
        {{ $legacyCities->links('vendor.pagination.bootstrap-5') }}
    </div>
</div>
@endsection
