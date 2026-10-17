<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') | Fleet Management</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --sidebar-width: 270px;
            --navy: #17243a;
            --navy-light: #243650;
            --navy-hover: #2b405f;
            --accent: #4f7cff;
            --page-bg: #f4f7fb;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            background: var(--page-bg);
            color: #243047;
            font-family: Inter, "Segoe UI", Arial, sans-serif;
        }

        .sidebar {
            position: fixed;
            inset: 0 auto 0 0;
            width: var(--sidebar-width);
            background: linear-gradient(180deg, #17243a 0%, #111c2e 100%);
            color: white;
            padding: 20px 14px;
            overflow-y: auto;
            z-index: 1040;
            scrollbar-width: thin;
            scrollbar-color: #42516a transparent;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 4px 10px 22px;
            border-bottom: 1px solid #344158;
            margin-bottom: 20px;
        }

        .brand-icon {
            width: 44px;
            height: 44px;
            flex: 0 0 44px;
            border-radius: 13px;
            display: grid;
            place-items: center;
            background: linear-gradient(135deg, #648cff, #3c63e8);
            font-size: 22px;
            box-shadow: 0 6px 16px rgba(79, 124, 255, .25);
        }

        .brand-title { font-weight: 750; font-size: 16px; letter-spacing: .1px; }
        .brand-subtitle { font-size: 11px; color: #aebbd0; margin-top: 2px; }

        .nav-label {
            color: #8495af;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 1.35px;
            padding: 0 12px;
            margin: 22px 0 8px;
        }

        .side-link,
        .side-menu-toggle {
            display: flex;
            align-items: center;
            gap: 12px;
            width: 100%;
            color: #d2dbea;
            text-decoration: none;
            padding: 11px 12px;
            margin-bottom: 4px;
            border-radius: 10px;
            font-size: 13.5px;
            font-weight: 500;
            transition: background .18s ease, color .18s ease;
        }

        .side-link i,
        .side-menu-toggle > i:first-child {
            width: 20px;
            text-align: center;
            font-size: 17px;
            flex: 0 0 20px;
        }

        .side-link:hover,
        .side-link.active,
        .side-menu-toggle:hover,
        .side-menu-toggle[aria-expanded="true"] {
            background: var(--navy-light);
            color: #fff;
        }

        .side-link.active {
            background: #2b4163;
            box-shadow: inset 3px 0 0 #7194ff;
        }

        .side-menu-toggle {
            border: 0;
            background: transparent;
            text-align: left;
            cursor: pointer;
        }

        .side-menu-toggle .menu-chevron {
            margin-left: auto;
            width: auto;
            font-size: 12px;
            color: #91a1b8;
            transition: transform .2s ease;
        }

        .side-menu-toggle[aria-expanded="true"] .menu-chevron {
            transform: rotate(180deg);
        }

        .side-submenu {
            padding: 3px 0 7px 17px;
            margin: 0 0 5px 21px;
            border-left: 1px solid #3a4961;
        }

        .side-submenu .side-link {
            padding: 9px 10px;
            margin-bottom: 3px;
            font-size: 12.5px;
            color: #b9c6d9;
            gap: 10px;
        }

        .side-submenu .side-link i {
            font-size: 13px;
            width: 16px;
            flex-basis: 16px;
        }

        .side-submenu .side-link:hover,
        .side-submenu .side-link.active {
            color: #fff;
            background: #2b405f;
        }

        .menu-count {
            margin-left: auto;
            font-size: 10px;
            padding: 3px 6px;
            border-radius: 6px;
            background: rgba(255,255,255,.09);
            color: #cbd6e6;
        }

        .sidebar-footer {
            margin-top: 24px;
            padding-top: 14px;
            border-top: 1px solid #344158;
        }

        .main-area {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
        }

        .topbar {
            min-height: 76px;
            background: white;
            border-bottom: 1px solid #e6eaf1;
            padding: 16px 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            position: sticky;
            top: 0;
            z-index: 1020;
        }

        .page-content { padding: 30px; }

        .page-heading {
            font-size: 25px;
            font-weight: 750;
            margin-bottom: 6px;
            color: #17243a;
        }

        .muted { color: #7b8799; }

        .stat-card {
            background: white;
            border: 1px solid #e9edf4;
            border-radius: 14px;
            padding: 22px;
            height: 100%;
            box-shadow: 0 3px 12px rgba(20, 35, 60, .03);
        }

        .stat-icon {
            width: 46px;
            height: 46px;
            display: grid;
            place-items: center;
            border-radius: 12px;
            font-size: 21px;
        }

        .stat-number {
            font-size: 30px;
            font-weight: 750;
            color: #17243a;
            margin-top: 18px;
        }

        .content-card {
            background: white;
            border: 1px solid #e9edf4;
            border-radius: 14px;
            padding: 24px;
            box-shadow: 0 3px 12px rgba(20, 35, 60, .03);
        }

        .table > :not(caption) > * > * {
            padding: 14px 12px;
            vertical-align: middle;
        }

        .avatar {
            width: 38px;
            height: 38px;
            display: grid;
            place-items: center;
            background: #e9efff;
            color: #365bd6;
            border-radius: 50%;
            font-weight: 700;
        }

        .mobile-toggle { display: none; }
        .sidebar-backdrop { display: none; }

        @media (max-width: 900px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform .25s ease;
                box-shadow: 12px 0 35px rgba(10, 20, 35, .18);
            }

            .sidebar.show { transform: translateX(0); }
            .sidebar-backdrop.show {
                display: block;
                position: fixed;
                inset: 0;
                background: rgba(15, 23, 42, .45);
                z-index: 1030;
            }

            .main-area { margin-left: 0; }
            .page-content { padding: 20px 15px; }
            .topbar { padding: 15px; }
            .mobile-toggle { display: inline-block; }
        }
    </style>
    @stack('styles')
</head>
<body>

<aside class="sidebar" id="sidebar">
    <div class="brand">
        <div class="brand-icon">
            <i class="bi bi-car-front-fill"></i>
        </div>
        <div>
            <div class="brand-title">Fleet Manager</div>
            <div class="brand-subtitle">MANAGEMENT PORTAL</div>
        </div>
    </div>

    <div class="nav-label">WORKSPACE</div>

    <a href="{{ route('admin.dashboard') }}"
       class="side-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <i class="bi bi-grid-1x2-fill"></i>
        <span>Dashboard</span>
    </a>

    @if ((bool) auth()->user()?->is_super_admin)
        <div class="nav-label">ADMINISTRATION</div>

        <button class="side-menu-toggle {{ request()->routeIs('admin.users.*') ? 'active' : '' }}"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#adminMenu"
                aria-expanded="{{ request()->routeIs('admin.users.*') ? 'true' : 'false' }}"
                aria-controls="adminMenu">
            <i class="bi bi-shield-lock-fill"></i>
            <span>Administration</span>
            <i class="bi bi-chevron-down menu-chevron"></i>
        </button>

        <div class="collapse {{ request()->routeIs('admin.users.*') ? 'show' : '' }}" id="adminMenu">
            <div class="side-submenu">
                <a href="{{ route('admin.users.index') }}"
                   class="side-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="bi bi-people-fill"></i>
                    <span>User Management</span>
                </a>
            </div>
        </div>
    @endif

    <div class="nav-label">FLEET OPERATIONS</div>

    {{-- Driver menu --}}
    <button class="side-menu-toggle {{ request()->routeIs('drivers.*') ? 'active' : '' }}"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#driverMenu"
            aria-expanded="{{ request()->routeIs('drivers.*') ? 'true' : 'false' }}"
            aria-controls="driverMenu">
        <i class="bi bi-person-badge-fill"></i>
        <span>Driver Management</span>
        <i class="bi bi-chevron-down menu-chevron"></i>
    </button>
    <div class="collapse {{ request()->routeIs('drivers.*') ? 'show' : '' }}" id="driverMenu">
        <div class="side-submenu">
            <a href="{{ route('drivers.index') }}"
               class="side-link {{ request()->routeIs('drivers.index', 'drivers.show', 'drivers.edit') ? 'active' : '' }}">
                <i class="bi bi-list-ul"></i>
                <span>All Drivers</span>
            </a>
            @if (auth()->user()?->role === 'maker' && !(bool) auth()->user()?->is_super_admin)
                <a href="{{ route('drivers.create') }}"
                   class="side-link {{ request()->routeIs('drivers.create') ? 'active' : '' }}">
                    <i class="bi bi-person-plus"></i>
                    <span>Submit Driver Request</span>
                </a>
            @endif
        </div>
    </div>

    {{-- Vehicle menu --}}
    <button class="side-menu-toggle {{ request()->routeIs('vehicles.*') ? 'active' : '' }}"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#vehicleMenu"
            aria-expanded="{{ request()->routeIs('vehicles.*') ? 'true' : 'false' }}"
            aria-controls="vehicleMenu">
        <i class="bi bi-truck-front-fill"></i>
        <span>Vehicle Management</span>
        <i class="bi bi-chevron-down menu-chevron"></i>
    </button>
    <div class="collapse {{ request()->routeIs('vehicles.*') ? 'show' : '' }}" id="vehicleMenu">
        <div class="side-submenu">
            <a href="{{ route('vehicles.index') }}"
               class="side-link {{ request()->routeIs('vehicles.index', 'vehicles.show', 'vehicles.edit') ? 'active' : '' }}">
                <i class="bi bi-list-ul"></i>
                <span>All Vehicles</span>
            </a>
            @if (auth()->user()?->role === 'maker' && !(bool) auth()->user()?->is_super_admin)
                <a href="{{ route('vehicles.create') }}"
                   class="side-link {{ request()->routeIs('vehicles.create') ? 'active' : '' }}">
                    <i class="bi bi-plus-circle"></i>
                    <span>Register Vehicle</span>
                </a>
            @endif
        </div>
    </div>

    {{-- Approval menu --}}
    <button class="side-menu-toggle {{ request()->routeIs('driver-approvals.*', 'vehicle-approvals.*') ? 'active' : '' }}"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#approvalMenu"
            aria-expanded="{{ request()->routeIs('driver-approvals.*', 'vehicle-approvals.*') ? 'true' : 'false' }}"
            aria-controls="approvalMenu">
        <i class="bi bi-clipboard2-check-fill"></i>
        <span>Approvals</span>
        <i class="bi bi-chevron-down menu-chevron"></i>
    </button>
    <div class="collapse {{ request()->routeIs('driver-approvals.*', 'vehicle-approvals.*') ? 'show' : '' }}" id="approvalMenu">
        <div class="side-submenu">
            <a href="{{ route('driver-approvals.index') }}"
               class="side-link {{ request()->routeIs('driver-approvals.index', 'driver-approvals.show') ? 'active' : '' }}">
                <i class="bi bi-person-check"></i>
                <span>Driver Approvals</span>
            </a>
            <a href="{{ route('vehicle-approvals.index') }}"
               class="side-link {{ request()->routeIs('vehicle-approvals.index', 'vehicle-approvals.show') ? 'active' : '' }}">
                <i class="bi bi-truck"></i>
                <span>Vehicle Approvals</span>
            </a>
            <a href="{{ route('vehicle-approvals.approved-history') }}"
               class="side-link {{ request()->routeIs('vehicle-approvals.approved-history') ? 'active' : '' }}">
                <i class="bi bi-clock-history"></i>
                <span>Vehicle Approval History</span>
            </a>
            @if (Route::has('driver-approvals.approved-history'))
                <a href="{{ route('driver-approvals.approved-history') }}"
                   class="side-link {{ request()->routeIs('driver-approvals.approved-history') ? 'active' : '' }}">
                    <i class="bi bi-journal-check"></i>
                    <span>Driver Approval History</span>
                </a>
            @endif
        </div>
    </div>

    {{-- Future modules are grouped but not linked until routes exist --}}
    <button class="side-menu-toggle {{ request()->routeIs('licences.*') ? 'active' : '' }}"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#licenceMenu"
            aria-expanded="{{ request()->routeIs('licences.*') ? 'true' : 'false' }}"
            aria-controls="licenceMenu">
        <i class="bi bi-card-checklist"></i>
        <span>Licences</span>
        <i class="bi bi-chevron-down menu-chevron"></i>
    </button>
    <div class="collapse {{ request()->routeIs('licences.*') ? 'show' : '' }}" id="licenceMenu">
        <div class="side-submenu">
            <span class="side-link text-secondary"><i class="bi bi-hourglass"></i><span>Module coming soon</span></span>
        </div>
    </div>

    <button class="side-menu-toggle {{ request()->routeIs('acknowledgements.*') ? 'active' : '' }}"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#acknowledgementMenu"
            aria-expanded="{{ request()->routeIs('acknowledgements.*') ? 'true' : 'false' }}"
            aria-controls="acknowledgementMenu">
        <i class="bi bi-file-earmark-check-fill"></i>
        <span>Acknowledgements</span>
        <i class="bi bi-chevron-down menu-chevron"></i>
    </button>
    <div class="collapse {{ request()->routeIs('acknowledgements.*') ? 'show' : '' }}" id="acknowledgementMenu">
        <div class="side-submenu">
            <span class="side-link text-secondary"><i class="bi bi-hourglass"></i><span>Module coming soon</span></span>
        </div>
    </div>

    <div class="sidebar-footer">
        <div class="nav-label mt-0">ACCOUNT</div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="side-link border-0 bg-transparent w-100 text-start">
                <i class="bi bi-box-arrow-right"></i>
                <span>Logout</span>
            </button>
        </form>
    </div>
</aside>

<div class="sidebar-backdrop" id="sidebarBackdrop"
     onclick="document.getElementById('sidebar').classList.remove('show'); this.classList.remove('show')"></div>

<div class="main-area">
    <header class="topbar">
        <div class="d-flex align-items-center gap-3">
            <button class="btn btn-light mobile-toggle"
                    type="button"
                    aria-label="Open navigation"
                    onclick="document.getElementById('sidebar').classList.toggle('show'); document.getElementById('sidebarBackdrop').classList.toggle('show')">
                <i class="bi bi-list fs-5"></i>
            </button>

            <div>
                <div class="fw-semibold">@yield('header', 'Dashboard Overview')</div>
                <small class="muted">Vehicle Fleet Management System</small>
            </div>
        </div>

        <div class="d-flex align-items-center gap-3">
            <div class="text-end d-none d-sm-block">
                <div class="fw-semibold">{{ auth()->user()->name }}</div>
                <small class="muted">
                    {{ auth()->user()->is_super_admin ? 'Super Admin' : ucfirst(auth()->user()->role) }}
                </small>
            </div>
            <div class="avatar">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
        </div>
    </header>

    <main class="page-content">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // On mobile, close the sidebar after navigating to a page.
    document.querySelectorAll('.sidebar .side-link[href]').forEach(function (link) {
        link.addEventListener('click', function () {
            if (window.innerWidth <= 900) {
                document.getElementById('sidebar').classList.remove('show');
                document.getElementById('sidebarBackdrop').classList.remove('show');
            }
        });
    });
</script>
</body>
</html>
