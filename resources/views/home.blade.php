@extends('layouts.app')

@section('title', __('messages.title'))
@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="mb-3 text-center">
                    <span class="badge bg-warning text-dark fs-6">
                        {{ __('messages.select_language') }}:
                        @foreach(['es' => 'es.png', 'en' => 'en.jpg', 'de' => 'de.jpg', 'fr' => 'fr.png'] as $code => $flag)
                            <a href="{{ route('locale.switch', $code) }}" class="text-dark text-decoration-none mx-1">
                                <img src="/images/{{ $flag }}" alt="{{ strtoupper($code) }}" height="15" width="20">
                            </a>
                        @endforeach
                    </span>
                </div>

                <form action="{{ route('search') }}" method="GET">
                    <div class="mb-3">
                        <label class="badge bg-warning text-dark w-100 mb-1">{{ __('messages.select_origin') }}</label>
                        <select name="origin" class="form-select" required>
                            <option value="">-- {{ __('messages.select_origin') }} --</option>
                            @foreach($cities as $city)
                                <option value="{{ $city }}">{{ $city }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="badge bg-warning text-dark w-100 mb-1">{{ __('messages.select_destination') }}</label>
                        <select name="destination" class="form-select" required>
                            <option value="">-- {{ __('messages.select_destination') }} --</option>
                            @foreach($cities as $city)
                                <option value="{{ $city }}">{{ $city }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="badge bg-warning text-dark w-100 mb-1">{{ __('messages.date_label') }}</label>
                        <input type="date" name="date" id="datepicker" class="form-control text-center"
                               value="{{ now()->format('Y-m-d') }}"
                               min="{{ now()->format('Y-m-d') }}">
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-warning btn-lg">
                            &#x1F50D; {{ __('messages.search') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(function() {
    $('#datepicker').val(new Date().toISOString().split('T')[0]);
});
</script>
@endpush
