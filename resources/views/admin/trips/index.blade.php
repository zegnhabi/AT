@extends('admin.layouts.app')

@section('title', __('messages.admin_trips_title'))
@section('content')
<div class="d-flex justify-content-between align-items-center page-title flex-wrap gap-2">
    <div><i class="bi bi-ticket-perforated-fill"></i> {{ __('messages.admin_trips_title') }}</div>
    <div class="d-flex align-items-center gap-2 flex-wrap">
        <a href="{{ route('admin.trips.create') }}" class="btn btn-admin-primary btn-sm">
            <i class="bi bi-plus-lg"></i> {{ __('messages.admin_trips_new') }}
        </a>
        <form class="d-flex gap-2 filter-bar p-2 m-0" method="GET">
            <input type="hidden" name="per_page" value="{{ $perPage }}">
            <div class="input-group input-group-sm" style="width:auto;">
                <span class="input-group-text bg-white"><i class="bi bi-geo-alt text-muted"></i></span>
                <select name="city" class="form-select border-start-0" style="width:auto;">
                    <option value="">{{ __('messages.admin_trips_all_cities') }}</option>
                    @foreach($cities as $c)
                        <option value="{{ $c }}" @selected(request('city') === $c)>{{ $c }}</option>
                    @endforeach
                </select>
            </div>
            <div class="input-group input-group-sm" style="width:auto;">
                <span class="input-group-text bg-white"><i class="bi bi-calendar3 text-muted"></i></span>
                <input type="date" name="date" class="form-control border-start-0" style="width:auto;"
                       value="{{ request('date', now()->format('Y-m-d')) }}">
            </div>
            <button class="btn btn-admin-primary btn-sm"><i class="bi bi-funnel"></i> {{ __('messages.admin_trips_filter') }}</button>
        </form>
    </div>
</div>

<div class="card card-admin">
    <div class="table-responsive">
        <table class="table table-admin">
            <thead>
                <tr><th>{{ __('messages.admin_id') }}</th><th>{{ __('messages.admin_route') }}</th><th>{{ __('messages.admin_date') }}</th><th>{{ __('messages.admin_time') }}</th><th>{{ __('messages.admin_trips_bus_driver') }}</th><th>{{ __('messages.admin_price') }}</th><th class="text-center">{{ __('messages.admin_tickets') }}</th><th class="text-end">{{ __('messages.admin_actions') }}</th></tr>
            </thead>
            <tbody>
                @forelse($trips as $t)
                <tr>
                    <td class="text-muted">{{ $t->id }}</td>
                    <td>
                        <span class="badge bg-primary bg-opacity-10 text-primary badge-status">{{ $t->departure_city }}</span>
                        <i class="bi bi-arrow-right mx-1 text-muted" style="font-size:10px;"></i>
                        <span class="badge bg-success bg-opacity-10 text-success badge-status">{{ $t->arrival_city }}</span>
                    </td>
                    <td><i class="bi bi-calendar3 text-muted me-1"></i>{{ $t->departure_date->format('d-m-Y') }}</td>
                    <td><i class="bi bi-clock text-muted me-1"></i>{{ substr($t->departure_time, 0, 5) }}</td>
                    <td>
                        <span class="badge bg-secondary bg-opacity-10 text-secondary badge-status">#{{ $t->bus_id }}</span>
                        <small class="text-muted">{{ $t->bus->driver->name ?? __('messages.admin_na') }}</small>
                    </td>
                    <td class="fw-semibold" style="color:var(--admin-success);">${{ number_format($t->price, 2) }}</td>
                    <td class="text-center">
                        @php $pct = $t->bus->seat_count ? round($t->tickets->count() / $t->bus->seat_count * 100) : 0; @endphp
                        <span class="badge @if($pct > 80) bg-danger @elseif($pct > 50) bg-warning text-dark @else bg-success @endif bg-opacity-10 badge-status"
                              style="color:{{ $pct > 80 ? 'var(--admin-danger)' : ($pct > 50 ? 'var(--admin-warning)' : 'var(--admin-success)') }};">
                            {{ $t->tickets->count() }}/{{ $t->bus->seat_count ?? 36 }}
                        </span>
                    </td>
                    <td class="text-end">
                        <a href="{{ route('admin.trips.show', $t) }}" class="btn btn-sm btn-admin-outline">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="{{ route('admin.trips.edit', $t) }}" class="btn btn-sm btn-admin-outline">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('admin.trips.destroy', $t) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('{{ __('messages.admin_trips_confirm_delete') }}');">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-admin-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center text-muted py-4">
                    <i class="bi bi-inbox me-2"></i>{{ __('messages.admin_trips_empty') }}
                </td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer bg-white border-top d-flex justify-content-center py-3">
        {{ $trips->links('vendor.pagination.bootstrap-5') }}
    </div>
</div>
@endsection
