@extends('layouts.app')

@section('title', __('messages.title3'))
@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="seat-card">
            <div class="seat-card-header">
                <div class="d-flex align-items-center gap-3">
                    <div class="header-icon">
                        <i class="bi bi-bus-front-fill"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold">{{ __('messages.select_seats') }}</h5>
                        <small class="opacity-75">{{ $trip->departure_city }} → {{ $trip->arrival_city }} · {{ $totalSeats }} asientos</small>
                    </div>
                </div>
            </div>
            <div class="seat-card-body">

                <div class="trip-bar">
                    <div class="trip-stop">
                        <div class="stop-dot origin"></div>
                        <div class="stop-info">
                            <span class="stop-label">{{ __('messages.from') }}</span>
                            <span class="stop-city">{{ $trip->departure_city }}</span>
                        </div>
                    </div>
                    @if($trip->stops->isNotEmpty())
                        @foreach($trip->stops as $stop)
                        <div class="trip-line" style="min-width:20px;">
                            <div class="trip-line-inner">
                                <i class="bi bi-chevron-right"></i>
                            </div>
                        </div>
                        <div class="trip-stop">
                            <div class="stop-dot" style="background:#94a3b8;box-shadow:0 0 0 3px rgba(148,163,184,.2);"></div>
                            <div class="stop-info">
                                <span class="stop-label">Parada</span>
                                <span class="stop-city">{{ $stop->city }}</span>
                            </div>
                        </div>
                        @endforeach
                    @endif
                    <div class="trip-line">
                        <div class="trip-line-inner">
                            <i class="bi bi-chevron-right"></i>
                        </div>
                    </div>
                    <div class="trip-stop">
                        <div class="stop-dot destination"></div>
                        <div class="stop-info">
                            <span class="stop-label">{{ __('messages.to') }}</span>
                            <span class="stop-city">{{ $trip->arrival_city }}</span>
                        </div>
                    </div>
                    <div class="trip-meta ms-auto text-end">
                        <div class="trip-date"><i class="bi bi-calendar3 me-1"></i>{{ $trip->departure_date->format('d/m/Y') }}</div>
                        <div class="trip-time"><i class="bi bi-clock me-1"></i>{{ substr($trip->departure_time, 0, 5) }}</div>
                    </div>
                </div>

                <div class="controls-bar">
                    <div class="d-flex align-items-center gap-3">
                        <label class="controls-label">{{ __('messages.select_ticket_count') }}</label>
                        <select id="num_boletos" class="modern-select">
                            @foreach(range(1, 5) as $i)
                                <option value="{{ $i }}">{{ $i }} {{ __($i === 1 ? 'messages.ticket_one' : 'messages.ticket_other') }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="legend">
                        <span class="legend-pill"><span class="lg-dot lg-available"></span>{{ __('messages.seat_available') }}</span>
                        <span class="legend-pill"><span class="lg-dot lg-selected"></span>{{ __('messages.seat_selected') }}</span>
                        <span class="legend-pill"><span class="lg-dot lg-occupied"></span>{{ __('messages.seat_occupied') }}</span>
                    </div>
                </div>

                @if($decks > 1)
                <div class="deck-tabs mb-3">
                    @foreach($seatDecks as $deckNum => $deckSeats)
                    <button type="button" class="deck-tab {{ $deckNum === 1 ? 'active' : '' }}" data-deck="{{ $deckNum }}">
                        <i class="bi bi-layers-fill me-1"></i> Piso {{ $deckNum }}
                    </button>
                    @endforeach
                </div>
                @endif

                @foreach($seatDecks as $deckNum => $columns)
                <div class="deck-container {{ $deckNum === 1 ? 'active' : '' }}" id="deck-{{ $deckNum }}">
                    <div class="bus-scroll">
                        <div class="bus">
                            <div class="bus-nose">
                                <div class="nose-inner">
                                    <div class="windshield"></div>
                                    <div class="headlight"></div>
                                </div>
                            </div>

                            <div class="bus-cabin">
                                <div class="cabin-row">
                                    @foreach($columns as $colSeats)
                                    <div class="bus-col">
                                        @foreach($colSeats as $idx => $seatNum)
                                            @if($idx < 2)
                                                @if($seatNum !== null)
                                                    @php $isOccupied = in_array((int)$seatNum, $occupiedSeats); @endphp
                                                    <div class="seat {{ $isOccupied ? 'occupied' : 'available' }}"
                                                         @unless($isOccupied) data-seat="{{ $seatNum }}" id="seat-{{ $seatNum }}" @endunless>
                                                        <span class="seat-num">{{ str_pad($seatNum, 2, '0', STR_PAD_LEFT) }}</span>
                                                    </div>
                                                @else
                                                    <div class="seat-placeholder"></div>
                                                @endif
                                            @endif
                                        @endforeach
                                    </div>
                                    @endforeach
                                </div>
                                <div class="bus-aisle-row"><span class="aisle-text">{{ __('messages.aisle') }}</span></div>
                                <div class="cabin-row">
                                    @foreach($columns as $colSeats)
                                    <div class="bus-col">
                                        @foreach($colSeats as $idx => $seatNum)
                                            @if($idx >= 2)
                                                @if($seatNum !== null)
                                                    @php $isOccupied = in_array((int)$seatNum, $occupiedSeats); @endphp
                                                    <div class="seat {{ $isOccupied ? 'occupied' : 'available' }}"
                                                         @unless($isOccupied) data-seat="{{ $seatNum }}" id="seat-{{ $seatNum }}" @endunless>
                                                        <span class="seat-num">{{ str_pad($seatNum, 2, '0', STR_PAD_LEFT) }}</span>
                                                    </div>
                                                @else
                                                    <div class="seat-placeholder"></div>
                                                @endif
                                            @endif
                                        @endforeach
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="bus-tail">
                                <div class="taillight"></div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

                <div id="selectedSummary" class="selection-summary"></div>

                <form id="purchaseForm" action="{{ route('purchase') }}" method="POST">
                    @csrf
                    <input type="hidden" name="trip_id" value="{{ $trip->id }}">
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">{{ __('messages.email') }}</label>
                        <input type="email" name="email" class="form-control form-control-sm"
                               placeholder="{{ __('messages.email_placeholder') }}" required maxlength="120">
                    </div>
                    <div id="passengerFields"></div>

                    <div class="action-bar">
                        <a href="{{ route('home') }}" class="btn-back">
                            <i class="bi bi-arrow-left"></i> {{ __('messages.back') }}
                        </a>
                        <button type="submit" class="btn-continue" id="continueBtn" disabled>
                            {{ __('messages.continue') }} <i class="bi bi-arrow-right"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

.seat-card { background: #fff; border-radius: 20px; box-shadow: 0 4px 24px rgba(0,0,0,.08), 0 1px 2px rgba(0,0,0,.04); overflow: hidden; border: 1px solid rgba(0,0,0,.04); }
.seat-card-header { background: linear-gradient(135deg, var(--brand-primary, #f59e0b), #d97706); color: #fff; padding: 1.25rem 1.5rem; }
.header-icon { width: 44px; height: 44px; background: rgba(255,255,255,.2); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; backdrop-filter: blur(4px); }
.seat-card-body { padding: 1.5rem; }

.trip-bar { display: flex; align-items: center; gap: 1rem; background: #f8fafc; border-radius: 14px; padding: .85rem 1.25rem; margin-bottom: 1.25rem; border: 1px solid #e2e8f0; }
.trip-stop { display: flex; align-items: center; gap: .6rem; }
.stop-dot { width: 12px; height: 12px; border-radius: 50%; flex-shrink: 0; }
.stop-dot.origin { background: var(--brand-accent, #3b82f6); box-shadow: 0 0 0 3px rgba(59,130,246,.2); }
.stop-dot.destination { background: #ef4444; box-shadow: 0 0 0 3px rgba(239,68,68,.2); }
.stop-label { font-size: .6rem; text-transform: uppercase; letter-spacing: .5px; color: #94a3b8; display: block; }
.stop-city { font-size: .85rem; font-weight: 600; color: #1e293b; display: block; }
.trip-line { flex: 1; height: 2px; background: #e2e8f0; position: relative; min-width: 40px; }
.trip-line-inner { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: #94a3b8; font-size: .7rem; background: #f8fafc; padding: 0 4px; }
.trip-meta { flex-shrink: 0; }
.trip-date, .trip-time { font-size: .8rem; font-weight: 600; color: #334155; }

.controls-bar { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: .75rem; margin-bottom: 1.25rem; }
.controls-label { font-size: .75rem; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: .5px; }
.modern-select { appearance: none; background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%2364748b' d='M2 4l4 4 4-4'/%3E%3C/svg%3E") no-repeat right 10px center; border: 1.5px solid #e2e8f0; border-radius: 10px; padding: .45rem 2rem .45rem .75rem; font-size: .85rem; font-weight: 500; color: #1e293b; cursor: pointer; transition: border-color .15s; }
.modern-select:focus { outline: none; border-color: var(--brand-accent, #3b82f6); box-shadow: 0 0 0 3px rgba(59,130,246,.12); }

.legend { display: flex; gap: .75rem; }
.legend-pill { display: inline-flex; align-items: center; gap: 5px; font-size: .7rem; color: #64748b; font-weight: 500; }
.lg-dot { width: 10px; height: 10px; border-radius: 3px; }
.lg-available { background: #bbf7d0; border: 1.5px solid #4ade80; }
.lg-selected  { background: var(--brand-primary, #fbbf24); border: 1.5px solid #f59e0b; }
.lg-occupied  { background: #e2e8f0; border: 1.5px solid #cbd5e1; }

.deck-tabs { display: flex; gap: .5rem; justify-content: center; }
.deck-tab { padding: .5rem 1.5rem; border: 2px solid #e2e8f0; border-radius: 10px; background: #fff; font-size: .85rem; font-weight: 600; color: #64748b; cursor: pointer; transition: all .15s; }
.deck-tab:hover { border-color: #cbd5e1; color: #334155; }
.deck-tab.active { background: var(--brand-accent, #3b82f6); color: #fff; border-color: var(--brand-accent, #3b82f6); }

.deck-container { display: none; }
.deck-container.active { display: block; }

.bus-scroll { overflow-x: auto; padding: .5rem 0 1rem; display: flex; justify-content: center; }
.bus { display: flex; align-items: stretch; flex-shrink: 0; }

.bus-nose { width: 40px; background: linear-gradient(180deg, #475569, #334155); border-radius: 16px 0 0 16px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.nose-inner { display: flex; flex-direction: column; align-items: center; gap: 6px; }
.windshield { width: 20px; height: 28px; background: linear-gradient(180deg, rgba(148,163,184,.3), rgba(148,163,184,.1)); border-radius: 6px 6px 3px 3px; border: 1px solid rgba(255,255,255,.08); }
.headlight { width: 8px; height: 8px; background: #fbbf24; border-radius: 50%; box-shadow: 0 0 6px rgba(251,191,36,.6); }

.bus-cabin { background: linear-gradient(180deg, #f1f5f9, #e2e8f0); border-top: 3px solid #334155; border-bottom: 3px solid #334155; display: flex; flex-direction: column; }

.cabin-row { display: flex; }

.bus-col { display: flex; flex-direction: column; align-items: center; gap: 3px; padding: 4px 3px; }

.bus-aisle-row { width: 100%; height: 20px; display: flex; align-items: center; justify-content: center; border-top: 1px dashed #cbd5e1; border-bottom: 1px dashed #cbd5e1; background: linear-gradient(180deg, #f1f5f9, #e2e8f0); }
.aisle-text { font-size: .5rem; font-weight: 700; letter-spacing: 1px; color: #94a3b8; text-transform: uppercase; }

.bus-tail { width: 22px; background: linear-gradient(180deg, #475569, #334155); border-radius: 0 12px 12px 0; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.taillight { width: 6px; height: 18px; background: linear-gradient(180deg, #f87171, #ef4444); border-radius: 3px; box-shadow: 0 0 8px rgba(239,68,68,.5); }

.seat { width: 30px; height: 22px; border-radius: 5px 5px 3px 3px; display: flex; align-items: center; justify-content: center; user-select: none; transition: all .18s cubic-bezier(.4,0,.2,1); cursor: default; flex-shrink: 0; position: relative; }
.seat-num { font-size: .55rem; font-weight: 700; line-height: 1; }

.seat.available { background: linear-gradient(180deg, #dcfce7, #bbf7d0); border: 1.5px solid #86efac; color: #166534; cursor: pointer; box-shadow: 0 1px 2px rgba(0,0,0,.05); }
.seat.available:hover { background: linear-gradient(180deg, #bbf7d0, #86efac); transform: translateY(-2px) scale(1.08); box-shadow: 0 4px 12px rgba(74,222,128,.35); }

.seat.selected { background: linear-gradient(180deg, var(--brand-primary, #fbbf24), #f59e0b); border: 1.5px solid #d97706; color: #78350f; transform: translateY(-2px) scale(1.08); box-shadow: 0 4px 14px rgba(245,158,11,.4); }
.seat.selected::after { content: '\2713'; position: absolute; top: -4px; right: -4px; width: 12px; height: 12px; background: #fff; border-radius: 50%; font-size: .45rem; display: flex; align-items: center; justify-content: center; color: #166534; box-shadow: 0 1px 3px rgba(0,0,0,.15); }

.seat.occupied { background: linear-gradient(180deg, #f1f5f9, #e2e8f0); border: 1.5px solid #cbd5e1; color: #94a3b8; cursor: not-allowed; }

.seat-placeholder { width: 30px; height: 22px; }

.selection-summary { text-align: center; font-size: .8rem; color: #64748b; min-height: 24px; margin-bottom: .5rem; font-weight: 500; }

.action-bar { display: flex; justify-content: space-between; align-items: center; padding-top: 1rem; border-top: 1px solid #f1f5f9; margin-top: .5rem; }
.btn-back { display: inline-flex; align-items: center; gap: .4rem; padding: .55rem 1.1rem; border-radius: 10px; font-size: .85rem; font-weight: 500; color: #64748b; text-decoration: none; border: 1.5px solid #e2e8f0; background: #fff; transition: all .15s; }
.btn-back:hover { background: #f8fafc; border-color: #cbd5e1; color: #334155; }
.btn-continue { display: inline-flex; align-items: center; gap: .4rem; padding: .55rem 1.4rem; border-radius: 10px; font-size: .85rem; font-weight: 600; color: #fff; border: none; background: linear-gradient(135deg, var(--brand-accent, #3b82f6), #2563eb); cursor: pointer; transition: all .18s; box-shadow: 0 2px 8px rgba(37,99,235,.25); }
.btn-continue:hover:not(:disabled) { transform: translateY(-1px); box-shadow: 0 4px 14px rgba(37,99,235,.35); }
.btn-continue:disabled { opacity: .45; cursor: not-allowed; box-shadow: none; }

.passenger-row { display: flex; align-items: center; gap: .75rem; padding: .6rem .8rem; background: #f8fafc; border-radius: 10px; margin-bottom: .5rem; border: 1px solid #e2e8f0; }
.passenger-seat { font-size: .75rem; font-weight: 700; color: var(--brand-accent, #3b82f6); min-width: 42px; }
.passenger-input { flex: 1; border: 1.5px solid #e2e8f0; border-radius: 8px; padding: .4rem .7rem; font-size: .8rem; color: #1e293b; transition: border-color .15s; }
.passenger-input:focus { outline: none; border-color: var(--brand-accent, #3b82f6); box-shadow: 0 0 0 3px rgba(59,130,246,.1); }
</style>
@endsection

@push('scripts')
<script>
pushGA4Event('view_seat_selection', {
    trip_id: {{ $trip->id }},
    origin: '{{ $trip->departure_city }}',
    destination: '{{ $trip->arrival_city }}',
    date: '{{ $trip->departure_date->format('Y-m-d') }}',
    time: '{{ substr($trip->departure_time, 0, 5) }}',
    price: {{ $trip->price }},
    available_seats: {{ $totalSeats - count($occupiedSeats) }}
});

$(function() {
    let selectedSeats = [];
    let maxSeats = parseInt($('#num_boletos').val());

    function updateUI() {
        const disabled = selectedSeats.length !== maxSeats;
        $('#continueBtn').prop('disabled', disabled);

        let html = '';
        let summary = [];
        selectedSeats.forEach(function(seat) {
            summary.push('#' + seat);
            html += '<div class="passenger-row">';
            html += '<span class="passenger-seat">{{ __("messages.seat") }} ' + seat + '</span>';
            html += '<input type="hidden" name="seats[]" value="' + seat + '">';
            html += '<input type="text" name="names[]" class="passenger-input"';
            html += ' placeholder="{{ __("messages.passenger_name") }}" required maxlength="65">';
            html += '</div>';
        });
        $('#passengerFields').html(html);
        $('#selectedSummary').text(summary.length ? summary.join('  ·  ') : '');
    }

    $(document).on('click', '.seat.available', function() {
        const seat = $(this).data('seat');
        if ($(this).hasClass('selected')) {
            $(this).removeClass('selected').addClass('available');
            selectedSeats = $.grep(selectedSeats, function(s) { return s !== seat; });
        } else {
            if (selectedSeats.length >= maxSeats) return;
            $(this).removeClass('available').addClass('selected');
            selectedSeats.push(seat);
        }
        updateUI();
    });

    $('#num_boletos').on('change', function() {
        maxSeats = parseInt($(this).val());
        while (selectedSeats.length > maxSeats) {
            const removed = selectedSeats.pop();
            $('[data-seat="' + removed + '"]').removeClass('selected').addClass('available');
        }
        updateUI();
    });

    $('.deck-tab').on('click', function() {
        $('.deck-tab').removeClass('active');
        $(this).addClass('active');
        const deck = $(this).data('deck');
        $('.deck-container').removeClass('active');
        $('#deck-' + deck).addClass('active');
    });
});
</script>
@endpush
