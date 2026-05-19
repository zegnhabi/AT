@extends('layouts.app')

@section('title', __('messages.title5'))
@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="alert alert-success text-center">
            <strong>{{ __('messages.purchased') }} {{ count($tickets) }} {{ __('messages.tickets') }}</strong>
            <div class="mt-2">
                <button onclick="window.print()" class="btn btn-primary btn-sm me-1">
                    &#x1F5A8; {{ __('messages.print') }}
                </button>
                <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-sm">
                    &#x1F3E0; {{ __('messages.home') }}
                </a>
            </div>
        </div>

        @foreach($tickets as $ticket)
        <div class="card mb-3 border-secondary">
            <div class="card-body">
                <div class="text-center fw-bold mb-3 fs-5">
                    {{ __('messages.company') }}
                </div>

                <div class="row mb-2">
                    <div class="col-6">
                        <strong>{{ __('messages.origin') }}:</strong> {{ $ticket['trip']->departure_city }}<br>
                        <small>{{ __('messages.terminal_origin') }} {{ $ticket['trip']->departure_terminal }}</small>
                    </div>
                    <div class="col-6">
                        <strong>{{ __('messages.destination') }}:</strong> {{ $ticket['trip']->arrival_city }}<br>
                        <small>{{ __('messages.terminal_destination') }} {{ $ticket['trip']->arrival_terminal }}</small>
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-6">
                        <strong>{{ __('messages.departure_date') }}</strong>
                        {{ $ticket['trip']->departure_date->format('d-m-Y') }}
                    </div>
                    <div class="col-6">
                        <strong>{{ __('messages.seat') }}</strong> {{ $ticket['seat'] }}
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-6">
                        <strong>{{ __('messages.departure_time') }}</strong>
                        {{ substr($ticket['trip']->departure_time, 0, 5) }}
                    </div>
                    <div class="col-6">
                        <strong>{{ __('messages.fare') }}</strong>
                        ${{ number_format($ticket['trip']->price, 2) }}
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-12">
                        <strong>{{ __('messages.name') }}</strong> {{ $ticket['name'] }}
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-12">
                        <strong>{{ __('messages.issue_place') }}</strong>
                        {{ $ticket['trip']->departure_city }}, {{ $today }}
                    </div>
                </div>

                <div class="text-center fst-italic text-muted small mb-2">
                    {{ __('messages.suggestion') }}
                </div>

                <div class="text-center">
                    <img src="data:image/svg+xml;base64,{{ $ticket['qrCode'] }}"
                         alt="QR {{ $ticket['seat'] }}" style="width:110px;height:110px;">
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
