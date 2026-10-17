
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In | Fleet Management</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --navy: #14243d;
            --blue: #3d6df2;
            --muted: #78869a;
        }

        * { box-sizing: border-box; }

        body {
            min-height: 100vh;
            margin: 0;
            background: #f1f5fb;
            font-family: "Segoe UI", Arial, sans-serif;
            color: var(--navy);
        }

        .auth-shell {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 1.05fr 1fr;
        }

        .brand-panel {
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: clamp(30px, 5vw, 65px);
            color: white;
            background: linear-gradient(145deg, #13223b, #1c3d68 65%, #2858a2);
        }

        .brand-panel::before,
        .brand-panel::after {
            content: "";
            position: absolute;
            border: 1px solid rgba(255,255,255,.09);
            border-radius: 50%;
            width: 430px;
            height: 430px;
            right: -170px;
            top: 15%;
        }

        .brand-panel::after {
            width: 570px;
            height: 570px;
            right: -240px;
            top: 8%;
        }

        .brand-content, .brand-footer, .brand-logo {
            position: relative;
            z-index: 1;
        }

        .brand-logo {
            display: flex;
            align-items: center;
            gap: 13px;
            font-weight: 750;
            font-size: 20px;
        }

        .logo-icon {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            background: #4b7cf6;
            display: grid;
            place-items: center;
            font-size: 25px;
        }

        .brand-content { max-width: 510px; }

        .eyebrow {
            color: #9fbcff;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .brand-content h1 {
            font-size: clamp(35px, 4vw, 54px);
            font-weight: 800;
            line-height: 1.13;
            letter-spacing: -1.5px;
            margin: 18px 0;
        }

        .brand-content p {
            color: #c4d2e7;
            font-size: 16px;
            line-height: 1.8;
        }

        .feature-list {
            display: grid;
            gap: 17px;
            margin-top: 35px;
        }

        .feature {
            display: flex;
            align-items: center;
            gap: 13px;
            color: #e0e9f8;
            font-size: 14px;
        }

        .feature i {
            color: #8db0ff;
            font-size: 20px;
        }

        .brand-footer {
            color: #aabbd3;
            font-size: 12px;
        }

        .form-panel {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 35px 24px;
        }

        .form-wrap { width: 100%; max-width: 420px; }

        .mobile-brand { display: none; }

        .form-heading h2 {
            font-weight: 800;
            font-size: 31px;
            letter-spacing: -.7px;
        }

        .form-heading p, .muted { color: var(--muted); }

        .form-label {
            font-size: 13px;
            font-weight: 650;
            margin-bottom: 8px;
        }

        .input-group-text {
            background: white;
            color: #8190a5;
            border-right: 0;
            padding-left: 15px;
        }

        .form-control {
            min-height: 49px;
            border-left: 0;
            font-size: 14px;
        }

        .input-group:focus-within .input-group-text,
        .input-group:focus-within .form-control {
            border-color: var(--blue);
        }

        .form-control:focus {
            box-shadow: none;
        }

        .btn-primary {
            min-height: 49px;
            border: 0;
            border-radius: 9px;
            background: var(--blue);
            font-weight: 650;
            box-shadow: 0 7px 16px rgba(61,109,242,.18);
        }

        .btn-primary:hover { background: #2e59d1; }

        .auth-link {
            color: var(--blue);
            text-decoration: none;
            font-weight: 650;
        }

        .auth-link:hover { text-decoration: underline; }

        .security-note {
            background: #f5f8ff;
            border: 1px solid #e5ecfc;
            border-radius: 10px;
            padding: 13px;
            color: #60718c;
            font-size: 12px;
        }

        @media (max-width: 850px) {
            .auth-shell { grid-template-columns: 1fr; }
            .brand-panel { display: none; }
            .form-panel { padding: 35px 22px; }
            .mobile-brand {
                display: flex;
                align-items: center;
                gap: 10px;
                margin-bottom: 42px;
                font-weight: 750;
            }
            .mobile-brand .logo-icon {
                width: 42px;
                height: 42px;
                font-size: 22px;
            }
        }
    </style>
</head>
<body>
<div class="auth-shell">

    <section class="brand-panel">
        <div class="brand-logo">
            <div class="logo-icon"><i class="bi bi-truck-front-fill"></i></div>
            <div>
                Fleet Management
                <div class="small fw-normal" style="color:#b6c8e3;font-size:12px">
                    MANAGEMENT PORTAL
                </div>
            </div>
        </div>

        <div class="brand-content">
            <div class="eyebrow">One platform. Total control.</div>
            <h1>Manage your fleet.<br>Move forward.</h1>
            <p>
                A smarter workspace for vehicle operations, driver records
                and controlled business approvals.
            </p>

            <div class="feature-list">
                <div class="feature">
                    <i class="bi bi-truck-front"></i>
                    <span>Centralized fleet and vehicle management</span>
                </div>
                <div class="feature">
                    <i class="bi bi-shield-check"></i>
                    <span>Role-based access and approval controls</span>
                </div>
                <div class="feature">
                    <i class="bi bi-speedometer2"></i>
                    <span>Organized operational records and mileage</span>
                </div>
            </div>
        </div>

        <div class="brand-footer">
            &copy; {{ date('Y') }} Fleet Management System. Authorized access only.
        </div>
    </section>

    <main class="form-panel">
        <div class="form-wrap">

            <div class="mobile-brand">
                <div class="logo-icon text-white" style="background:#3d6df2">
                    <i class="bi bi-truck-front-fill"></i>
                </div>
                <span>Fleet Management</span>
            </div>

            <div class="form-heading mb-4">
                <div class="eyebrow mb-2" style="color:#3d6df2">WELCOME BACK</div>
                <h2>Sign in to your account</h2>
                <p class="mb-0">Enter your credentials to access your workspace.</p>
            </div>

            @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <div class="fw-semibold mb-1">Unable to sign in</div>
                    <ul class="mb-0 ps-3 small">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            class="form-control"
                            placeholder="you@company.com"
                            autocomplete="username"
                            required
                            autofocus>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <label for="password" class="form-label">Password</label>
                        @if (Route::has('password.request'))
                            <a class="auth-link small mb-2"
                               href="{{ route('password.request') }}">
                                Forgot password?
                            </a>
                        @endif
                    </div>

                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input
                            id="password"
                            type="password"
                            name="password"
                            class="form-control"
                            placeholder="Enter your password"
                            autocomplete="current-password"
                            required>
                        <button class="btn btn-outline-secondary"
                                type="button"
                                onclick="togglePassword('password', this)"
                                aria-label="Show or hide password">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox"
                           name="remember" id="remember_me">
                    <label class="form-check-label small" for="remember_me">
                        Remember me on this device
                    </label>
                </div>

                <button type="submit" class="btn btn-primary text-white w-100">
                    Sign In <i class="bi bi-arrow-right ms-2"></i>
                </button>
            </form>

            @if (Route::has('register'))
                <div class="text-center mt-4 small muted">
                    Don't have an account?
                    <a href="{{ route('register') }}" class="auth-link">Create account</a>
                </div>
            @endif

            <div class="security-note mt-4">
                <i class="bi bi-shield-lock-fill me-2 text-primary"></i>
                Access is restricted to authorized users. Your assigned role
                determines which features you can access.
            </div>
        </div>
    </main>
</div>

<script>
    function togglePassword(id, button) {
        const input = document.getElementById(id);
        const icon = button.querySelector('i');
        const show = input.type === 'password';

        input.type = show ? 'text' : 'password';
        icon.classList.toggle('bi-eye', !show);
        icon.classList.toggle('bi-eye-slash', show);
    }
</script>
</body>
</html>
