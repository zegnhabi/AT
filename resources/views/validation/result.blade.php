@extends('layouts.app')

@section('title', __('messages.validation_result_title'))
@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header text-center fw-bold
                @if($isExpired) bg-secondary text-white
                @else bg-success text-white
                @endif">
                @if($isExpired)
                <i class="bi bi-clock-history"></i> {{ __('messages.validation_expired_title') }}
                @else
                <i class="bi bi-check-circle-fill"></i> {{ __('messages.validation_valid_title') }}
                @endif
            </div>
            <div class="card-body">
                <table class="table table-bordered mb-0">
                    <tr>
                        <td class="text-muted">{{ __('messages.admin_folio') }}</td>
                        <td class="fw-bold fs-5">{{ $ticket->folio }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">{{ __('messages.admin_passenger') }}</td>
                        <td>{{ $ticket->passenger_name }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">{{ __('messages.origin') }}</td>
                        <td>{{ $ticket->trip->departure_city }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">{{ __('messages.destination') }}</td>
                        <td>{{ $ticket->trip->arrival_city }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">{{ __('messages.admin_seat') }}</td>
                        <td><span class="badge bg-info fs-6">{{ $ticket->seat_number }}</span></td>
                    </tr>
                    <tr>
                        <td class="text-muted">{{ __('messages.departure_date') }}</td>
                        <td class="{{ $isExpired ? 'text-danger fw-bold' : '' }}">
                            {{ $ticket->trip->departure_date->format('d-m-Y') }}
                            {{ substr($ticket->trip->departure_time, 0, 5) }}
                            @if($isExpired)
                                <span class="badge bg-danger ms-2">{{ __('messages.validation_expired') }}</span>
                            @else
                                <span class="badge bg-success ms-2">{{ __('messages.validation_active') }}</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted">{{ __('messages.admin_bus') }}</td>
                        <td>#{{ $ticket->trip->bus_id }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">{{ __('messages.admin_sale_date') }}</td>
                        <td>{{ $ticket->sale_date->format('d-m-Y') }}</td>
                    </tr>
                </table>

                <div class="text-center mt-3">
                    <a href="{{ route('validation.index') }}" class="btn btn-warning">
                        <i class="bi bi-qr-code-scan"></i> {{ __('messages.validation_another') }}
                    </a>
                    <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                        {{ __('messages.home') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
