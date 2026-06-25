@extends('layouts.app')

@section('title', __('messages.error_404_title') ?: '404 - Página no encontrada')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-6 text-center py-5">
        <h1 class="display-1 fw-bold text-muted">404</h1>
        <p class="fs-5 text-secondary">{{ __('messages.error_404_message') ?: 'La página que buscas no existe.' }}</p>
        <a href="{{ route('home') }}" class="btn btn-warning mt-3">{{ __('messages.home') }}</a>
    </div>
</div>
@endsection
