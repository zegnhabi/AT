@extends('admin.layouts.app')

@section('title', $bus->exists ? 'Editar Autobús' : 'Nuevo Autobús')
@section('content')
<div class="page-title">
    <i class="bi bi-truck-front-fill"></i>
    {{ $bus->exists ? 'Editar autobús' : 'Nuevo autobús' }}
</div>

<div class="card card-admin">
    <div class="card-body p-4">
        <form action="{{ $bus->exists ? route('admin.buses.update', $bus) : route('admin.buses.store') }}" method="POST">
            @csrf
            @if($bus->exists) @method('PUT') @endif

            <div class="row g-4">
                <div class="col-md-3">
                    <label class="form-label fw-semibold"><i class="bi bi-grid-3x3 text-primary me-1"></i>Asientos *</label>
                    <input type="number" name="seat_count" class="form-control form-admin @error('seat_count') is-invalid @enderror"
                           value="{{ old('seat_count', $bus->seat_count) }}" required min="1" max="100">
                    @error('seat_count') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold"><i class="bi bi-calendar-range text-primary me-1"></i>Año modelo</label>
                    <input type="number" name="model_year" class="form-control form-admin @error('model_year') is-invalid @enderror"
                           value="{{ old('model_year', $bus->model_year) }}" min="1990" max="{{ now()->year + 1 }}">
                    @error('model_year') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold"><i class="bi bi-upc-scan text-primary me-1"></i>N° Serie</label>
                    <input type="text" name="serial_number" class="form-control form-admin @error('serial_number') is-invalid @enderror"
                           value="{{ old('serial_number', $bus->serial_number) }}" maxlength="20">
                    @error('serial_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold"><i class="bi bi-person-badge text-primary me-1"></i>Chofer</label>
                    <select name="driver_id" class="form-select form-admin">
                        <option value="">— Sin asignar —</option>
                        @foreach($drivers as $d)
                            <option value="{{ $d->id }}" @selected(old('driver_id', $bus->driver_id) == $d->id)>{{ $d->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mt-4 pt-3 border-top">
                <button class="btn btn-admin-primary"><i class="bi bi-check-lg"></i> Guardar</button>
                <a href="{{ route('admin.buses.index') }}" class="btn btn-admin-outline ms-2">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
