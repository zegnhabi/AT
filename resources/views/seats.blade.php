@extends('layouts.app')

@section('title', __('messages.title3'))
@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-warning text-dark fw-bold">
                {{ __('messages.select_seats') }}
            </div>
            <div class="card-body">
                <div class="row text-center small fw-bold text-muted text-uppercase mb-2">
                    <div class="col-3">{{ __('messages.date_label') }}</div>
                    <div class="col-3">{{ __('messages.time') }}</div>
                    <div class="col-3">{{ __('messages.from') }}</div>
                    <div class="col-3">{{ __('messages.to') }}</div>
                </div>
                <div class="row text-center fw-semibold mb-3">
                    <div class="col-3">{{ $trip->departure_date->format('d-m-Y') }}</div>
                    <div class="col-3">{{ substr($trip->departure_time, 0, 5) }}</div>
                    <div class="col-3">{{ $trip->departure_city }}</div>
                    <div class="col-3">{{ $trip->arrival_city }}</div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="fw-semibold">{{ __('messages.select_ticket_count') }}</label>
                        <select id="num_boletos" class="form-select">
                            @foreach(range(1, 5) as $i)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="d-flex flex-column align-items-center mb-3">
                    <div class="mb-2">
                        <img src="/images/bus_top.gif" alt="Front" style="height:130px;">
                    </div>

                    @foreach($seatRows as $rowSeats)
                    <div class="d-flex justify-content-center" style="gap:3px;">
                        @foreach($rowSeats as $seatCode)
                            @php
                                $seatNumber = (int) substr($seatCode, 2);
                                $isOccupied = in_array($seatNumber, $occupiedSeats);
                            @endphp
                            @if($isOccupied)
                                <img src="/images/ocupado.gif" class="seat-occupied"
                                     style="width:35px;height:24px;"
                                     alt="{{ __('messages.seat_occupied') }}" title="{{ __('messages.seat_occupied') }}">
                            @else
                                <img src="/images/{{ $seatCode }}.jpg"
                                     class="seat-available seat-img cursor-pointer"
                                     id="{{ $seatCode }}" data-seat="{{ $seatNumber }}"
                                     style="width:35px;height:24px;"
                                     alt="{{ __('messages.seat_available') }} {{ $seatNumber }}"
                                     title="{{ __('messages.seat_available') }} {{ $seatNumber }}">
                            @endif
                        @endforeach
                    </div>
                    @endforeach

                    <div class="mt-2">
                        <img src="/images/bus_back.gif" alt="Back" style="height:130px;">
                    </div>
                </div>

                <div class="text-center mb-3 small">
                    <img src="/images/ocupado.gif" class="me-1">{{ __('messages.seat_occupied') }}
                    <img src="/images/asientoNormal.gif" class="ms-3 me-1">{{ __('messages.seat_available') }}
                    <img src="/images/seleccionado.gif" class="ms-3 me-1">{{ __('messages.seat_selected') }}
                </div>

                <form id="purchaseForm" action="{{ route('purchase') }}" method="POST">
                    @csrf
                    <input type="hidden" name="trip_id" value="{{ $trip->id }}">
                    <div id="passengerFields"></div>

                    <div class="d-flex justify-content-between mt-3">
                        <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                            &larr; {{ __('messages.back') }}
                        </a>
                        <button type="submit" class="btn btn-warning" id="continueBtn" disabled>
                            {{ __('messages.continue') }} &rarr;
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.seat-available { cursor: pointer; }
.seat-occupied { opacity: 0.6; cursor: not-allowed; }
.seat-selected { outline: 3px solid #ffc107; outline-offset: -1px; border-radius: 2px; }
</style>
@endsection

@push('scripts')
<script>
$(function() {
    let selectedSeats = [];
    let maxSeats = parseInt($('#num_boletos').val());

    function updatePassengerFields() {
        const disabled = selectedSeats.length !== maxSeats;
        $('#continueBtn').prop('disabled', disabled);

        let html = '';
        selectedSeats.forEach(function(seat) {
            html += '<div class="row mb-2 align-items-center">';
            html += '<div class="col-3 fw-semibold">' + '{{ __('messages.seat') }}' + ' ' + seat + '</div>';
            html += '<div class="col-9">';
            html += '<input type="hidden" name="seats[]" value="' + seat + '">';
            html += '<input type="text" name="names[]" class="form-control"';
            html += ' placeholder="{{ __('messages.passenger_name') }}" required maxlength="65">';
            html += '</div></div>';
        });
        $('#passengerFields').html(html);
    }

    $(document).on('click', '.seat-available', function() {
        const seat = $(this).data('seat');
        const $img = $(this);

        if ($img.hasClass('seat-selected')) {
            $img.removeClass('seat-selected').attr('src', '/images/as' + String(seat).padStart(2, '0') + '.jpg');
            selectedSeats = $.grep(selectedSeats, function(s) { return s !== seat; });
        } else {
            if (selectedSeats.length >= maxSeats) return;
            $img.addClass('seat-selected').attr('src', '/images/seleccionado.gif');
            selectedSeats.push(seat);
        }
        updatePassengerFields();
    });

    $('#num_boletos').on('change', function() {
        maxSeats = parseInt($(this).val());
        while (selectedSeats.length > maxSeats) {
            const removed = selectedSeats.pop();
            const $img = $('[data-seat="' + removed + '"]');
            $img.removeClass('seat-selected').attr('src', '/images/as' + String(removed).padStart(2, '0') + '.jpg');
        }
        updatePassengerFields();
    });
});
</script>
@endpush
