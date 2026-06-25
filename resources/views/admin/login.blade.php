<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('messages.admin_login_title') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(135deg, #2c3e50, #3498db);
            min-height: 100vh;
            display: flex;
            align-items: center;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        }
        .card-login {
            border: none;
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0,0,0,.2);
        }
        .card-login .card-header {
            background: linear-gradient(135deg, #2c3e50, #3498db);
            color: #fff;
            border-radius: 16px 16px 0 0;
            text-align: center;
            padding: 2rem 1rem;
        }
        .card-login .card-header i {
            font-size: 3rem;
            display: block;
            margin-bottom: .5rem;
        }
        .card-login .card-body {
            padding: 2rem;
        }
        .form-control:focus {
            border-color: #3498db;
            box-shadow: 0 0 0 3px rgba(52,152,219,.15);
        }
        .btn-login {
            background: linear-gradient(135deg, #2c3e50, #3498db);
            border: none;
            color: #fff;
            padding: .6rem 1.5rem;
            font-weight: 600;
            border-radius: 10px;
            transition: all .2s;
        }
        .btn-login:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(52,152,219,.3);
            color: #fff;
        }
        .brand-icon {
            width: 64px;
            height: 64px;
            background: rgba(255,255,255,.15);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: .75rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 col-lg-4">
                <div class="card card-login">
                    <div class="card-header">
                        <div class="brand-icon mx-auto">
                            <i class="bi bi-gear-fill"></i>
                        </div>
                        <h4 class="mb-0">{{ __('messages.admin_login_title') }}</h4>
                        <p class="mb-0 mt-1 opacity-75 small">{{ __('messages.admin_login_subtitle') }}</p>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger py-2 small">
                                <i class="bi bi-exclamation-circle me-1"></i>
                                @foreach ($errors->all() as $error)
                                    {{ $error }}
                                @endforeach
                            </div>
                        @endif

                        <form action="{{ route('admin.login') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-semibold small">{{ __('messages.admin_auth_username') }}</label>
                                <input type="text" name="username" class="form-control"
                                       placeholder="admin" value="{{ old('username') }}" required autofocus>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold small">{{ __('messages.admin_auth_password') }}</label>
                                <input type="password" name="password" class="form-control"
                                       placeholder="••••••" required>
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" name="remember" class="form-check-input" id="remember">
                                <label class="form-check-label small" for="remember">{{ __('messages.admin_auth_remember') }}</label>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-login">
                                    <i class="bi bi-box-arrow-in-right me-1"></i> {{ __('messages.admin_auth_enter') }}
                                </button>
                            </div>
                        </form>

                        <div class="text-center mt-3">
                            <a href="{{ route('home') }}" class="text-decoration-none small">
                                <i class="bi bi-arrow-left"></i> {{ __('messages.admin_go_to_site') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
