
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fleet Management | Smart Fleet Operations</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --navy: #0b1530;
            --navy-light: #14294c;
            --blue: #4778ff;
            --cyan: #4bd8ed;
            --muted: #a8b6d0;
        }

        * { box-sizing: border-box; }

        html { scroll-behavior: smooth; }

        body {
            margin: 0;
            background: var(--navy);
            color: #fff;
            font-family: "Segoe UI", Arial, sans-serif;
            overflow-x: hidden;
        }

        a { text-decoration: none; }

        /* Navigation */
        .navbar {
            position: absolute;
            top: 0;
            width: 100%;
            z-index: 10;
            padding: 22px 0;
            border-bottom: 1px solid rgba(255,255,255,.08);
            background: rgba(11,21,48,.5);
            backdrop-filter: blur(14px);
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            color: white;
            font-weight: 750;
            font-size: 18px;
        }

        .brand:hover { color: white; }

        .brand-icon {
            width: 43px;
            height: 43px;
            border-radius: 13px;
            display: grid;
            place-items: center;
            color: white;
            background: linear-gradient(135deg, var(--blue), #6556e8);
            box-shadow: 0 8px 25px #4778ff45;
            font-size: 23px;
        }

        .nav-link-custom {
            color: #bdc9de;
            font-size: 14px;
            padding: 10px 15px;
            transition: color .2s;
        }

        .nav-link-custom:hover { color: white; }

        .btn-primary-custom {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            border: 1px solid var(--blue);
            border-radius: 9px;
            padding: 12px 21px;
            color: white;
            background: var(--blue);
            font-weight: 650;
            font-size: 14px;
            transition: transform .25s, box-shadow .25s, background .25s;
        }

        .btn-primary-custom:hover {
            color: white;
            background: #3565ec;
            transform: translateY(-3px);
            box-shadow: 0 12px 30px #4778ff40;
        }

        .btn-outline-custom {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            border: 1px solid #60708d80;
            border-radius: 9px;
            padding: 12px 21px;
            color: white;
            font-weight: 600;
            font-size: 14px;
            transition: .25s;
        }

        .btn-outline-custom:hover {
            color: white;
            border-color: #9ab0d8;
            background: #ffffff0c;
            transform: translateY(-3px);
        }

        /* Hero */
        .hero {
            position: relative;
            min-height: 760px;
            display: flex;
            align-items: center;
            padding: 145px 0 85px;
            overflow: hidden;
            background:
                radial-gradient(ellipse at 78% 42%, #214e913b, transparent 37%),
                linear-gradient(125deg, #0b1530 5%, #101f40 55%, #0b1530 100%);
        }

        .hero::before {
            content: "";
            position: absolute;
            inset: 0;
            opacity: .15;
            pointer-events: none;
            background-image:
                linear-gradient(#a5c4ff13 1px, transparent 1px),
                linear-gradient(90deg, #a5c4ff13 1px, transparent 1px);
            background-size: 48px 48px;
            mask-image: linear-gradient(to bottom, black, transparent 90%);
        }

        .glow {
            position: absolute;
            width: 420px;
            height: 420px;
            border-radius: 50%;
            background: #416dff18;
            filter: blur(65px);
            animation: glowPulse 6s ease-in-out infinite alternate;
        }

        .glow-one { top: 150px; right: 10%; }
        .glow-two { bottom: -230px; left: -130px; }

        .hero-copy {
            position: relative;
            z-index: 2;
            animation: fadeUp .9s ease both;
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            color: #9ebaff;
            background: #4778ff14;
            border: 1px solid #4778ff45;
            border-radius: 100px;
            padding: 9px 14px;
            font-size: 11px;
            font-weight: 750;
            letter-spacing: 1.4px;
            text-transform: uppercase;
        }

        .live-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: #51e1b5;
            box-shadow: 0 0 12px #51e1b5;
            animation: blink 2s infinite;
        }

        .hero h1 {
            margin: 25px 0 22px;
            max-width: 650px;
            font-size: clamp(43px, 5.2vw, 69px);
            font-weight: 800;
            letter-spacing: -2.7px;
            line-height: 1.08;
        }

        .gradient-text {
            color: #85a7ff;
            background: linear-gradient(95deg, #89aaff, #5ce2ed);
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero-description {
            max-width: 520px;
            color: #a9b8d1;
            font-size: 16px;
            line-height: 1.85;
        }

        .hero-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 13px;
            margin-top: 31px;
        }

        .hero-note {
            color: #8b9bb8;
            font-size: 12px;
            margin-top: 24px;
        }

        .hero-note i { color: #64d8b2; }

        /* Animated illustration */
        .visual-area {
            position: relative;
            min-height: 480px;
            display: grid;
            place-items: center;
            animation: fadeUp 1.1s .2s ease both;
        }

        .orbit {
            position: absolute;
            width: min(100%, 465px);
            aspect-ratio: 1;
            border: 1px solid #769cff20;
            border-radius: 50%;
            animation: rotate 35s linear infinite;
        }

        .orbit::before {
            content: "";
            position: absolute;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: var(--cyan);
            box-shadow: 0 0 20px var(--cyan);
            top: 12%;
            left: 22%;
        }

        .orbit-two {
            width: min(84%, 385px);
            border-style: dashed;
            border-color: #6e8bff30;
            animation-direction: reverse;
            animation-duration: 50s;
        }

        .vehicle-scene {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 500px;
            animation: vehicleFloat 5s ease-in-out infinite;
        }

        .vehicle-scene svg {
            width: 100%;
            overflow: visible;
            filter: drop-shadow(0 25px 35px #00000040);
        }

        .road {
            position: absolute;
            left: 3%;
            right: 3%;
            bottom: 7%;
            height: 2px;
            background: linear-gradient(90deg, transparent, #4bd8ed8a, transparent);
            box-shadow: 0 0 25px #4bd8ed60;
        }

        .float-card {
            position: absolute;
            z-index: 3;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 15px 17px;
            border: 1px solid #7c9edb30;
            border-radius: 14px;
            background: #132748e8;
            backdrop-filter: blur(16px);
            box-shadow: 0 15px 45px #00000025;
            animation: cardFloat 5s ease-in-out infinite;
        }

        .float-card.one { top: 15%; left: -1%; }
        .float-card.two { right: -2%; bottom: 19%; animation-delay: -2.5s; }

        .float-icon {
            width: 40px;
            height: 40px;
            display: grid;
            place-items: center;
            border-radius: 11px;
            color: #8fb0ff;
            background: #4778ff25;
            font-size: 20px;
        }

        .float-label { color: #9aabc6; font-size: 10px; }
        .float-value { color: white; font-size: 14px; font-weight: 750; }
        .float-positive { color: #57dfb3; font-size: 10px; }

        /* Stats */
        .stats-section {
            position: relative;
            z-index: 2;
            margin-top: -1px;
            padding: 0 0 75px;
            background: #0d1934;
        }

        .stats-wrap {
            border: 1px solid #ffffff10;
            border-radius: 18px;
            background: linear-gradient(120deg, #152747, #101f3c);
            padding: 28px 20px;
        }

        .stat-item {
            text-align: center;
            padding: 12px;
        }

        .stat-number {
            font-size: 29px;
            font-weight: 800;
            letter-spacing: -1px;
        }

        .stat-caption {
            margin-top: 5px;
            color: #9eafca;
            font-size: 12px;
        }

        .stat-icon {
            color: #8db0ff;
            font-size: 22px;
            margin-bottom: 8px;
        }

        /* Features */
        .features-section {
            padding: 85px 0 100px;
            background: #f5f8fd;
            color: var(--navy);
        }

        .section-eyebrow {
            color: #4778ff;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 2px;
        }

        .section-title {
            margin-top: 13px;
            font-size: clamp(30px, 4vw, 43px);
            font-weight: 800;
            letter-spacing: -1.3px;
        }

        .section-description {
            max-width: 560px;
            margin: 14px auto 0;
            color: #718099;
            line-height: 1.8;
        }

        .feature-card {
            height: 100%;
            padding: 28px;
            border: 1px solid #e6ebf4;
            border-radius: 16px;
            background: white;
            transition: transform .3s, box-shadow .3s, border-color .3s;
        }

        .feature-card:hover {
            transform: translateY(-7px);
            border-color: #cbd8ff;
            box-shadow: 0 20px 45px #1d35620e;
        }

        .feature-card-icon {
            width: 53px;
            height: 53px;
            display: grid;
            place-items: center;
            border-radius: 15px;
            background: #edf2ff;
            color: #4778ff;
            font-size: 25px;
            margin-bottom: 22px;
        }

        .feature-card h3 {
            font-size: 17px;
            font-weight: 750;
            margin-bottom: 11px;
        }

        .feature-card p {
            color: #77859b;
            font-size: 13px;
            line-height: 1.8;
            margin: 0;
        }

        /* Bottom call to action */
        .cta-section {
            padding: 65px 0;
            background:
                radial-gradient(ellipse at 50% 100%, #315cc333, transparent 65%),
                #101f3c;
        }

        .cta-box {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 25px;
            flex-wrap: wrap;
        }

        .cta-box h2 {
            font-size: clamp(26px, 3vw, 36px);
            font-weight: 800;
            letter-spacing: -1px;
        }

        .cta-box p { color: #a9b8d1; margin: 0; }

        footer {
            padding: 25px 0;
            border-top: 1px solid #ffffff10;
            color: #8293b0;
            background: #0b1530;
            font-size: 12px;
        }

        /* Scroll entrance animations */
        .reveal {
            opacity: 0;
            transform: translateY(24px);
            transition: opacity .7s ease, transform .7s ease;
        }

        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(24px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes vehicleFloat {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-12px); }
        }

        @keyframes cardFloat {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-9px); }
        }

        @keyframes rotate {
            to { transform: rotate(360deg); }
        }

        @keyframes glowPulse {
            from { opacity: .5; transform: scale(.9); }
            to { opacity: 1; transform: scale(1.12); }
        }

        @keyframes blink {
            0%, 100% { opacity: 1; }
            50% { opacity: .35; }
        }

        @media (max-width: 991px) {
            .hero { padding-top: 135px; }
            .visual-area { min-height: 410px; margin-top: 25px; }
            .float-card.one { left: 2%; }
            .float-card.two { right: 1%; }
        }

        @media (max-width: 575px) {
            .navbar { padding: 15px 0; }
            .brand { font-size: 15px; gap: 8px; }
            .brand-icon { width: 38px; height: 38px; font-size: 20px; }
            .hero { min-height: auto; padding: 125px 0 55px; }
            .hero h1 { letter-spacing: -1.7px; }
            .hero-description { font-size: 14px; }
            .visual-area { min-height: 340px; }
            .float-card { padding: 10px; gap: 8px; }
            .float-card.one { top: 8%; left: 0; }
            .float-card.two { bottom: 10%; right: 0; }
            .float-icon { width: 32px; height: 32px; font-size: 16px; }
            .float-value { font-size: 12px; }
            .float-label, .float-positive { font-size: 9px; }
            .stats-wrap { padding: 16px 8px; }
            .stat-number { font-size: 24px; }
            .features-section { padding: 65px 0; }
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation-duration: .01ms !important;
                animation-iteration-count: 1 !important;
                scroll-behavior: auto !important;
                transition-duration: .01ms !important;
            }

            .reveal { opacity: 1; transform: none; }
        }
    </style>
</head>
<body>

{{-- Navigation --}}
<nav class="navbar">
    <div class="container d-flex align-items-center justify-content-between">
        <a href="{{ url('/') }}" class="brand">
            <span class="brand-icon"><i class="bi bi-truck-front-fill"></i></span>
            <span>
                Fleet Management
                <span class="d-block fw-normal" style="font-size:10px;color:#9bacca;letter-spacing:1px">
                    OPERATIONS PORTAL
                </span>
            </span>
        </a>

        <div class="d-flex align-items-center gap-2">
            @auth
                <a href="{{ route('dashboard') }}" class="btn-primary-custom">
                    My Dashboard <i class="bi bi-arrow-right"></i>
                </a>
            @else
                <a href="{{ route('login') }}" class="nav-link-custom d-none d-sm-inline-block">
                    Sign In
                </a>
                <a href="{{ route('register') }}" class="btn-primary-custom">
                    Get Started <i class="bi bi-arrow-up-right"></i>
                </a>
            @endauth
        </div>
    </div>
</nav>

{{-- Hero section --}}
<section class="hero">
    <div class="glow glow-one"></div>
    <div class="glow glow-two"></div>

    <div class="container position-relative">
        <div class="row align-items-center g-4">

            <div class="col-lg-6">
                <div class="hero-copy">
                    <div class="eyebrow">
                        <span class="live-dot"></span>
                        SMART FLEET OPERATIONS
                    </div>

                    <h1>
                        Every vehicle.<br>
                        Every journey.<br>
                        <span class="gradient-text">Under control.</span>
                    </h1>

                    <p class="hero-description">
                        Bring your fleet operations together in one workspace.
                        Manage vehicles, organize driver records, track mileage
                        and streamline Maker–Checker approvals.
                    </p>

                    <div class="hero-actions">
                        @auth
                            <a href="{{ route('dashboard') }}" class="btn-primary-custom">
                                Go to Dashboard
                                <i class="bi bi-arrow-right"></i>
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn-primary-custom">
                                <i class="bi bi-box-arrow-in-right"></i>
                                Sign In to Continue
                            </a>

                            <a href="{{ route('register') }}" class="btn-outline-custom">
                                Create Account
                                <i class="bi bi-arrow-up-right"></i>
                            </a>
                        @endauth
                    </div>

                    <div class="hero-note">
                        <i class="bi bi-shield-check me-2"></i>
                        Role-based access &bull; Controlled approvals &bull; Organized records
                    </div>
                </div>
            </div>

            {{-- Animated vehicle illustration --}}
            <div class="col-lg-6">
                <div class="visual-area">
                    <div class="orbit"></div>
                    <div class="orbit orbit-two"></div>

                    <div class="vehicle-scene">
                        <svg viewBox="0 0 560 390" role="img" aria-label="Illustration of a fleet vehicle">
                            <defs>
                                <linearGradient id="bodyPaint" x1="0" y1="0" x2="1" y2="1">
                                    <stop offset="0%" stop-color="#76a4ff"/>
                                    <stop offset="55%" stop-color="#4778ff"/>
                                    <stop offset="100%" stop-color="#254ec2"/>
                                </linearGradient>
                                <linearGradient id="glass" x1="0" y1="0" x2="1" y2="1">
                                    <stop offset="0%" stop-color="#b8f2ff"/>
                                    <stop offset="100%" stop-color="#3766a4"/>
                                </linearGradient>
                                <linearGradient id="roadGlow" x1="0" y1="0" x2="1" y2="0">
                                    <stop offset="0%" stop-color="#4bd8ed" stop-opacity="0"/>
                                    <stop offset="50%" stop-color="#4bd8ed" stop-opacity=".6"/>
                                    <stop offset="100%" stop-color="#4bd8ed" stop-opacity="0"/>
                                </linearGradient>
                            </defs>

                            <ellipse cx="280" cy="325" rx="220" ry="27" fill="#000" opacity=".24"/>
                            <ellipse cx="280" cy="320" rx="195" ry="12" fill="url(#roadGlow)" opacity=".8"/>

                            {{-- Motion trails --}}
                            <path d="M40 205 H110 M20 225 H95 M62 245 H120"
                                  stroke="#4bd8ed" stroke-width="2" opacity=".4" stroke-linecap="round"/>
                            <path d="M420 200 H500 M450 220 H525 M435 240 H485"
                                  stroke="#8baaff" stroke-width="2" opacity=".3" stroke-linecap="round"/>

                            {{-- Vehicle shadow and body --}}
                            <path d="M105 255 L126 219 L155 198 L190 140
                                     Q203 119 233 117 L337 117
                                     Q357 119 372 139 L415 193
                                     L452 208 Q468 216 472 239
                                     L472 274 L89 274 L89 251 Z"
                                  fill="#101b31" opacity=".6"
                                  transform="translate(0 12)"/>

                            <path d="M105 255 L126 219 L155 198 L190 140
                                     Q203 119 233 117 L337 117
                                     Q357 119 372 139 L415 193
                                     L452 208 Q468 216 472 239
                                     L472 274 L89 274 L89 251 Z"
                                  fill="url(#bodyPaint)" stroke="#9bb9ff" stroke-opacity=".5" stroke-width="2"/>

                            {{-- Windshield --}}
                            <path d="M190 145 Q201 128 229 127 L267 127 L267 192 L157 192 Z"
                                  fill="url(#glass)" stroke="#b7d8ff" stroke-width="2"/>
                            <path d="M278 127 L335 127 Q349 128 361 145 L395 192 L278 192 Z"
                                  fill="url(#glass)" stroke="#b7d8ff" stroke-width="2"/>

                            {{-- Windows reflections --}}
                            <path d="M204 139 L228 132 L228 184 L174 184 Z"
                                  fill="#fff" opacity=".13"/>
                            <path d="M293 133 L334 133 L344 145 L293 145 Z"
                                  fill="#fff" opacity=".2"/>

                            {{-- Body details --}}
                            <path d="M110 257 H451" stroke="#9fbbff" stroke-opacity=".5" stroke-width="2"/>
                            <path d="M116 226 H145 L137 245 H105 Z" fill="#d9f5ff"/>
                            <path d="M435 216 L460 226 L462 240 L445 240 Z" fill="#ffb59d"/>
                            <rect x="257" y="212" width="47" height="30" rx="7"
                                  fill="#1d438c" stroke="#9cb8ff" stroke-opacity=".7"/>
                            <path d="M270 221 H292 M270 228 H288"
                                  stroke="#8bdfff" stroke-width="2" stroke-linecap="round"/>
                            <path d="M91 250 H469" stroke="#152a56" stroke-width="5"/>
                            <path d="M150 269 H415" stroke="#d4e3ff" stroke-opacity=".3" stroke-width="2"/>

                            {{-- Wheels --}}
                            <g>
                                <circle cx="173" cy="267" r="38" fill="#101a2c"/>
                                <circle cx="173" cy="267" r="25" fill="#273c5b" stroke="#9bb4dc" stroke-width="3"/>
                                <circle cx="173" cy="267" r="10" fill="#8da6c9"/>
                                <circle cx="173" cy="267" r="4" fill="#243550"/>
                                <path d="M173 246 V258 M173 276 V288 M152 267 H164 M182 267 H194"
                                      stroke="#d2e2f8" stroke-width="3" stroke-linecap="round"/>
                            </g>
                            <g>
                                <circle cx="390" cy="267" r="38" fill="#101a2c"/>
                                <circle cx="390" cy="267" r="25" fill="#273c5b" stroke="#9bb4dc" stroke-width="3"/>
                                <circle cx="390" cy="267" r="10" fill="#8da6c9"/>
                                <circle cx="390" cy="267" r="4" fill="#243550"/>
                                <path d="M390 246 V258 M390 276 V288 M369 267 H381 M399 267 H411"
                                      stroke="#d2e2f8" stroke-width="3" stroke-linecap="round"/>
                            </g>

                            {{-- Headlights --}}
                            <path d="M98 246 L130 246 L124 254 L94 254 Z" fill="#dffbff"/>
                            <path d="M466 242 L480 248 L480 254 L467 254 Z" fill="#ffd1a3"/>

                            {{-- Decorative tracking signal --}}
                            <circle cx="280" cy="84" r="26" fill="#4778ff" opacity=".12"/>
                            <circle cx="280" cy="84" r="18" fill="#4778ff" opacity=".2"/>
                            <circle cx="280" cy="84" r="10" fill="#4bd8ed"/>
                            <circle cx="280" cy="84" r="4" fill="#fff"/>
                            <path d="M280 101 V116" stroke="#4bd8ed" stroke-width="2" stroke-dasharray="3 4" opacity=".8"/>
                        </svg>
                    </div>

                    <div class="float-card one">
                        <div class="float-icon"><i class="bi bi-speedometer2"></i></div>
                        <div>
                            <div class="float-label">MILEAGE TRACKING</div>
                            <div class="float-value">Records organized</div>
                            <div class="float-positive">
                                <i class="bi bi-check-circle-fill me-1"></i>Manual entry ready
                            </div>
                        </div>
                    </div>

                    <div class="float-card two">
                        <div class="float-icon" style="color:#57dfb3;background:#57dfb318">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <div>
                            <div class="float-label">WORKFLOW CONTROL</div>
                            <div class="float-value">Maker–Checker</div>
                            <div class="float-positive">Role-based access</div>
                        </div>
                    </div>

                    <div class="road"></div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Summary strip: these are capabilities, not live system metrics --}}
<section class="stats-section">
    <div class="container">
        <div class="stats-wrap reveal">
            <div class="row g-3">
                <div class="col-6 col-lg-3">
                    <div class="stat-item">
                        <div class="stat-icon"><i class="bi bi-truck-front"></i></div>
                        <div class="stat-number">Fleet</div>
                        <div class="stat-caption">Vehicle management</div>
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="stat-item">
                        <div class="stat-icon"><i class="bi bi-person-badge"></i></div>
                        <div class="stat-number">Drivers</div>
                        <div class="stat-caption">Driver information</div>
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="stat-item">
                        <div class="stat-icon"><i class="bi bi-speedometer2"></i></div>
                        <div class="stat-number">Mileage</div>
                        <div class="stat-caption">Manual mileage records</div>
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="stat-item">
                        <div class="stat-icon"><i class="bi bi-shield-check"></i></div>
                        <div class="stat-number">Secure</div>
                        <div class="stat-caption">Controlled approvals</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Features --}}
<section class="features-section" id="features">
    <div class="container">
        <div class="text-center mb-5 reveal">
            <div class="section-eyebrow">BUILT FOR FLEET OPERATIONS</div>
            <h2 class="section-title">Everything organized.<br>Every action accountable.</h2>
            <p class="section-description">
                A central place to organize fleet information and support
                a controlled, accountable operational workflow.
            </p>
        </div>

        <div class="row g-4">
            <div class="col-md-6 col-lg-4 reveal">
                <div class="feature-card">
                    <div class="feature-card-icon"><i class="bi bi-truck-front-fill"></i></div>
                    <h3>Vehicle Management</h3>
                    <p>Keep vehicle details and fleet records organized in one workspace.</p>
                </div>
            </div>

            <div class="col-md-6 col-lg-4 reveal">
                <div class="feature-card">
                    <div class="feature-card-icon"><i class="bi bi-person-vcard-fill"></i></div>
                    <h3>Driver Records</h3>
                    <p>Manage driver information, licence details and related records.</p>
                </div>
            </div>

            <div class="col-md-6 col-lg-4 reveal">
                <div class="feature-card">
                    <div class="feature-card-icon"><i class="bi bi-speedometer"></i></div>
                    <h3>Mileage Management</h3>
                    <p>Maintain mileage entries to support fleet usage monitoring.</p>
                </div>
            </div>

            <div class="col-md-6 col-lg-4 reveal">
                <div class="feature-card">
                    <div class="feature-card-icon"><i class="bi bi-shield-lock-fill"></i></div>
                    <h3>Role-Based Access</h3>
                    <p>Separate Super Admin, Maker and Checker access according to assigned roles.</p>
                </div>
            </div>

            <div class="col-md-6 col-lg-4 reveal">
                <div class="feature-card">
                    <div class="feature-card-icon"><i class="bi bi-check2-square"></i></div>
                    <h3>Approval Workflow</h3>
                    <p>Build an accountable review process for submitted business changes.</p>
                </div>
            </div>

            <div class="col-md-6 col-lg-4 reveal">
                <div class="feature-card">
                    <div class="feature-card-icon"><i class="bi bi-clipboard-data-fill"></i></div>
                    <h3>Organized Records</h3>
                    <p>Keep operational information structured and easier to review.</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="cta-section">
    <div class="container">
        <div class="cta-box reveal">
            <div>
                <h2>Ready to manage your fleet?</h2>
                <p>Sign in to access your assigned Fleet Management workspace.</p>
            </div>

            @auth
                <a href="{{ route('dashboard') }}" class="btn-primary-custom">
                    Open Dashboard <i class="bi bi-arrow-right"></i>
                </a>
            @else
                <a href="{{ route('login') }}" class="btn-primary-custom">
                    Get Started <i class="bi bi-arrow-right"></i>
                </a>
            @endauth
        </div>
    </div>
</section>

<footer>
    <div class="container d-flex flex-wrap justify-content-between gap-2">
        <span>&copy; {{ date('Y') }} Fleet Management System</span>
        <span>Vehicle operations &bull; Driver records &bull; Approval controls</span>
    </div>
</footer>

<script>
    // Reveal sections as they enter the viewport.
    const revealItems = document.querySelectorAll('.reveal');

    if ('IntersectionObserver' in window) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.12 });

        revealItems.forEach((item) => observer.observe(item));
    } else {
        revealItems.forEach((item) => item.classList.add('visible'));
    }
</script>

</body>
</html>
