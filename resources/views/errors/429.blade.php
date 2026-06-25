@extends('layouts.app')

@section('title', __('messages.error_429_title') ?: '429 - Demasiadas solicitudes')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-6 text-center py-5">
        <h1 class="display-1 fw-bold text-muted">429</h1>
        <p class="fs-5 text-secondary">{{ __('messages.error_429_message') ?: 'Has hecho demasiadas solicitudes. Intenta de nuevo más tarde.' }}</p>
        <a href="{{ route('home') }}" class="btn btn-warning mt-3">{{ __('messages.home') }}</a>
    </div>
</div>
@endsection
