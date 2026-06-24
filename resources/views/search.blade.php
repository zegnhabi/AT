@extends('layouts.app')

@section('title', __('messages.title2'))
@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-warning text-dark fw-bold">
                {{ __('messages.select_trip') }}
            </div>
            <div class="card-body">
                <div class="row mb-3 text-center fw-bold small text-uppercase text-muted">
                    <div class="col-4">{{ __('messages.date_label') }}</div>
                    <div class="col-4">{{ __('messages.origin') }}</div>
                    <div class="col-4">{{ __('messages.destination') }}</div>
                </div>
                <div class="row mb-3 text-center fw-semibold">
                    <div class="col-4">{{ \Carbon\Carbon::parse($formattedDate)->format('d-m-Y') }}</div>
                    <div class="col-4">{{ $origin }}</div>
                    <div class="col-4">{{ $destination }}</div>
                </div>

                <hr>

                <div class="row text-center fw-bold small text-uppercase text-muted mb-2">
                    <div class="col-3">{{ __('messages.schedule') }}</div>
                    <div class="col-3">{{ __('messages.arrival_time') }}</div>
                    <div class="col-3">{{ __('messages.travel_time') }}</div>
                    <div class="col-3">{{ __('messages.price') }}</div>
                </div>

                @forelse($trips as $trip)
                @php
                    $dep = \Carbon\Carbon::parse($trip->departure_time);
                    $arr = \Carbon\Carbon::parse($trip->arrival_time);
                    $diff = $dep->diff($arr);
                    $hours = $diff->h + ($diff->d * 24);
                    $minutes = $diff->i;
                @endphp
                <div class="row align-items-center py-2 {{ $loop->even ? 'bg-light rounded' : '' }}">
                    <div class="col-3 text-center">
                        <input type="radio" name="trip_id" value="{{ $trip->id }}"
                               class="form-check-input trip-select me-2"
                               data-id="{{ $trip->id }}">
                        {{ $dep->format('H:i') }}
                    </div>
                    <div class="col-3 text-center">
                        {{ $arr->format('H:i') }}
                    </div>
                    <div class="col-3 text-center">
                        <span class="badge bg-secondary bg-opacity-10 text-secondary" style="font-size:.75rem;">
                            {{ $hours > 0 ? $hours.'h ' : '' }}{{ $minutes }}min
                        </span>
                    </div>
                    <div class="col-3 text-center fw-bold text-success">
                        ${{ number_format($trip->price, 2) }}
                    </div>
                </div>
                @if($trip->stops->isNotEmpty())
                <div class="px-4 pb-2">
                    <small class="text-muted">
                        <i class="bi bi-signpost-2 me-1"></i>Paradas:
                        @foreach($trip->stops as $i => $stop)
                            {{ $stop->city }}{{ $i < $trip->stops->count() - 1 ? ' · ' : '' }}
                        @endforeach
                    </small>
                </div>
                @endif
                @empty
                <div class="alert alert-info text-center my-3">{{ __('messages.no_trips') }}</div>
                @endforelse

                <hr>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                        &larr; {{ __('messages.back') }}
                    </a>
                    <button id="continueBtn" class="btn btn-warning" disabled>
                        {{ __('messages.continue') }} &rarr;
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(function() {
    let selectedId = null;

    $('.trip-select').on('change', function() {
        selectedId = $(this).data('id');
        $('#continueBtn').prop('disabled', false);
    });

    $('#continueBtn').on('click', function() {
        if (selectedId) {
            window.location.href = '{{ url("elegir") }}/' + selectedId;
        }
    });
});
</script>
@endpush
