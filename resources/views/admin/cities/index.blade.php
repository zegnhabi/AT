@extends('admin.layouts.app')

@section('title', __('messages.admin_cities_title'))
@section('content')
<div class="d-flex justify-content-between align-items-center page-title flex-wrap gap-2">
    <div><i class="bi bi-geo-alt-fill"></i> {{ __('messages.admin_cities_title') }}</div>
    <button class="btn btn-admin-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addCityModal">
        <i class="bi bi-plus-lg"></i> {{ __('messages.admin_cities_new') }}
    </button>
</div>

@if(session('info'))
    <div class="alert alert-info alert-dismissible fade show">{{ session('info') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show">{{ session('error') }}</div>
@endif

<div class="card card-admin">
    <div class="table-responsive">
        <table class="table table-admin">
            <thead>
                <tr><th>#</th><th>{{ __('messages.admin_city') }}</th><th class="text-center">{{ __('messages.admin_trips_short') }}</th></tr>
            </thead>
            <tbody>
                @forelse($legacyCities as $row)
                @php $cityName = is_object($row) ? $row->departure_city ?? $row : $row; @endphp
                <tr>
                    <td class="text-muted">{{ $loop->iteration + ($legacyCities->currentPage() - 1) * $legacyCities->perPage() }}</td>
                    <td>
                        <i class="bi bi-geo-alt-fill text-danger me-1"></i>
                        <a href="{{ route('admin.cities.trips', $cityName) }}" class="text-decoration-none fw-semibold">{{ $cityName }}</a>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('admin.cities.trips', $cityName) }}" class="btn btn-sm btn-admin-outline">
                            <i class="bi bi-eye"></i> {{ __('messages.admin_cities_view_trips') }}
                        </a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="3" class="text-center text-muted py-4">{{ __('messages.admin_cities_empty') }}</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer bg-white border-top d-flex justify-content-center py-3">
        {{ $legacyCities->links('vendor.pagination.bootstrap-5') }}
    </div>
</div>

<div class="modal fade" id="addCityModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('admin.cities.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-geo-alt text-primary me-1"></i> {{ __('messages.admin_cities_new') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <label class="form-label fw-semibold">{{ __('messages.admin_cities_name_label') }} *</label>
                    <input type="text" name="name" class="form-control form-admin" required maxlength="45"
                           placeholder="{{ __('messages.admin_cities_name_placeholder') }}" list="existingCities">
                    <small class="text-muted">{{ __('messages.admin_cities_help') }}</small>
                    <datalist id="existingCities">
                        @foreach(explode(', ', $allCityNames) as $cn)
                            @if($cn)
                            <option value="{{ $cn }}">
                            @endif
                        @endforeach
                    </datalist>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-admin-outline" data-bs-dismiss="modal">{{ __('messages.admin_cancel') }}</button>
                    <button class="btn btn-admin-primary"><i class="bi bi-check-lg"></i> {{ __('messages.admin_save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
