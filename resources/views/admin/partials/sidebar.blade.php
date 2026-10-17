```blade
<nav class="space-y-1 px-4 py-5">

    <p class="px-3 pb-2 text-xs font-semibold uppercase tracking-widest text-slate-500">
        Main Menu
    </p>

    {{-- Shared dashboard --}}
    <a href="{{ route('dashboard') }}"
        class="flex items-center gap-3 rounded-lg px-3 py-3 text-sm
       {{ request()->routeIs('dashboard', 'admin.dashboard', 'maker.dashboard', 'checker.dashboard')
            ? 'bg-indigo-600 text-white'
            : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
        <span>▦</span>
        Dashboard
    </a>

    <p class="px-3 pb-2 pt-5 text-xs font-semibold uppercase tracking-widest text-slate-500">
        Fleet Operations
    </p>

    {{-- Vehicles --}}
    <div class="flex items-center gap-3 rounded-lg px-3 py-3 text-sm text-slate-500">
        <span>🚘</span>
        Vehicles
        <span class="ml-auto text-xs">Coming soon</span>
    </div>

    {{-- Drivers --}}
    {{-- Drivers --}}
    <a href="{{ route('drivers.index') }}"
        class="flex items-center gap-3 rounded-lg px-3 py-3 text-sm
   {{ request()->routeIs('drivers.*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
        <span>♙</span>
        <span>Drivers</span>
    </a>

    {{-- Licences --}}
    <a href="{{ route('licences.index') }}"
        class="flex items-center gap-3 rounded-lg px-3 py-3 text-sm
   {{ request()->routeIs('licences.*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
        <span>▤</span>
        <span>Licences</span>
    </a>

    {{-- Acknowledgements --}}
    <a href="{{ route('acknowledgements.index') }}"
        class="flex items-center gap-3 rounded-lg px-3 py-3 text-sm
   {{ request()->routeIs('acknowledgements.*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
        <span>⚑</span>
        <span>Acknowledgements</span>
    </a>

    {{-- Reminders --}}
    <a href="{{ route('reminders.index') }}"
        class="flex items-center gap-3 rounded-lg px-3 py-3 text-sm
   {{ request()->routeIs('reminders.*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
        <span>🔔</span>
        <span>Reminders</span>
    </a>

    {{-- Licences: managed through Drivers for now --}}
    <a href="{{ route('drivers.index') }}"
        class="flex items-center gap-3 rounded-lg px-3 py-3 text-sm text-slate-300 hover:bg-slate-800 hover:text-white">
        <span>▤</span>
        Licences
        <span class="ml-auto text-xs">In Drivers</span>
    </a>

    {{-- Acknowledgements: managed through Drivers for now --}}
    <a href="{{ route('drivers.index') }}"
        class="flex items-center gap-3 rounded-lg px-3 py-3 text-sm text-slate-300 hover:bg-slate-800 hover:text-white">
        <span>⚑</span>
        Acknowledgements
        <span class="ml-auto text-xs">In Drivers</span>
    </a>

    {{-- Approval Queue: Checkers and Super Admins --}}
    @if (
    auth()->user()->role === 'checker' ||
    (bool) auth()->user()->is_super_admin
    )
    <p class="px-3 pb-2 pt-5 text-xs font-semibold uppercase tracking-widest text-slate-500">
        Approvals
    </p>

    <a href="{{ route('driver-approvals.index') }}"
        class="flex items-center gap-3 rounded-lg px-3 py-3 text-sm
           {{ request()->routeIs('driver-approvals.*')
                ? 'bg-indigo-600 text-white'
                : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
        <span>✓</span>
        Driver Approvals
    </a>
    @endif

    {{-- Maker-only shortcut --}}
    @if (
    auth()->user()->role === 'maker' &&
    !(bool) auth()->user()->is_super_admin
    )
    <a href="{{ route('drivers.create') }}"
        class="flex items-center gap-3 rounded-lg px-3 py-3 text-sm text-slate-300 hover:bg-slate-800 hover:text-white">
        <span>＋</span>
        Submit New Driver
    </a>
    @endif

    {{-- Super Admin administration --}}
    @if ((bool) auth()->user()->is_super_admin)
    <p class="px-3 pb-2 pt-5 text-xs font-semibold uppercase tracking-widest text-slate-500">
        Administration
    </p>

    <a href="{{ route('admin.users.index') }}"
        class="flex items-center gap-3 rounded-lg px-3 py-3 text-sm
           {{ request()->routeIs('admin.users.*')
                ? 'bg-indigo-600 text-white'
                : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
        <span>♙</span>
        User Management
        <span class="ml-auto rounded bg-indigo-500 px-2 py-0.5 text-xs">
            Admin
        </span>
    </a>
    @endif

</nav>
```