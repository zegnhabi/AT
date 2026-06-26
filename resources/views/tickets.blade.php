@extends('layouts.app')

@section('title', __('messages.title5'))
@push('scripts')
<script>
@if(session('purchase_completed'))
pushGA4Event('purchase_completed', {
    trip_id: {{ session('purchase_completed.trip_id') }},
    origin: '{{ session('purchase_completed.origin') }}',
    destination: '{{ session('purchase_completed.destination') }}',
    ticket_count: {{ session('purchase_completed.ticket_count') }},
    total_amount: {{ session('purchase_completed.total_amount') }},
    folio: '{{ session('purchase_completed.folio') ?? '' }}'
});
@endif
pushGA4Event('view_tickets', {
    ticket_count: {{ count($tickets) }}
});
</script>
@endpush
@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        @if(session('purchase_completed.email_sent'))
        <div class="alert alert-info text-center small py-2 mb-3">
            <i class="bi bi-envelope-check"></i> {{ __('messages.email_sent') }}
        </div>
        @endif

        @php $firstTicket = $tickets[0] ?? null; @endphp

        <div class="alert alert-success text-center">
            <strong>{{ __('messages.purchased') }} {{ count($tickets) }} {{ __('messages.tickets') }}</strong>
            <div class="mt-2 d-flex justify-content-center gap-2 flex-wrap">
                <button onclick="window.print()" class="btn btn-primary btn-sm">
                    &#x1F5A8; {{ __('messages.print') }}
                </button>
                @if($firstTicket)
                <a href="https://wa.me/?text={{ urlencode(__('messages.share_text', ['origin' => $firstTicket['trip']->departure_city, 'destination' => $firstTicket['trip']->arrival_city, 'date' => $firstTicket['trip']->departure_date->format('d-m-Y'), 'time' => substr($firstTicket['trip']->departure_time, 0, 5)])) }}"
                   target="_blank" class="btn btn-success btn-sm">
                    <i class="bi bi-whatsapp"></i> {{ __('messages.share_whatsapp') }}
                </a>
                <a href="mailto:?subject={{ urlencode(__('messages.share_email_subject')) }}&body={{ urlencode(__('messages.share_text', ['origin' => $firstTicket['trip']->departure_city, 'destination' => $firstTicket['trip']->arrival_city, 'date' => $firstTicket['trip']->departure_date->format('d-m-Y'), 'time' => substr($firstTicket['trip']->departure_time, 0, 5)])) }}"
                   class="btn btn-secondary btn-sm">
                    <i class="bi bi-envelope"></i> {{ __('messages.share_email') }}
                </a>
                @endif
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
