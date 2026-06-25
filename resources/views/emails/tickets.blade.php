<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><style>body{font-family:DejaVu Sans,sans-serif;color:#333;line-height:1.4}.header{text-align:center;border-bottom:2px solid #f59e0b;padding-bottom:10px;margin-bottom:20px}.header h1{font-size:18px;margin:0;color:#1a202c}.header p{font-size:13px;color:#666;margin:4px 0 0}.ticket{border:1px solid #ddd;border-radius:8px;padding:12px;margin-bottom:12px;page-break-inside:avoid}.ticket h3{margin:0 0 8px;font-size:14px;color:#f59e0b}.info{font-size:12px;margin:2px 0}.label{color:#888}.qr{text-align:center;margin-top:8px}.footer{text-align:center;font-size:11px;color:#999;border-top:1px solid #eee;padding-top:10px;margin-top:20px}</style></head>
<body>
<div class="header">
    <h1>{{ __('messages.company') }}</h1>
    <p>{{ __('messages.email_greeting') }}</p>
</div>

@foreach($tickets as $ticket)
<div class="ticket">
    <h3>{{ __('messages.ticket') }} #{{ $ticket['folio'] }}</h3>
    <div class="info"><span class="label">{{ __('messages.origin') }}:</span> {{ $ticket['trip']->departure_city }} ({{ $ticket['trip']->departure_terminal }})</div>
    <div class="info"><span class="label">{{ __('messages.destination') }}:</span> {{ $ticket['trip']->arrival_city }} ({{ $ticket['trip']->arrival_terminal }})</div>
    <div class="info"><span class="label">{{ __('messages.departure_date') }}</span> {{ $ticket['trip']->departure_date->format('d-m-Y') }} {{ substr($ticket['trip']->departure_time, 0, 5) }}</div>
    <div class="info"><span class="label">{{ __('messages.seat') }}</span> {{ $ticket['seat'] }}</div>
    <div class="info"><span class="label">{{ __('messages.name') }}</span> {{ $ticket['name'] }}</div>
    <div class="info"><span class="label">{{ __('messages.fare') }}</span> ${{ number_format($ticket['trip']->price, 2) }}</div>
    <div class="qr"><img src="data:image/svg+xml;base64,{{ $ticket['qrCode'] }}" alt="QR" style="width:100px;height:100px;"></div>
</div>
@endforeach

<div class="footer">
    {{ __('messages.email_footer') }}<br>
    {{ $today }}
</div>
</body>
</html>
