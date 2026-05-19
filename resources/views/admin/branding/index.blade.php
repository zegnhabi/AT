@extends('admin.layouts.app')

@section('title', 'Personalización de Marca')
@push('styles')
<style>
.color-preview {
    width: 40px; height: 40px;
    border-radius: 8px;
    border: 2px solid #dee2e6;
    cursor: pointer;
    transition: transform .2s;
}
.color-preview:hover { transform: scale(1.1); }
.color-input { width: 80px; padding: 2px; text-align: center; font-family: monospace; }
.logo-preview { max-width: 200px; max-height: 80px; border-radius: 8px; border: 1px solid #dee2e6; }
</style>
@endpush

@section('content')
<div class="page-title"><i class="bi bi-palette-fill"></i> Personalización de marca</div>

<div class="row g-4">
    <div class="col-md-7">
        <form method="POST" enctype="multipart/form-data">
            @csrf

            <div class="card card-admin mb-4">
                <div class="card-header bg-white">
                    <i class="bi bi-info-circle text-primary me-1"></i> Información de la empresa
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold"><i class="bi bi-building text-primary me-1"></i>Nombre de la empresa *</label>
                        <input type="text" name="company_name" class="form-control form-admin"
                               value="{{ old('company_name', $settings['company_name'] ?? '') }}" required maxlength="100">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold"><i class="bi bi-quote text-primary me-1"></i>Eslogan</label>
                        <input type="text" name="company_slogan" class="form-control form-admin"
                               value="{{ old('company_slogan', $settings['company_slogan'] ?? '') }}" maxlength="200">
                    </div>
                </div>
            </div>

            <div class="card card-admin mb-4">
                <div class="card-header bg-white">
                    <i class="bi bi-eyedropper text-primary me-1"></i> Colores del frontend
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4 text-center">
                            <label class="form-label fw-semibold d-block">Color primario</label>
                            <input type="color" name="primary_color" class="color-preview form-control form-control-color"
                                   value="{{ old('primary_color', $settings['primary_color'] ?? '#ffc107') }}"
                                   onchange="this.nextElementSibling.value=this.value">
                            <input type="text" class="form-control form-control-sm color-input mt-1 mx-auto"
                                   value="{{ old('primary_color', $settings['primary_color'] ?? '#ffc107') }}"
                                   oninput="this.previousElementSibling.value=this.value" name="primary_color_text"
                                   pattern="^#[a-fA-F0-9]{6}$">
                        </div>
                        <div class="col-md-4 text-center">
                            <label class="form-label fw-semibold d-block">Color secundario</label>
                            <input type="color" name="secondary_color" class="color-preview form-control form-control-color"
                                   value="{{ old('secondary_color', $settings['secondary_color'] ?? '#212529') }}"
                                   onchange="this.nextElementSibling.value=this.value">
                            <input type="text" class="form-control form-control-sm color-input mt-1 mx-auto"
                                   value="{{ old('secondary_color', $settings['secondary_color'] ?? '#212529') }}"
                                   oninput="this.previousElementSibling.value=this.value" pattern="^#[a-fA-F0-9]{6}$">
                        </div>
                        <div class="col-md-4 text-center">
                            <label class="form-label fw-semibold d-block">Color de acento</label>
                            <input type="color" name="accent_color" class="color-preview form-control form-control-color"
                                   value="{{ old('accent_color', $settings['accent_color'] ?? '#0d6efd') }}"
                                   onchange="this.nextElementSibling.value=this.value">
                            <input type="text" class="form-control form-control-sm color-input mt-1 mx-auto"
                                   value="{{ old('accent_color', $settings['accent_color'] ?? '#0d6efd') }}"
                                   oninput="this.previousElementSibling.value=this.value" pattern="^#[a-fA-F0-9]{6}$">
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-admin mb-4">
                <div class="card-header bg-white">
                    <i class="bi bi-eyedropper text-primary me-1"></i> Colores del panel admin
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6 text-center">
                            <label class="form-label fw-semibold d-block">Color primario admin</label>
                            <input type="color" name="admin_primary_color" class="color-preview form-control form-control-color"
                                   value="{{ old('admin_primary_color', $settings['admin_primary_color'] ?? '#2c3e50') }}"
                                   onchange="this.nextElementSibling.value=this.value">
                            <input type="text" class="form-control form-control-sm color-input mt-1 mx-auto"
                                   value="{{ old('admin_primary_color', $settings['admin_primary_color'] ?? '#2c3e50') }}"
                                   oninput="this.previousElementSibling.value=this.value" pattern="^#[a-fA-F0-9]{6}$">
                        </div>
                        <div class="col-md-6 text-center">
                            <label class="form-label fw-semibold d-block">Color acento admin</label>
                            <input type="color" name="admin_accent_color" class="color-preview form-control form-control-color"
                                   value="{{ old('admin_accent_color', $settings['admin_accent_color'] ?? '#3498db') }}"
                                   onchange="this.nextElementSibling.value=this.value">
                            <input type="text" class="form-control form-control-sm color-input mt-1 mx-auto"
                                   value="{{ old('admin_accent_color', $settings['admin_accent_color'] ?? '#3498db') }}"
                                   oninput="this.previousElementSibling.value=this.value" pattern="^#[a-fA-F0-9]{6}$">
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-admin mb-4">
                <div class="card-header bg-white">
                    <i class="bi bi-images text-primary me-1"></i> Imágenes
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-6 text-center">
                            <label class="form-label fw-semibold d-block">Logo actual</label>
                            <img src="/images/{{ $settings['logo'] ?? 'logo.jpg' }}?v={{ time() }}"
                                 class="logo-preview mb-2">
                            <input type="file" name="logo" class="form-control form-admin" accept="image/*">
                            <div class="mt-2">
                                <a href="{{ route('admin.branding.reset-logo') }}"
                                   class="btn btn-sm btn-admin-outline"
                                   onclick="return confirm('¿Restaurar logo por defecto?');">
                                    <i class="bi bi-arrow-counterclockwise"></i> Restaurar
                                </a>
                            </div>
                        </div>
                        <div class="col-md-6 text-center">
                            <label class="form-label fw-semibold d-block">Favicon actual</label>
                            <img src="/images/{{ $settings['favicon'] ?? 'favicon.ico' }}?v={{ time() }}"
                                 class="logo-preview mb-2" style="max-width:48px;">
                            <input type="file" name="favicon" class="form-control form-admin" accept=".ico,.png">
                            <div class="mt-2">
                                <a href="{{ route('admin.branding.reset-favicon') }}"
                                   class="btn btn-sm btn-admin-outline"
                                   onclick="return confirm('¿Restaurar favicon por defecto?');">
                                    <i class="bi bi-arrow-counterclockwise"></i> Restaurar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-end mb-4">
                <button class="btn btn-admin-primary btn-lg px-5">
                    <i class="bi bi-check-lg"></i> Guardar configuración
                </button>
            </div>
        </form>
    </div>

    <div class="col-md-5">
        <div class="card card-admin mb-4">
            <div class="card-header bg-white">
                <i class="bi bi-eye text-primary me-1"></i> Vista previa
            </div>
            <div class="card-body text-center">
                <p class="text-muted small mb-3">Así se verán tus colores en el frontend:</p>

                @php
                    $p = old('primary_color', $settings['primary_color'] ?? '#ffc107');
                    $s = old('secondary_color', $settings['secondary_color'] ?? '#212529');
                    $a = old('accent_color', $settings['accent_color'] ?? '#0d6efd');
                @endphp

                <div style="background:{{ $p }}; border-radius:12px; padding:2rem; margin-bottom:1rem;">
                    <div style="font-size:1.2rem; font-weight:bold; color:{{ $s }};">
                        {{ old('company_name', $settings['company_name'] ?? 'Autobuses S.A. de C.V') }}
                    </div>
                    <div style="color:{{ $s }}; opacity:.7; font-size:.9rem;">
                        {{ old('company_slogan', $settings['company_slogan'] ?? '') }}
                    </div>
                </div>

                <div class="d-flex gap-2 justify-content-center mb-3">
                    <button style="background:{{ $p }}; border:none; color:{{ $s }}; padding:.4rem 1.5rem; border-radius:8px; font-weight:500;">Buscar</button>
                    <button style="background:{{ $a }}; border:none; color:#fff; padding:.4rem 1.5rem; border-radius:8px; font-weight:500;">Continuar</button>
                    <button style="border:1px solid {{ $s }}; color:{{ $s }}; padding:.4rem 1.5rem; border-radius:8px; background:transparent;">Regresar</button>
                </div>

                <p class="text-muted small mt-3">Admin panel:</p>
                @php
                    $ap = old('admin_primary_color', $settings['admin_primary_color'] ?? '#2c3e50');
                    $aa = old('admin_accent_color', $settings['admin_accent_color'] ?? '#3498db');
                @endphp
                <div style="background:{{ $ap }}; border-radius:8px; padding:.8rem 1.2rem; display:flex; gap:.8rem; align-items:center;">
                    <div style="color:#fff; font-weight:700;">Admin</div>
                    <div style="background:{{ $aa }}; color:#fff; padding:.2rem .8rem; border-radius:6px; font-size:.8rem;">Dashboard</div>
                    <div style="color:rgba(255,255,255,.6); font-size:.8rem;">Choferes</div>
                    <div style="color:rgba(255,255,255,.6); font-size:.8rem;">Viajes</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
