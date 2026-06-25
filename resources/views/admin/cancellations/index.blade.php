@extends('admin.layouts.app')

@section('title', __('messages.admin_cancel_title', ['folio' => $ticket->folio]))
@section('content')
<div class="d-flex justify-content-between align-items-center page-title flex-wrap gap-2">
    <div><i class="bi bi-x-circle"></i> {{ __('messages.admin_cancel_title', ['folio' => $ticket->folio]) }}</div>
    <a href="{{ route('admin.trips.show', $ticket->trip) }}" class="btn btn-admin-outline btn-sm">
        <i class="bi bi-arrow-left"></i> {{ __('messages.admin_back') }}
    </a>
</div>

<div class="card card-admin">
    <div class="card-body text-center py-5">
        <i class="bi bi-exclamation-triangle text-warning" style="font-size:3rem;"></i>
        <h4 class="mt-3">{{ __('messages.admin_cancel_confirm') }}</h4>
        <table class="table table-admin text-start mx-auto" style="max-width:400px;">
            <tr><td class="text-muted">{{ __('messages.admin_folio') }}</td><td class="fw-semibold">{{ $ticket->folio }}</td></tr>
            <tr><td class="text-muted">{{ __('messages.admin_passenger') }}</td><td>{{ $ticket->passenger_name }}</td></tr>
            <tr><td class="text-muted">{{ __('messages.admin_seat') }}</td><td><span class="badge bg-info bg-opacity-10 text-info badge-status">{{ $ticket->seat_number }}</span></td></tr>
            <tr><td class="text-muted">{{ __('messages.admin_route') }}</td><td>{{ $ticket->trip->departure_city }} → {{ $ticket->trip->arrival_city }}</td></tr>
            <tr><td class="text-muted">{{ __('messages.admin_departure_date') }}</td><td>{{ $ticket->trip->departure_date->format('d-m-Y') }} {{ substr($ticket->trip->departure_time, 0, 5) }}</td></tr>
            <tr><td class="text-muted">{{ __('messages.admin_fare') }}</td><td class="fw-bold text-success">${{ number_format($ticket->trip->price, 2) }}</td></tr>
        </table>

        <form action="{{ route('admin.cancellations.destroy', $ticket) }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-admin-danger"
                    onclick="return confirm('{{ __('messages.admin_cancel_confirm_alert') }}')">
                <i class="bi bi-trash"></i> {{ __('messages.admin_cancel_confirm_btn') }}
            </button>
            <a href="{{ route('admin.trips.show', $ticket->trip) }}" class="btn btn-admin-outline ms-2">
                {{ __('messages.admin_branding_cancel') }}
            </a>
        </form>
    </div>
</div>
@endsection
