
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account | Fleet Management</title>

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
            color: var(--navy);
            font-family: "Segoe UI", Arial, sans-serif;
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

        .brand-logo, .brand-content, .brand-footer {
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
            flex-shrink: 0;
        }

        .eyebrow {
            color: #9fbcff;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 2px;
        }

        .brand-content { max-width: 510px; }

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
            margin-top: 30px;
        }

        .feature {
            display: flex;
            align-items: center;
            gap: 13px;
            color: #e0e9f8;
            font-size: 14px;
        }

        .feature i { color: #8db0ff; font-size: 20px; }

        .brand-footer { color: #aabbd3; font-size: 12px; }

        .form-panel {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 35px 24px;
        }

        .form-wrap { width: 100%; max-width: 440px; }

        .mobile-brand {
            display: none;
        }

        .form-heading h2 {
            font-weight: 800;
            font-size: 31px;
            letter-spacing: -.7px;
        }

        .muted { color: var(--muted); }

        .form-label {
            font-size: 13px;
            font-weight: 650;
            margin-bottom: 7px;
        }

        .input-group-text {
            background: white;
            color: #8190a5;
            border-right: 0;
            padding-left: 15px;
        }

        .form-control {
            min-height: 46px;
            border-left: 0;
            font-size: 14px;
        }

        .input-group:focus-within .input-group-text,
        .input-group:focus-within .form-control {
            border-color: var(--blue);
        }

        .form-control:focus { box-shadow: none; }

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
            padding: 12px;
            color: #60718c;
            font-size: 12px;
        }

        @media (max-width: 850px) {
            .auth-shell { grid-template-columns: 1fr; }
            .brand-panel { display: none; }
            .form-panel { padding: 30px 22px; }
            .mobile-brand {
                display: flex;
                align-items: center;
                gap: 10px;
                margin-bottom: 28px;
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
            <div class="eyebrow">GET STARTED</div>
            <h1>Your fleet.<br>Your operations.<br>One workspace.</h1>
            <p>
                Create your account to access the Fleet Management System
                using your assigned permissions.
            </p>

            <div class="feature-list">
                <div class="feature">
                    <i class="bi bi-person-check"></i>
                    <span>Personalized account access</span>
                </div>
                <div class="feature">
                    <i class="bi bi-shield-lock"></i>
                    <span>Controlled access to system features</span>
                </div>
                <div class="feature">
                    <i class="bi bi-clipboard-check"></i>
                    <span>Structured fleet operations</span>
                </div>
            </div>
        </div>

        <div class="brand-footer">
            &copy; {{ date('Y') }} Fleet Management System.
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
                <div class="eyebrow mb-2" style="color:#3d6df2">NEW ACCOUNT</div>
                <h2>Create your account</h2>
                <p class="muted mb-0">Fill in your details to get started.</p>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <div class="fw-semibold mb-1">Please check the following:</div>
                    <ul class="mb-0 ps-3 small">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">Full name</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                        <input
                            id="name"
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            class="form-control"
                            placeholder="Enter your full name"
                            autocomplete="name"
                            maxlength="255"
                            required
                            autofocus>
                    </div>
                    @error('name')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

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
                            maxlength="255"
                            required>
                    </div>
                    @error('email')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input
                            id="password"
                            type="password"
                            name="password"
                            class="form-control"
                            placeholder="Create a strong password"
                            autocomplete="new-password"
                            minlength="12"
                            required>
                        <button class="btn btn-outline-secondary"
                                type="button"
                                onclick="togglePassword('password', this)"
                                aria-label="Show or hide password">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                    <div class="form-text">Use at least 12 characters.</div>
                    @error('password')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="form-label">
                        Confirm password
                    </label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-shield-check"></i></span>
                        <input
                            id="password_confirmation"
                            type="password"
                            name="password_confirmation"
                            class="form-control"
                            placeholder="Enter your password again"
                            autocomplete="new-password"
                            minlength="12"
                            required>
                        <button class="btn btn-outline-secondary"
                                type="button"
                                onclick="togglePassword('password_confirmation', this)"
                                aria-label="Show or hide password confirmation">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary text-white w-100">
                    Create Account <i class="bi bi-arrow-right ms-2"></i>
                </button>
            </form>

            <div class="text-center mt-4 small muted">
                Already have an account?
                <a href="{{ route('login') }}" class="auth-link">Sign in</a>
            </div>

            <div class="security-note mt-4">
                <i class="bi bi-info-circle-fill me-2 text-primary"></i>
                Your account permissions depend on the role assigned by the
                system administrator.
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
