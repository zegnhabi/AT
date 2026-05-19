<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Sistema para la venta de boletos de una terminal de autobuses">
    <meta name="author" content="Jose Ibanez">
    <title>@yield('title', $brand['company_name'] ?? __('messages.title'))</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="shortcut icon" href="/images/{{ $brand['favicon'] ?? 'favicon.ico' }}">
    <style>
    :root {
        --brand-primary: {{ $brand['primary_color'] ?? '#ffc107' }};
        --brand-secondary: {{ $brand['secondary_color'] ?? '#212529' }};
        --brand-accent: {{ $brand['accent_color'] ?? '#0d6efd' }};
    }
    .btn-brand-primary {
        background: var(--brand-primary);
        border-color: var(--brand-primary);
        color: var(--brand-secondary);
    }
    .btn-brand-primary:hover {
        filter: brightness(.9);
        color: var(--brand-secondary);
    }
    .bg-brand-primary {
        background: var(--brand-primary) !important;
        color: var(--brand-secondary) !important;
    }
    .text-brand-accent {
        color: var(--brand-accent);
    }
    .badge-brand-primary {
        background: color-mix(in srgb, var(--brand-primary) 20%, transparent);
        color: var(--brand-secondary);
    }
    </style>
    @stack('styles')
</head>
<body>
    <div class="container py-3">
        <div class="text-center mb-4">
            <img src="/images/{{ $brand['logo'] ?? 'logo.jpg' }}" alt="{{ $brand['company_name'] ?? 'Autobuses' }}" class="img-fluid" style="max-height:100px;">
            @if(!empty($brand['company_slogan']))
                <div class="text-muted small mt-1">{{ $brand['company_slogan'] }}</div>
            @endif
        </div>

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <footer class="container text-center text-muted small py-3 border-top">
        &copy; 2009 - {{ date('Y') }}
        <a href="mailto:zegnhabi@gmail.com" class="text-decoration-none">{{ __('messages.contact') }}</a>
        &middot; <a href="{{ route('admin.dashboard') }}" class="text-decoration-none"><i class="bi bi-gear"></i> Admin</a>
    </footer>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
