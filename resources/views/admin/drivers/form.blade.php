@extends('admin.layouts.app')

@section('title', $driver->exists ? __('messages.admin_edit_driver') : __('messages.admin_new_driver'))
@section('content')
<div class="page-title">
    <i class="bi bi-people-fill"></i>
    {{ $driver->exists ? __('messages.admin_edit_driver') : __('messages.admin_new_driver') }}
</div>

<div class="card card-admin">
    <div class="card-body p-4">
        <form action="{{ $driver->exists ? route('admin.drivers.update', $driver) : route('admin.drivers.store') }}" method="POST">
            @csrf
            @if($driver->exists) @method('PUT') @endif

            <div class="row g-4">
                <div class="col-md-6">
                    <label class="form-label fw-semibold"><i class="bi bi-person text-primary me-1"></i>{{ __('messages.admin_name') }} *</label>
                    <input type="text" name="name" class="form-control form-admin @error('name') is-invalid @enderror"
                           value="{{ old('name', $driver->name) }}" required maxlength="65">
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold"><i class="bi bi-gender-ambiguous text-primary me-1"></i>{{ __('messages.admin_gender') }}</label>
                    <select name="gender" class="form-select form-admin">
                        <option value="">{{ __('messages.admin_select') }}</option>
                        <option value="M" @selected(old('gender', $driver->gender) === 'M')>{{ __('messages.admin_male') }}</option>
                        <option value="F" @selected(old('gender', $driver->gender) === 'F')>{{ __('messages.admin_female') }}</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold"><i class="bi bi-calendar text-primary me-1"></i>{{ __('messages.admin_age') }}</label>
                    <input type="number" name="age" class="form-control form-admin @error('age') is-invalid @enderror"
                           value="{{ old('age', $driver->age) }}" min="18" max="99">
                    @error('age') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold"><i class="bi bi-telephone text-primary me-1"></i>{{ __('messages.admin_phone') }}</label>
                    <input type="text" name="phone" class="form-control form-admin @error('phone') is-invalid @enderror"
                           value="{{ old('phone', $driver->phone) }}" maxlength="20">
                    @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="mt-4 pt-3 border-top">
                <button class="btn btn-admin-primary"><i class="bi bi-check-lg"></i> {{ __('messages.admin_save') }}</button>
                <a href="{{ route('admin.drivers.index') }}" class="btn btn-admin-outline ms-2">{{ __('messages.admin_cancel') }}</a>
            </div>
        </form>
    </div>
</div>
@endsection
