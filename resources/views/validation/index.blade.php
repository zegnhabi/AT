@extends('layouts.app')

@section('title', __('messages.validation_title'))
@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-warning text-dark fw-bold text-center">
                <i class="bi bi-qr-code-scan"></i> {{ __('messages.validation_title') }}
            </div>
            <div class="card-body">
                <p class="text-muted text-center mb-4">{{ __('messages.validation_help') }}</p>

                <form action="{{ route('validation.validate') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold">{{ __('messages.validation_folio_label') }}</label>
                        <input type="number" name="folio" class="form-control form-control-lg text-center"
                               placeholder="{{ __('messages.validation_folio_placeholder') }}"
                               required autofocus min="1">
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-warning btn-lg">
                            <i class="bi bi-check-circle"></i> {{ __('messages.validation_verify') }}
                        </button>
                    </div>
                </form>

                <hr class="my-4">

                <div class="text-center">
                    <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-house"></i> {{ __('messages.home') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
