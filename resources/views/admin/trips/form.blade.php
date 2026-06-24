@extends('admin.layouts.app')

@php $isEdit = $trip !== null; @endphp

@section('title', $isEdit ? __('messages.admin_trip_form_edit_title') : __('messages.admin_trip_form_new_title'))
@section('content')
<div class="page-title">
    <i class="bi bi-ticket-perforated-fill"></i>
    {{ $isEdit ? __('messages.admin_trip_form_edit_heading') : __('messages.admin_trip_form_new_heading') }}
</div>

<form action="{{ $isEdit ? route('admin.trips.update', $trip) : route('admin.trips.store') }}" method="POST" id="tripForm">
    @csrf
    @if($isEdit) @method('PUT') @endif

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card card-admin">
                <div class="card-header bg-white"><i class="bi bi-geo-alt text-primary me-1"></i> {{ __('messages.admin_trip_form_route_header') }}</div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">{{ __('messages.admin_trip_form_bus_label') }} *</label>
                            <select name="bus_id" class="form-select form-admin @error('bus_id') is-invalid @enderror" required>
                                <option value="">{{ __('messages.admin_trip_form_bus_placeholder') }}</option>
                                @foreach($buses as $b)
                                    <option value="{{ $b->id }}" @selected(old('bus_id', $trip->bus_id ?? '') == $b->id)>
                                        #{{ $b->id }} — {{ $b->seat_count }} {{ __('messages.admin_trip_form_seats') }}, {{ $b->decks }} {{ __('messages.admin_trip_form_decks') }} {{ $b->driver ? '· '.$b->driver->name : '' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('bus_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">{{ __('messages.admin_trip_form_departure_date_label') }} *</label>
                            <input type="date" name="departure_date" class="form-control form-admin @error('departure_date') is-invalid @enderror"
                                   value="{{ old('departure_date', $trip->departure_date ?? now()->format('Y-m-d')) }}" required>
                            @error('departure_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">{{ __('messages.admin_trip_form_departure_time_label') }} *</label>
                            <input type="time" name="departure_time" class="form-control form-admin @error('departure_time') is-invalid @enderror"
                                   value="{{ old('departure_time', $trip ? substr($trip->departure_time, 0, 5) : '') }}" required>
                            @error('departure_time') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">{{ __('messages.admin_trip_form_departure_city_label') }} *</label>
                            <input type="text" name="departure_city" class="form-control form-admin @error('departure_city') is-invalid @enderror"
                                   value="{{ old('departure_city', $departureCity ?? $trip->departure_city ?? '') }}" required maxlength="45">
                            @error('departure_city') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">{{ __('messages.admin_trip_form_departure_terminal_label') }} *</label>
                            <input type="text" name="departure_terminal" class="form-control form-admin @error('departure_terminal') is-invalid @enderror"
                                   value="{{ old('departure_terminal', $trip->departure_terminal ?? '') }}" required maxlength="50">
                            @error('departure_terminal') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">{{ __('messages.admin_trip_form_price_label') }} *</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" name="price" class="form-control form-admin @error('price') is-invalid @enderror"
                                       value="{{ old('price', $trip->price ?? '') }}" required min="0" step="0.01">
                            </div>
                            @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12"><hr class="my-1"></div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">{{ __('messages.admin_trip_form_arrival_city_label') }} *</label>
                            <input type="text" name="arrival_city" class="form-control form-admin @error('arrival_city') is-invalid @enderror"
                                   value="{{ old('arrival_city', $trip->arrival_city ?? '') }}" required maxlength="45">
                            @error('arrival_city') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">{{ __('messages.admin_trip_form_arrival_terminal_label') }} *</label>
                            <input type="text" name="arrival_terminal" class="form-control form-admin @error('arrival_terminal') is-invalid @enderror"
                                   value="{{ old('arrival_terminal', $trip->arrival_terminal ?? '') }}" required maxlength="50">
                            @error('arrival_terminal') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-semibold">{{ __('messages.admin_trip_form_arrival_date_label') }} *</label>
                            <input type="date" name="arrival_date" class="form-control form-admin @error('arrival_date') is-invalid @enderror"
                                   value="{{ old('arrival_date', $trip->arrival_date ?? now()->format('Y-m-d')) }}" required>
                            @error('arrival_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-semibold">{{ __('messages.admin_trip_form_arrival_time_label') }} *</label>
                            <input type="time" name="arrival_time" class="form-control form-admin @error('arrival_time') is-invalid @enderror"
                                   value="{{ old('arrival_time', $trip ? substr($trip->arrival_time, 0, 5) : '') }}" required>
                            @error('arrival_time') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card card-admin">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-signpost-split text-primary me-1"></i> {{ __('messages.admin_trip_form_stops_header') }}</span>
                    <button type="button" class="btn btn-sm btn-admin-primary" id="addStopBtn">
                        <i class="bi bi-plus-lg"></i> {{ __('messages.admin_trip_form_add_stop') }}
                    </button>
                </div>
                <div class="card-body p-3" id="stopsContainer">
                    @php $oldStops = old('stops', $trip?->stops?->toArray() ?? []); @endphp
                    @forelse($oldStops as $i => $stop)
                    <div class="stop-item border rounded p-3 mb-3 bg-light">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="badge bg-secondary">{{ __('messages.admin_trip_form_stop_label') }} {{ $i + 1 }}</span>
                            <button type="button" class="btn btn-sm btn-outline-danger remove-stop-btn"><i class="bi bi-x-lg"></i></button>
                        </div>
                        <div class="row g-2">
                            <div class="col-12">
                                <label class="form-label small fw-semibold">{{ __('messages.admin_trip_form_stop_city') }}</label>
                                <input type="text" name="stops[{{ $i }}][city]" class="form-control form-admin-sm"
                                       value="{{ $stop['city'] ?? '' }}" maxlength="45" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-semibold">{{ __('messages.admin_trip_form_stop_terminal') }}</label>
                                <input type="text" name="stops[{{ $i }}][terminal]" class="form-control form-admin-sm"
                                       value="{{ $stop['terminal'] ?? '' }}" maxlength="50" required>
                            </div>
                            <div class="col-6">
                                <label class="form-label small fw-semibold">{{ __('messages.admin_trip_form_stop_arrival_time') }}</label>
                                <input type="time" name="stops[{{ $i }}][arrival_time]" class="form-control form-admin-sm"
                                       value="{{ $stop['arrival_time'] ?? '' }}">
                            </div>
                            <div class="col-6">
                                <label class="form-label small fw-semibold">{{ __('messages.admin_trip_form_stop_departure_time') }}</label>
                                <input type="time" name="stops[{{ $i }}][departure_time]" class="form-control form-admin-sm"
                                       value="{{ $stop['departure_time'] ?? '' }}">
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center text-muted py-3" id="noStopsMsg">
                        <i class="bi bi-signpost-2" style="font-size:1.5rem;"></i>
                        <div class="mt-1 small">{{ __('messages.admin_trip_form_no_stops') }}</div>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4 pt-3 border-top">
        <button class="btn btn-admin-primary"><i class="bi bi-check-lg"></i> {{ __('messages.admin_save') }}</button>
        <a href="{{ route('admin.trips.index') }}" class="btn btn-admin-outline ms-2">{{ __('messages.admin_cancel') }}</a>
    </div>
</form>

<template id="stopTemplate">
    <div class="stop-item border rounded p-3 mb-3 bg-light">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <span class="badge bg-secondary stop-label">{{ __('messages.admin_trip_form_stop_label') }}</span>
            <button type="button" class="btn btn-sm btn-outline-danger remove-stop-btn"><i class="bi bi-x-lg"></i></button>
        </div>
        <div class="row g-2">
            <div class="col-12">
                <label class="form-label small fw-semibold">{{ __('messages.admin_trip_form_stop_city') }}</label>
                <input type="text" name="__NAME__[city]" class="form-control form-admin-sm" maxlength="45" required>
            </div>
            <div class="col-12">
                <label class="form-label small fw-semibold">{{ __('messages.admin_trip_form_stop_terminal') }}</label>
                <input type="text" name="__NAME__[terminal]" class="form-control form-admin-sm" maxlength="50" required>
            </div>
            <div class="col-6">
                <label class="form-label small fw-semibold">{{ __('messages.admin_trip_form_stop_arrival_time') }}</label>
                <input type="time" name="__NAME__[arrival_time]" class="form-control form-admin-sm">
            </div>
            <div class="col-6">
                <label class="form-label small fw-semibold">{{ __('messages.admin_trip_form_stop_departure_time') }}</label>
                <input type="time" name="__NAME__[departure_time]" class="form-control form-admin-sm">
            </div>
        </div>
    </div>
</template>

@push('scripts')
<script>
    const stopLabel = '{{ __('messages.admin_trip_form_stop_label') }}';
    const noStopsMsg = '{{ __('messages.admin_trip_form_no_stops') }}';

$(function() {
    let stopIndex = {{ count($oldStops) }};

    function renumberStops() {
        $('#stopsContainer .stop-item').each(function(i) {
            $(this).find('.stop-label').text(stopLabel + ' ' + (i + 1));
        });
    }

    $('#addStopBtn').on('click', function() {
        $('#noStopsMsg').remove();
        const html = $('#stopTemplate').html().replace(/__NAME__/g, 'stops[' + stopIndex + ']');
        const $stop = $(html);
        $stop.find('.stop-label').text(stopLabel + ' ' + (stopIndex + 1));
        $('#stopsContainer').append($stop);
        stopIndex++;
    });

    $(document).on('click', '.remove-stop-btn', function() {
        $(this).closest('.stop-item').remove();
        renumberStops();
        if ($('#stopsContainer .stop-item').length === 0) {
            $('#stopsContainer').html('<div class="text-center text-muted py-3" id="noStopsMsg"><i class="bi bi-signpost-2" style="font-size:1.5rem;"></i><div class="mt-1 small">' + noStopsMsg + '</div></div>');
        }
    });
});
</script>
@endpush

<style>
.form-admin-sm {
    font-size: .82rem;
    padding: .3rem .55rem;
}
</style>
@endsection
