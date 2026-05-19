@extends('admin.layouts.app')

@section('title', $driver->exists ? 'Editar Chofer' : 'Nuevo Chofer')
@section('content')
<div class="page-title">
    <i class="bi bi-people-fill"></i>
    {{ $driver->exists ? 'Editar chofer' : 'Nuevo chofer' }}
</div>

<div class="card card-admin">
    <div class="card-body p-4">
        <form action="{{ $driver->exists ? route('admin.drivers.update', $driver) : route('admin.drivers.store') }}" method="POST">
            @csrf
            @if($driver->exists) @method('PUT') @endif

            <div class="row g-4">
                <div class="col-md-6">
                    <label class="form-label fw-semibold"><i class="bi bi-person text-primary me-1"></i>Nombre *</label>
                    <input type="text" name="name" class="form-control form-admin @error('name') is-invalid @enderror"
                           value="{{ old('name', $driver->name) }}" required maxlength="65">
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold"><i class="bi bi-gender-ambiguous text-primary me-1"></i>Género</label>
                    <select name="gender" class="form-select form-admin">
                        <option value="">— Seleccionar —</option>
                        <option value="M" @selected(old('gender', $driver->gender) === 'M')>Masculino</option>
                        <option value="F" @selected(old('gender', $driver->gender) === 'F')>Femenino</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold"><i class="bi bi-calendar text-primary me-1"></i>Edad</label>
                    <input type="number" name="age" class="form-control form-admin @error('age') is-invalid @enderror"
                           value="{{ old('age', $driver->age) }}" min="18" max="99">
                    @error('age') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold"><i class="bi bi-telephone text-primary me-1"></i>Teléfono</label>
                    <input type="text" name="phone" class="form-control form-admin @error('phone') is-invalid @enderror"
                           value="{{ old('phone', $driver->phone) }}" maxlength="20">
                    @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="mt-4 pt-3 border-top">
                <button class="btn btn-admin-primary"><i class="bi bi-check-lg"></i> Guardar</button>
                <a href="{{ route('admin.drivers.index') }}" class="btn btn-admin-outline ms-2">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
