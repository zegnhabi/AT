@extends('admin.layouts.app')

@section('title', __('messages.admin_branding_title'))
@push('styles')
<style>
.color-preview { width: 36px; height: 36px; border-radius: 8px; border: 2px solid #dee2e6; cursor: pointer; transition: transform .2s; }
.color-preview:hover { transform: scale(1.1); }
.color-input { width: 80px; padding: 2px; text-align: center; font-family: monospace; }
.logo-preview { max-width: 200px; max-height: 80px; border-radius: 8px; border: 1px solid #dee2e6; }
.lang-flag { width: 28px; height: 20px; border-radius: 3px; object-fit: cover; }
.lang-card { border: 2px solid #e9ecef; border-radius: 10px; padding: .8rem; transition: all .2s; cursor: pointer; position: relative; }
.lang-card:hover { border-color: var(--admin-accent); }
.lang-card.active { border-color: #27ae60; background: #f0fdf4; }
.lang-card input[type="checkbox"] { display: none; }
.lang-card .lang-check { display: none; position: absolute; top: 6px; right: 6px; color: #27ae60; font-size: 1rem; }
.lang-card.active .lang-check { display: block; }
.trans-cell { max-width: 220px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.trans-cell:hover { white-space: normal; overflow: visible; }
.trans-search { max-width: 320px; }
.trans-group-header { cursor: pointer; user-select: none; }
.trans-group-header .bi-chevron-right { transition: transform .25s ease; display: inline-block; }
.trans-group-header.collapsed .bi-chevron-right { transform: rotate(0deg); }
.trans-group-header:not(.collapsed) .bi-chevron-right { transform: rotate(45deg); }
.trans-group-body { max-height: 0; overflow: hidden; transition: max-height .35s ease; }
.trans-group-body.show { overflow: visible; }
</style>
@endpush

@section('content')
<div class="page-title"><i class="bi bi-gear-wide-connected"></i> {{ __('messages.admin_branding_title') }}</div>

<form method="POST" enctype="multipart/form-data" id="settingsForm">
    @csrf

    <div class="row g-4">
        {{-- Columna derecha: vista previa --}}
        <div class="col-lg-4 order-lg-2">
            <div class="card card-admin mb-4" style="position:sticky;top:80px;">
                <div class="card-header bg-white">
                    <i class="bi bi-eye text-primary me-1"></i> {{ __('messages.admin_branding_preview') }}
                </div>
                <div class="card-body text-center">
                    <p class="text-muted small mb-2">{{ __('messages.admin_branding_frontend_site') }}</p>
                    <div id="prevHeader" style="border-radius:12px; padding:1.5rem; margin-bottom:.75rem; transition:background .3s;">
                        <div id="prevCompanyName" style="font-size:1.1rem; font-weight:bold; transition:color .3s;"></div>
                        <div id="prevSlogan" style="opacity:.7; font-size:.85rem; transition:color .3s;"></div>
                    </div>
                    <div class="d-flex gap-2 justify-content-center mb-3">
                        <button type="button" id="prevBtn1" style="border:none; padding:.35rem 1.2rem; border-radius:8px; font-weight:500; transition:all .3s;">{{ __('messages.admin_branding_btn_search') }}</button>
                        <button type="button" id="prevBtn2" style="border:none; color:#fff; padding:.35rem 1.2rem; border-radius:8px; font-weight:500; transition:all .3s;">{{ __('messages.admin_branding_btn_continue') }}</button>
                        <button type="button" id="prevBtn3" style="border:1px solid; padding:.35rem 1.2rem; border-radius:8px; background:transparent; transition:all .3s;">{{ __('messages.admin_branding_btn_back') }}</button>
                    </div>
                    <hr>
                    <p class="text-muted small mb-2">{{ __('messages.admin_branding_admin_panel') }}</p>
                    <div id="prevAdminBar" style="border-radius:8px; padding:.6rem 1rem; display:flex; gap:.6rem; align-items:center; transition:background .3s;">
                        <div style="color:#fff; font-weight:700;">Admin</div>
                        <div id="prevAdminDash" style="color:#fff; padding:.15rem .6rem; border-radius:6px; font-size:.75rem; transition:background .3s;">{{ __('messages.admin_branding_dashboard') }}</div>
                        <div style="color:rgba(255,255,255,.6); font-size:.75rem;">{{ __('messages.admin_branding_drivers') }}</div>
                        <div style="color:rgba(255,255,255,.6); font-size:.75rem;">{{ __('messages.admin_branding_trips') }}</div>
                    </div>
                    <hr>
                    <p class="text-muted small mb-2">{{ __('messages.admin_branding_logo') }}</p>
                    <img id="prevLogo" src="/images/{{ $settings['logo'] ?? 'logo.jpg' }}" alt="Logo"
                         style="max-width:160px; max-height:60px; border-radius:8px; border:1px solid #eee;">
                </div>
            </div>
        </div>

        {{-- Columna izquierda: formularios --}}
        <div class="col-lg-8 order-lg-1">

            {{-- Empresa --}}
            <div class="card card-admin mb-4">
                <div class="card-header bg-white">
                    <i class="bi bi-info-circle text-primary me-1"></i> {{ __('messages.admin_branding_company_info') }}
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold"><i class="bi bi-building text-primary me-1"></i>{{ __('messages.admin_branding_company_name') }}</label>
                        <input type="text" name="company_name" class="form-control form-admin" id="inputCompanyName"
                               value="{{ old('company_name', $settings['company_name'] ?? '') }}" required maxlength="100">
                    </div>
                    <div class="mb-0">
                        <label class="form-label fw-semibold"><i class="bi bi-quote text-primary me-1"></i>{{ __('messages.admin_branding_slogan') }}</label>
                        <input type="text" name="company_slogan" class="form-control form-admin" id="inputSlogan"
                               value="{{ old('company_slogan', $settings['company_slogan'] ?? '') }}" maxlength="200">
                    </div>
                </div>
            </div>

            {{-- Idiomas --}}
            <div class="card card-admin mb-4">
                <div class="card-header bg-white">
                    <i class="bi bi-translate text-primary me-1"></i> {{ __('messages.admin_branding_languages') }}
                </div>
                <div class="card-body">
                    <p class="text-muted small mb-3">{{ __('messages.admin_branding_languages_help') }}</p>
                    @php
                        $enabledLangs = json_decode($settings['enabled_languages'] ?? '["es","en","de","fr"]', true) ?: ['es','en','de','fr'];
                        $defaultLang = $settings['default_language'] ?? 'es';
                    @endphp
                    <div class="row g-3 mb-3">
                        @foreach(['es' => ['Español','es.png'], 'en' => ['English','en.jpg'], 'de' => ['Deutsch','de.jpg'], 'fr' => ['Français','fr.png']] as $code => $info)
                        <div class="col-6 col-md-3">
                            <label class="lang-card position-relative {{ in_array($code, $enabledLangs) ? 'active' : '' }}" onclick="toggleLang(this)">
                                <input type="checkbox" name="enabled_languages[]" value="{{ $code }}" {{ in_array($code, $enabledLangs) ? 'checked' : '' }}>
                                <i class="bi bi-check-circle-fill lang-check"></i>
                                <div class="text-center">
                                    <img src="/images/{{ $info[1] }}" alt="{{ $code }}" class="lang-flag mb-1">
                                    <div class="fw-semibold small">{{ $info[0] }}</div>
                                    <div class="text-muted" style="font-size:.65rem;">{{ strtoupper($code) }}</div>
                                </div>
                            </label>
                        </div>
                        @endforeach
                    </div>
                    <label class="form-label fw-semibold mb-1"><i class="bi bi-star text-primary me-1"></i>{{ __('messages.admin_branding_default_language') }}</label>
                    <select name="default_language" class="form-select form-admin" style="max-width:260px;">
                        @foreach(['es' => 'Español', 'en' => 'English', 'de' => 'Deutsch', 'fr' => 'Français'] as $code => $name)
                            <option value="{{ $code }}" @selected($defaultLang === $code)>{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Colores frontend --}}
            <div class="card card-admin mb-4">
                <div class="card-header bg-white">
                    <i class="bi bi-eyedropper text-primary me-1"></i> {{ __('messages.admin_branding_frontend_colors') }}
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        @foreach(['primary_color' => __('messages.admin_branding_color_primary'), 'secondary_color' => __('messages.admin_branding_color_secondary'), 'accent_color' => __('messages.admin_branding_color_accent')] as $key => $label)
                        <div class="col-md-4 text-center">
                            <label class="form-label fw-semibold d-block">{{ $label }}</label>
                            <input type="color" name="{{ $key }}" class="color-preview form-control form-control-color"
                                   id="input_{{ $key }}"
                                   value="{{ old($key, $settings[$key] ?? '#ffc107') }}">
                            <input type="text" class="form-control form-control-sm color-input mt-1 mx-auto"
                                   value="{{ old($key, $settings[$key] ?? '#ffc107') }}"
                                   oninput="document.getElementById('input_{{ $key }}').value=this.value; updatePreview();"
                                   pattern="^#[a-fA-F0-9]{6}$">
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Colores admin --}}
            <div class="card card-admin mb-4">
                <div class="card-header bg-white">
                    <i class="bi bi-palette text-primary me-1"></i> {{ __('messages.admin_branding_admin_colors') }}
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        @foreach(['admin_primary_color' => __('messages.admin_branding_color_admin_primary'), 'admin_accent_color' => __('messages.admin_branding_color_admin_accent')] as $key => $label)
                        <div class="col-md-6 text-center">
                            <label class="form-label fw-semibold d-block">{{ $label }}</label>
                            <input type="color" name="{{ $key }}" class="color-preview form-control form-control-color"
                                   id="input_{{ $key }}"
                                   value="{{ old($key, $settings[$key] ?? '#2c3e50') }}">
                            <input type="text" class="form-control form-control-sm color-input mt-1 mx-auto"
                                   value="{{ old($key, $settings[$key] ?? '#2c3e50') }}"
                                   oninput="document.getElementById('input_{{ $key }}').value=this.value; updatePreview();"
                                   pattern="^#[a-fA-F0-9]{6}$">
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Imágenes --}}
            <div class="card card-admin mb-4">
                <div class="card-header bg-white">
                    <i class="bi bi-images text-primary me-1"></i> {{ __('messages.admin_branding_images') }}
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-6 text-center">
                            <label class="form-label fw-semibold d-block">{{ __('messages.admin_branding_current_logo') }}</label>
                            <img src="/images/{{ $settings['logo'] ?? 'logo.jpg' }}?v={{ time() }}" class="logo-preview mb-2">
                            <input type="file" name="logo" class="form-control form-admin" accept="image/*">
                            <div class="mt-2">
                                <a href="{{ route('admin.branding.reset-logo') }}" class="btn btn-sm btn-admin-outline"
                                   onclick="return confirm('{{ __('messages.admin_branding_confirm_reset_logo') }}');">
                                    <i class="bi bi-arrow-counterclockwise"></i> {{ __('messages.admin_branding_reset') }}
                                </a>
                            </div>
                        </div>
                        <div class="col-md-6 text-center">
                            <label class="form-label fw-semibold d-block">{{ __('messages.admin_branding_current_favicon') }}</label>
                            <img src="/images/{{ $settings['favicon'] ?? 'favicon.ico' }}?v={{ time() }}" class="logo-preview mb-2" style="max-width:48px;">
                            <input type="file" name="favicon" class="form-control form-admin" accept=".ico,.png">
                            <div class="mt-2">
                                <a href="{{ route('admin.branding.reset-favicon') }}" class="btn btn-sm btn-admin-outline"
                                   onclick="return confirm('{{ __('messages.admin_branding_confirm_reset_favicon') }}');">
                                    <i class="bi bi-arrow-counterclockwise"></i> {{ __('messages.admin_branding_reset') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-end mb-4">
                <button class="btn btn-admin-primary btn-lg px-5">
                    <i class="bi bi-check-lg"></i> {{ __('messages.admin_branding_save_settings') }}
                </button>
            </div>
        </div>
    </div>
</form>

{{-- ============================================ --}}
{{-- TRADUCCIONES (fuera del form de settings)    --}}
{{-- ============================================ --}}
<div class="card card-admin mb-4 mt-2">
    <div class="card-header bg-white d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div><i class="bi bi-translate text-primary me-1"></i> {{ __('messages.admin_branding_site_translations') }}</div>
        <div class="d-flex gap-2">
            <form action="{{ route('admin.branding.translation.import') }}" method="POST" class="d-inline">
                @csrf
                <button class="btn btn-admin-outline btn-sm" onclick="return confirm('{{ __('messages.admin_branding_confirm_import') }}');">
                    <i class="bi bi-cloud-download"></i> {{ __('messages.admin_branding_import') }}
                </button>
            </form>
            <button class="btn btn-admin-primary btn-sm" data-bs-toggle="modal" data-bs-target="#newTransModal">
                <i class="bi bi-plus-lg"></i> {{ __('messages.admin_branding_new_string') }}
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="d-flex gap-2 mb-3 flex-wrap">
            <input type="text" id="transSearch" class="form-control form-admin trans-search" placeholder="{{ __('messages.admin_branding_search_key') }}" oninput="filterTranslations()">
        </div>

        @php $locales = $transLocales; @endphp

        @forelse($grouped as $category => $keys)
        @if(count($keys) === 0)
            @continue
        @endif
        <div class="mb-3 trans-group-wrap" data-category="{{ $category }}">
            <div class="trans-group-header collapsed d-flex align-items-center gap-2 p-2 rounded"
                 onclick="toggleTransGroup(this)" role="button" aria-expanded="false">
                <i class="bi bi-chevron-right text-primary"></i>
                <span class="fw-bold">{{ $category }}</span>
                <span class="badge bg-secondary bg-opacity-10 text-secondary ms-1">{{ count($keys) }}</span>
            </div>
            <div class="trans-group-body collapse">
                <div class="table-responsive mt-1">
                    <table class="table table-admin mb-0">
                        <thead>
                            <tr>
                                <th style="width:200px;">{{ __('messages.admin_branding_key') }}</th>
                                @foreach($locales as $loc)
                                    <th class="text-center">
                                        <img src="/images/{{ $loc === 'es' ? 'es.png' : ($loc === 'en' ? 'en.jpg' : ($loc === 'de' ? 'de.jpg' : 'fr.png')) }}"
                                             alt="{{ $loc }}" style="width:20px;height:14px;border-radius:2px;" class="me-1">
                                        {{ strtoupper($loc) }}
                                    </th>
                                @endforeach
                                <th class="text-end" style="width:100px;">{{ __('messages.admin_branding_actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($keys as $key)
                            <tr data-key="{{ $key }}">
                                <td><code class="text-primary">{{ $key }}</code></td>
                                @foreach($locales as $loc)
                                    <td class="trans-cell small" title="{{ $translations[$key][$loc] ?? '—' }}">
                                        {{ Str::limit($translations[$key][$loc] ?? '—', 40) }}
                                    </td>
                                @endforeach
                                <td class="text-end">
                                    <button class="btn btn-sm btn-admin-outline" title="{{ __('messages.admin_branding_edit') }}"
                                            onclick='openEditTrans(@json($key), @json($translations[$key] ?? []))'>
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <form action="{{ route('admin.branding.translation.destroy', $key) }}" method="POST" class="d-inline"
                                           onsubmit="return confirm('{{ __('messages.admin_branding_confirm_delete', ['key' => $key]) }}');">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-admin-danger" title="{{ __('messages.admin_branding_delete') }}"><i class="bi bi-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @empty
        <div class="text-center text-muted py-4">
            <i class="bi bi-inbox fs-1 d-block mb-2"></i>
            {{ __('messages.admin_branding_no_strings') }}
        </div>
        @endforelse
    </div>
</div>

{{-- Modal: Nueva cadena --}}
<div class="modal fade" id="newTransModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('admin.branding.translation.store') }}" method="POST" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-plus-circle text-primary me-1"></i> {{ __('messages.admin_branding_new_string') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fw-semibold">{{ __('messages.admin_branding_key_required') }}</label>
                    <input type="text" name="key" class="form-control form-admin" required
                           placeholder="{{ __('messages.admin_branding_key_placeholder') }}" pattern="[a-z][a-z0-9_.]*"
                           title="{{ __('messages.admin_branding_key_title') }}">
                    <div class="form-text">{!! __('messages.admin_branding_key_examples') !!}</div>
                </div>
                <div class="row g-3">
                    @foreach($locales as $loc)
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            <img src="/images/{{ $loc === 'es' ? 'es.png' : ($loc === 'en' ? 'en.jpg' : ($loc === 'de' ? 'de.jpg' : 'fr.png')) }}"
                                 alt="{{ $loc }}" style="width:22px;height:16px;border-radius:2px;" class="me-1">
                            {{ strtoupper($loc) }}
                        </label>
                        <input type="text" name="values[{{ $loc }}]" class="form-control form-admin" required>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-admin-outline" data-bs-dismiss="modal">{{ __('messages.admin_branding_cancel') }}</button>
                <button class="btn btn-admin-primary"><i class="bi bi-check-lg"></i> {{ __('messages.admin_branding_save') }}</button>
            </div>
        </form>
    </div>
</div>

{{-- Modal: Editar cadena --}}
<div class="modal fade" id="editTransModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form id="editTransForm" method="POST" class="modal-content">
            @csrf @method('PUT')
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-pencil-square text-primary me-1"></i> {{ __('messages.admin_branding_edit_string') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fw-semibold">{{ __('messages.admin_branding_key') }}</label>
                    <input type="text" id="editTransKey" class="form-control form-admin" readonly style="background:#f8f9fa;">
                </div>
                <div class="row g-3" id="editTransFields"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-admin-outline" data-bs-dismiss="modal">{{ __('messages.admin_branding_cancel') }}</button>
                <button class="btn btn-admin-primary"><i class="bi bi-check-lg"></i> {{ __('messages.admin_branding_save') }}</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function updatePreview() {
    const p = document.getElementById('input_primary_color').value;
    const s = document.getElementById('input_secondary_color').value;
    const a = document.getElementById('input_accent_color').value;
    const ap = document.getElementById('input_admin_primary_color').value;
    const aa = document.getElementById('input_admin_accent_color').value;

    document.getElementById('prevHeader').style.background = p;
    document.getElementById('prevCompanyName').style.color = s;
    document.getElementById('prevCompanyName').textContent = document.getElementById('inputCompanyName').value || '{{ __('messages.admin_branding_company_fallback') }}';
    document.getElementById('prevSlogan').style.color = s;
    document.getElementById('prevSlogan').textContent = document.getElementById('inputSlogan').value;

    const b1 = document.getElementById('prevBtn1');
    b1.style.background = p; b1.style.color = s;
    const b2 = document.getElementById('prevBtn2');
    b2.style.background = a;
    const b3 = document.getElementById('prevBtn3');
    b3.style.borderColor = s; b3.style.color = s;

    document.getElementById('prevAdminBar').style.background = ap;
    document.getElementById('prevAdminDash').style.background = aa;
}

function toggleLang(el) {
    const cb = el.querySelector('input[type="checkbox"]');
    cb.checked = !cb.checked;
    el.classList.toggle('active', cb.checked);
}

document.querySelectorAll('input[type="color"]').forEach(function(el) {
    el.addEventListener('input', function() {
        this.nextElementSibling.value = this.value;
        updatePreview();
    });
});

document.getElementById('inputCompanyName').addEventListener('input', updatePreview);
document.getElementById('inputSlogan').addEventListener('input', updatePreview);

updatePreview();

function toggleTransGroup(header) {
    const body = header.nextElementSibling;
    const isOpen = !header.classList.contains('collapsed');

    if (isOpen) {
        header.classList.add('collapsed');
        header.setAttribute('aria-expanded', 'false');
        body.style.maxHeight = '0';
        body.classList.remove('show');
    } else {
        header.classList.remove('collapsed');
        header.setAttribute('aria-expanded', 'true');
        body.classList.add('show');
        body.style.maxHeight = body.scrollHeight + 'px';
    }
}

function filterTranslations() {
    const search = document.getElementById('transSearch').value.toLowerCase();
    document.querySelectorAll('.trans-group-wrap').forEach(function(group) {
        let hasVisible = false;
        group.querySelectorAll('tr[data-key]').forEach(function(row) {
            const match = row.dataset.key.toLowerCase().includes(search);
            row.style.display = match ? '' : 'none';
            if (match) hasVisible = true;
        });
        group.style.display = hasVisible || !search ? '' : 'none';

        if (search && hasVisible) {
            const header = group.querySelector('.trans-group-header');
            const body = group.querySelector('.trans-group-body');
            if (header.classList.contains('collapsed')) {
                header.classList.remove('collapsed');
                header.setAttribute('aria-expanded', 'true');
                body.classList.add('show');
                body.style.maxHeight = body.scrollHeight + 'px';
            }
        }
    });
}

function openEditTrans(key, values) {
    const form = document.getElementById('editTransForm');
    form.action = '/admin/personalizacion/traducciones/' + encodeURIComponent(key);
    document.getElementById('editTransKey').value = key;

    const locales = @json($locales);
    const flags = @json(collect($locales)->mapWithKeys(fn($l) => [$l => $l === 'es' ? 'es.png' : ($l === 'en' ? 'en.jpg' : ($l === 'de' ? 'de.jpg' : 'fr.png'))]));
    const container = document.getElementById('editTransFields');
    container.innerHTML = '';

    locales.forEach(function(loc) {
        const col = document.createElement('div');
        col.className = 'col-md-6';
        col.innerHTML = `
            <label class="form-label fw-semibold">
                <img src="/images/${flags[loc]}" alt="${loc}" style="width:22px;height:16px;border-radius:2px;" class="me-1">
                ${loc.toUpperCase()}
            </label>
            <input type="text" name="values[${loc}]" class="form-control form-admin" required value="${(values[loc] || '').replace(/"/g, '&quot;')}">
        `;
        container.appendChild(col);
    });

    new bootstrap.Modal(document.getElementById('editTransModal')).show();
}
</script>
@endpush
@endsection
