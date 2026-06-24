@extends('admin.layouts.app')

@section('title', __('messages.admin_drivers'))
@section('content')
<div class="d-flex justify-content-between align-items-center page-title flex-wrap gap-2">
    <div><i class="bi bi-people-fill"></i> {{ __('messages.admin_drivers') }}</div>
    <a href="{{ route('admin.drivers.create') }}" class="btn btn-admin-primary btn-sm">
        <i class="bi bi-plus-lg"></i> {{ __('messages.admin_new_driver') }}
    </a>
</div>

<div class="card card-admin">
    <div class="table-responsive">
        <table class="table table-admin">
            <thead>
                <tr><th>ID</th><th>{{ __('messages.admin_name') }}</th><th>{{ __('messages.admin_gender') }}</th><th>{{ __('messages.admin_age') }}</th><th>{{ __('messages.admin_phone') }}</th><th>{{ __('messages.admin_buses') }}</th><th class="text-end">{{ __('messages.admin_actions') }}</th></tr>
            </thead>
            <tbody>
                @foreach($drivers as $d)
                <tr>
                    <td class="text-muted">{{ $d->id }}</td>
                    <td><i class="bi bi-person-circle text-primary me-1"></i> {{ $d->name }}</td>
                    <td>
                        @if($d->gender === 'M') <span class="badge bg-primary bg-opacity-10 text-primary badge-status">{{ __('messages.admin_male') }}</span>
                        @elseif($d->gender === 'F') <span class="badge bg-danger bg-opacity-10 text-danger badge-status">{{ __('messages.admin_female') }}</span>
                        @else <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td>{{ $d->age ?? '—' }}</td>
                    <td>{{ $d->phone ?? '—' }}</td>
                    <td><span class="badge bg-info bg-opacity-10 text-info badge-status">{{ $d->buses_count }}</span></td>
                    <td class="text-end">
                        <a href="{{ route('admin.drivers.edit', $d) }}" class="btn btn-sm btn-admin-outline">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('admin.drivers.destroy', $d) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('{{ __('messages.admin_delete_driver_confirm') }}');">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-admin-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @if($drivers->hasPages())
    <div class="card-footer bg-white border-top d-flex justify-content-center py-3">
        {{ $drivers->links('vendor.pagination.bootstrap-5') }}
    </div>
    @endif
</div>
@endsection
