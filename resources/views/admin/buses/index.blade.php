@extends('admin.layouts.app')

@section('title', __('messages.admin_buses'))
@section('content')
<div class="d-flex justify-content-between align-items-center page-title flex-wrap gap-2">
    <div><i class="bi bi-truck-front-fill"></i> {{ __('messages.admin_buses') }}</div>
    <a href="{{ route('admin.buses.create') }}" class="btn btn-admin-primary btn-sm">
        <i class="bi bi-plus-lg"></i> {{ __('messages.admin_new_bus') }}
    </a>
</div>

<div class="card card-admin">
    <div class="table-responsive">
        <table class="table table-admin">
            <thead>
                <tr><th>ID</th><th>{{ __('messages.admin_seats') }}</th><th>{{ __('messages.admin_model') }}</th><th>{{ __('messages.admin_serial_number') }}</th><th>{{ __('messages.admin_assigned_driver') }}</th><th class="text-end">{{ __('messages.admin_actions') }}</th></tr>
            </thead>
            <tbody>
                @foreach($buses as $b)
                <tr>
                    <td class="text-muted">{{ $b->id }}</td>
                    <td><span class="badge bg-info bg-opacity-10 text-info badge-status"><i class="bi bi-grid-3x3 me-1"></i>{{ $b->seat_count }}</span></td>
                    <td>{{ $b->model_year ?? '—' }}</td>
                    <td><code class="text-muted">{{ $b->serial_number ?? '—' }}</code></td>
                    <td>
                        @if($b->driver)
                            <i class="bi bi-person-circle text-success me-1"></i>{{ $b->driver->name }}
                        @else
                            <span class="text-muted"><i class="bi bi-dash-circle me-1"></i>{{ __('messages.admin_unassigned') }}</span>
                        @endif
                    </td>
                    <td class="text-end">
                        <a href="{{ route('admin.buses.edit', $b) }}" class="btn btn-sm btn-admin-outline">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('admin.buses.destroy', $b) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('{{ __('messages.admin_delete_bus_confirm') }}');">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-admin-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="card-footer bg-white border-top d-flex justify-content-center py-3">
        {{ $buses->links('vendor.pagination.bootstrap-5') }}
    </div>
</div>
@endsection
