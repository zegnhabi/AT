<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin - BusTicketing')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="shortcut icon" href="/images/{{ $brand['favicon'] ?? 'favicon.ico' }}">
    @php
        $ap = $brand['admin_primary_color'] ?? '#2c3e50';
        $aa = $brand['admin_accent_color'] ?? '#3498db';
    @endphp
    <style>
    :root {
        --admin-primary: {{ $ap }};
        --admin-accent: {{ $aa }};
        --admin-success: #27ae60;
        --admin-warning: #f39c12;
        --admin-danger: #e74c3c;
        --admin-info: #1abc9c;
        --admin-dark: #1a252f;
        --admin-gradient: linear-gradient(135deg, {{ $ap }} 0%, {{ $aa }} 100%);
        --admin-gradient-hover: linear-gradient(135deg, {{ $ap }}dd 0%, {{ $aa }}dd 100%);
    }

    body {
        background: #f0f2f5;
        font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
    }

    .navbar-admin {
        background: var(--admin-gradient) !important;
        box-shadow: 0 2px 15px rgba(44,62,80,.3);
    }

    .navbar-admin .navbar-brand {
        font-weight: 700;
        letter-spacing: .5px;
        text-shadow: 0 1px 2px rgba(0,0,0,.2);
    }

    .navbar-admin .nav-link {
        color: rgba(255,255,255,.85) !important;
        border-radius: 8px;
        margin: 0 2px;
        transition: all .2s;
    }

    .navbar-admin .nav-link:hover,
    .navbar-admin .nav-link.active {
        background: rgba(255,255,255,.15);
        color: #fff !important;
    }

    .navbar-admin .nav-link i {
        margin-right: 4px;
    }

    .navbar-admin .btn-outline-light {
        border-color: rgba(255,255,255,.4);
        transition: all .2s;
    }

    .navbar-admin .btn-outline-light:hover {
        background: rgba(255,255,255,.2);
        border-color: rgba(255,255,255,.6);
    }

    .card-admin {
        border: none;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,.06);
        transition: transform .2s, box-shadow .2s;
        overflow: hidden;
    }

    .card-admin:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0,0,0,.1);
    }

    .card-admin .card-header {
        border-bottom: none;
        font-weight: 600;
        padding: 1rem 1.25rem;
    }

    .card-gradient-primary {
        background: linear-gradient(135deg, #3498db, #2980b9);
        color: #fff;
    }

    .card-gradient-success {
        background: linear-gradient(135deg, #27ae60, #2ecc71);
        color: #fff;
    }

    .card-gradient-warning {
        background: linear-gradient(135deg, #f39c12, #e67e22);
        color: #fff;
    }

    .card-gradient-info {
        background: linear-gradient(135deg, #1abc9c, #16a085);
        color: #fff;
    }

    .card-gradient-danger {
        background: linear-gradient(135deg, #e74c3c, #c0392b);
        color: #fff;
    }

    .card-gradient-secondary {
        background: linear-gradient(135deg, #95a5a6, #7f8c8d);
        color: #fff;
    }

    .kpi-value {
        font-size: 2.2rem;
        font-weight: 800;
        line-height: 1;
        margin-bottom: 4px;
    }

    .kpi-label {
        font-size: .8rem;
        opacity: .85;
        text-transform: uppercase;
        letter-spacing: .5px;
    }

    .kpi-icon {
        font-size: 2.5rem;
        opacity: .3;
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
    }

    .table-admin {
        margin-bottom: 0;
    }

    .table-admin thead th {
        background: #f8f9fa;
        color: #495057;
        font-weight: 600;
        font-size: .8rem;
        text-transform: uppercase;
        letter-spacing: .4px;
        border-bottom: 2px solid #dee2e6;
        padding: .75rem 1rem;
        white-space: nowrap;
    }

    .table-admin tbody td {
        padding: .7rem 1rem;
        vertical-align: middle;
        border-color: #f0f0f0;
    }

    .table-admin tbody tr {
        transition: background .15s;
    }

    .table-admin tbody tr:hover {
        background: #f0f7ff;
    }

    .badge-status {
        padding: .35em .65em;
        font-weight: 500;
        border-radius: 20px;
    }

    .btn-admin {
        border-radius: 8px;
        font-weight: 500;
        padding: .4rem 1rem;
        transition: all .2s;
    }

    .btn-admin-primary {
        background: var(--admin-gradient);
        border: none;
        color: #fff;
    }

    .btn-admin-primary:hover {
        background: var(--admin-gradient-hover);
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(52,152,219,.3);
    }

    .btn-admin-outline {
        border: 1px solid #dee2e6;
        background: #fff;
        color: #495057;
    }

    .btn-admin-outline:hover {
        background: #f8f9fa;
        border-color: #c8ccd0;
    }

    .btn-admin-danger {
        background: linear-gradient(135deg, #e74c3c, #c0392b);
        border: none;
        color: #fff;
    }

    .btn-admin-danger:hover {
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(231,76,60,.3);
    }

    .form-admin {
        border-radius: 8px;
        border: 1px solid #e0e0e0;
        padding: .5rem .75rem;
        transition: border-color .2s, box-shadow .2s;
    }

    .form-admin:focus {
        border-color: #3498db;
        box-shadow: 0 0 0 3px rgba(52,152,219,.15);
    }

    .page-title {
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 1.5rem;
    }

    .page-title i {
        color: #3498db;
        margin-right: 8px;
    }

    .footer-admin {
        color: #95a5a6;
        font-size: .85rem;
        border-top: 1px solid #eef0f2;
        padding: 1.5rem 0;
        margin-top: 2rem;
    }

    .pagination {
        margin-bottom: 0;
    }

    .page-link {
        border-radius: 8px !important;
        margin: 0 2px;
        color: #495057;
        border: 1px solid #dee2e6;
        padding: .4rem .85rem;
        font-size: .9rem;
        transition: all .15s;
    }

    .page-link:hover {
        background: #e8f0fe;
        border-color: #3498db;
        color: #3498db;
    }

    .page-item.active .page-link {
        background: var(--admin-gradient);
        border-color: transparent;
        font-weight: 600;
    }

    .page-item.disabled .page-link {
        color: #adb5bd;
        border-color: #e9ecef;
    }

    .alert-admin {
        border-radius: 10px;
        border: none;
        box-shadow: 0 2px 8px rgba(0,0,0,.05);
    }

    .filter-bar {
        background: #fff;
        border-radius: 12px;
        padding: 1rem 1.25rem;
        box-shadow: 0 2px 8px rgba(0,0,0,.06);
        margin-bottom: 1.5rem;
    }

    .chart-bar {
        border-radius: 4px 4px 0 0;
        min-height: 4px;
        transition: height .3s;
    }

    @media (max-width: 768px) {
        .kpi-value { font-size: 1.6rem; }
    }
    </style>
    @stack('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark navbar-admin sticky-top">
        <div class="container-fluid px-4">
            <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
                <i class="bi bi-gear-fill me-1"></i> Admin Panel
            </a>
            <button class="navbar-toggler border-0" data-bs-toggle="collapse" data-bs-target="#adminNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="adminNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link @if(request()->routeIs('admin.dashboard')) active @endif" href="{{ route('admin.dashboard') }}"><i class="bi bi-grid-1x2-fill"></i> Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link @if(request()->routeIs('admin.drivers.*')) active @endif" href="{{ route('admin.drivers.index') }}"><i class="bi bi-people-fill"></i> Choferes</a></li>
                    <li class="nav-item"><a class="nav-link @if(request()->routeIs('admin.buses.*')) active @endif" href="{{ route('admin.buses.index') }}"><i class="bi bi-truck-front-fill"></i> Autobuses</a></li>
                    <li class="nav-item"><a class="nav-link @if(request()->routeIs('admin.cities.*')) active @endif" href="{{ route('admin.cities.index') }}"><i class="bi bi-geo-alt-fill"></i> Ciudades</a></li>
                    <li class="nav-item"><a class="nav-link @if(request()->routeIs('admin.trips.*')) active @endif" href="{{ route('admin.trips.index') }}"><i class="bi bi-ticket-perforated-fill"></i> Viajes</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle @if(request()->routeIs('admin.cashier.*')) active @endif" data-bs-toggle="dropdown" href="#">
                            <i class="bi bi-cash-stack"></i> Caja
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark shadow">
                            <li><a class="dropdown-item" href="{{ route('admin.cashier.corte') }}"><i class="bi bi-receipt"></i> Corte de caja</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.cashier.arqueo') }}"><i class="bi bi-calculator-fill"></i> Arqueo</a></li>
                        </ul>
                    </li>
                    <li class="nav-item"><a class="nav-link @if(request()->routeIs('admin.branding')) active @endif" href="{{ route('admin.branding') }}"><i class="bi bi-palette-fill"></i> Marca</a></li>
                </ul>
                <div class="d-flex gap-2">
                    <a href="{{ route('home') }}" class="btn btn-outline-light btn-sm">
                        <i class="bi bi-arrow-left"></i> Ir al sitio
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container-fluid px-4 py-4">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show alert-admin border-start border-4 border-success" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <div class="container-fluid px-4 footer-admin text-center">
        <i class="bi bi-gear"></i> BusTicketing Admin Panel &middot; &copy; {{ date('Y') }}
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
