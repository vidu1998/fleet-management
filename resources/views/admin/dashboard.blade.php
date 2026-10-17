@extends('layouts.admin')

@section('title', 'Dashboard')
@section('header', 'Dashboard Overview')

@section('content')

<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div>
        <h1 class="page-heading">Welcome back, {{ auth()->user()->name }}!</h1>

        <p class="muted mb-0">
            @if ($role === 'admin')
                Monitor users, drivers, vehicles, and approval activity across your fleet.
            @elseif ($role === 'maker')
                Submit driver information and track your Maker–Checker requests.
            @else
                Review driver submissions and manage your pending approvals.
            @endif
        </p>
    </div>

    @if ($role === 'admin')
        <a href="{{ route('admin.users.index') }}" class="btn btn-primary px-4 py-2">
            <i class="bi bi-people me-2"></i>Manage Users
        </a>
    @elseif ($role === 'maker')
        <a href="{{ route('drivers.create') }}" class="btn btn-primary px-4 py-2">
            <i class="bi bi-person-plus me-2"></i>Submit New Driver
        </a>
    @elseif ($role === 'checker')
        <a href="{{ route('driver-approvals.index') }}" class="btn btn-primary px-4 py-2">
            <i class="bi bi-clipboard-check me-2"></i>Review Requests
        </a>
    @endif
</div>

{{-- SUPER ADMIN DASHBOARD --}}
@if ($role === 'admin')

    <div class="row g-4 mb-4">
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="muted">Total Users</span>
                    <div class="stat-icon bg-primary-subtle text-primary">
                        <i class="bi bi-people-fill"></i>
                    </div>
                </div>
                <div class="stat-number">{{ $totalUsers }}</div>
                <small class="muted">Registered accounts</small>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="muted">Makers</span>
                    <div class="stat-icon bg-success-subtle text-success">
                        <i class="bi bi-pencil-square"></i>
                    </div>
                </div>
                <div class="stat-number">{{ $totalMakers }}</div>
                <small class="muted">Users who submit changes</small>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="muted">Checkers</span>
                    <div class="stat-icon bg-warning-subtle text-warning">
                        <i class="bi bi-shield-check"></i>
                    </div>
                </div>
                <div class="stat-number">{{ $totalCheckers }}</div>
                <small class="muted">Users who review changes</small>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="muted">Super Admins</span>
                    <div class="stat-icon bg-info-subtle text-info">
                        <i class="bi bi-person-lock"></i>
                    </div>
                </div>
                <div class="stat-number">{{ $superAdmins }}</div>
                <small class="muted">Privileged accounts</small>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-12 col-sm-6">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="muted">Approved Drivers</span>
                    <div class="stat-icon bg-success-subtle text-success">
                        <i class="bi bi-truck"></i>
                    </div>
                </div>
                <div class="stat-number">{{ $totalDrivers }}</div>
                <small class="muted">Active driver records</small>
            </div>
        </div>

        <div class="col-12 col-sm-6">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="muted">Pending Driver Requests</span>
                    <div class="stat-icon bg-warning-subtle text-warning">
                        <i class="bi bi-clock-history"></i>
                    </div>
                </div>
                <div class="stat-number">{{ $pendingRequests }}</div>
                <small class="muted">Waiting for Checker review</small>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-12 col-sm-6">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="muted">Approved Vehicles</span>
                    <div class="stat-icon bg-info-subtle text-info">
                        <i class="bi bi-truck"></i>
                    </div>
                </div>
                <div class="stat-number">{{ $totalVehicles ?? 0 }}</div>
                <small class="muted">Active fleet vehicle records</small>
            </div>
        </div>

        <div class="col-12 col-sm-6">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="muted">Pending Vehicle Requests</span>
                    <div class="stat-icon bg-warning-subtle text-warning">
                        <i class="bi bi-clock-history"></i>
                    </div>
                </div>
                <div class="stat-number">{{ $pendingVehicleRequestsCount ?? 0 }}</div>
                <small class="muted">Waiting for Checker review</small>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-12 col-xl-8">
            <div class="content-card h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h5 class="fw-bold mb-1">Recently Registered Users</h5>
                        <small class="muted">Latest accounts in the system</small>
                    </div>

                    <a href="{{ route('admin.users.index') }}"
                       class="text-decoration-none fw-semibold">
                        View all <i class="bi bi-arrow-right"></i>
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Role</th>
                                <th>Registered</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recentUsers as $user)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="avatar">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="fw-semibold">{{ $user->name }}</div>
                                                <small class="muted">{{ $user->email }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if ($user->is_super_admin)
                                            <span class="badge text-bg-primary">Super Admin</span>
                                        @elseif ($user->role === 'checker')
                                            <span class="badge text-bg-warning">Checker</span>
                                        @else
                                            <span class="badge text-bg-success">Maker</span>
                                        @endif
                                    </td>
                                    <td>{{ $user->created_at?->format('d M Y') ?? '—' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center muted py-4">
                                        No users found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-12 col-xl-4">
            <div class="content-card h-100">
                <h5 class="fw-bold mb-1">Quick Actions</h5>
                <p class="muted small mb-4">Administrative tasks</p>

                <a href="{{ route('admin.users.index') }}"
                   class="d-flex align-items-center gap-3 p-3 border rounded-3 text-decoration-none text-dark mb-3">
                    <div class="stat-icon bg-primary-subtle text-primary">
                        <i class="bi bi-people"></i>
                    </div>
                    <div>
                        <div class="fw-semibold">User Management</div>
                        <small class="muted">Manage users and roles</small>
                    </div>
                    <i class="bi bi-chevron-right ms-auto muted"></i>
                </a>

                <a href="{{ route('drivers.index') }}"
                   class="d-flex align-items-center gap-3 p-3 border rounded-3 text-decoration-none text-dark mb-3">
                    <div class="stat-icon bg-success-subtle text-success">
                        <i class="bi bi-truck"></i>
                    </div>
                    <div>
                        <div class="fw-semibold">Driver Management</div>
                        <small class="muted">View approved drivers</small>
                    </div>
                    <i class="bi bi-chevron-right ms-auto muted"></i>
                </a>

                <a href="{{ route('vehicles.index') }}"
                   class="d-flex align-items-center gap-3 p-3 border rounded-3 text-decoration-none text-dark mb-3">
                    <div class="stat-icon bg-info-subtle text-info">
                        <i class="bi bi-truck"></i>
                    </div>
                    <div>
                        <div class="fw-semibold">Vehicle Management</div>
                        <small class="muted">View approved fleet vehicles</small>
                    </div>
                    <i class="bi bi-chevron-right ms-auto muted"></i>
                </a>

                <a href="{{ route('vehicle-approvals.index') }}"
                   class="d-flex align-items-center gap-3 p-3 border rounded-3 text-decoration-none text-dark mb-3">
                    <div class="stat-icon bg-info-subtle text-info">
                        <i class="bi bi-clipboard-check"></i>
                    </div>
                    <div>
                        <div class="fw-semibold">Vehicle Approval Queue</div>
                        <small class="muted">Review pending vehicle requests</small>
                    </div>
                    <i class="bi bi-chevron-right ms-auto muted"></i>
                </a>

                <a href="{{ route('driver-approvals.index') }}"
                   class="d-flex align-items-center gap-3 p-3 border rounded-3 text-decoration-none text-dark">
                    <div class="stat-icon bg-warning-subtle text-warning">
                        <i class="bi bi-clipboard-check"></i>
                    </div>
                    <div>
                        <div class="fw-semibold">Approval Queue</div>
                        <small class="muted">View pending requests</small>
                    </div>
                    <i class="bi bi-chevron-right ms-auto muted"></i>
                </a>
            </div>
        </div>
    </div>

{{-- MAKER DASHBOARD --}}
@elseif ($role === 'maker')

    <div class="row g-4 mb-4">
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card">
                <span class="muted">Approved Drivers</span>
                <div class="stat-number">{{ $totalDrivers }}</div>
                <small class="muted">Active fleet driver records</small>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card">
                <span class="muted">My Requests</span>
                <div class="stat-number">{{ $myRequests }}</div>
                <small class="muted">All my submissions</small>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card">
                <span class="muted">Pending</span>
                <div class="stat-number">{{ $pendingRequests }}</div>
                <small class="muted">Waiting for review</small>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card">
                <span class="muted">Approved / Rejected</span>
                <div class="stat-number">
                    {{ $approvedRequests }} / {{ $rejectedRequests }}
                </div>
                <small class="muted">My reviewed submissions</small>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-12 col-xl-8">
            <div class="content-card">
                <h5 class="fw-bold mb-3">My Recent Submissions</h5>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Request</th>
                                <th>Driver</th>
                                <th>Action</th>
                                <th>Submitted</th>
                                <th>Status</th>
                                <th>Checker Comment</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recentRequests as $item)
                                <tr>
                                    <td>#{{ $item->id }}</td>
                                    <td>
                                        {{ $item->driver?->name
                                            ?? data_get($item->payload, 'driver.name', 'New driver') }}
                                    </td>
                                    <td>{{ ucfirst($item->action) }}</td>
                                    <td>{{ $item->submitted_at?->format('d M Y H:i') ?? '—' }}</td>
                                    <td>
                                        @php
                                            $statusClass = match ($item->status) {
                                                'approved' => 'success',
                                                'rejected' => 'danger',
                                                default => 'warning text-dark',
                                            };
                                        @endphp
                                        <span class="badge bg-{{ $statusClass }}">
                                            {{ ucfirst($item->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $item->checker_comment ?: '—' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center muted py-4">
                                        You have not submitted any requests yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-12 col-xl-4">
            <div class="content-card">
                <h5 class="fw-bold mb-3">Quick Actions</h5>

                <a href="{{ route('drivers.create') }}"
                   class="d-flex align-items-center gap-3 p-3 border rounded-3 text-decoration-none text-dark mb-3">
                    <div class="stat-icon bg-primary-subtle text-primary">
                        <i class="bi bi-person-plus"></i>
                    </div>
                    <div>
                        <div class="fw-semibold">Submit New Driver</div>
                        <small class="muted">Create a request for approval</small>
                    </div>
                    <i class="bi bi-chevron-right ms-auto muted"></i>
                </a>

                <a href="{{ route('drivers.index') }}"
                   class="d-flex align-items-center gap-3 p-3 border rounded-3 text-decoration-none text-dark">
                    <div class="stat-icon bg-success-subtle text-success">
                        <i class="bi bi-people"></i>
                    </div>
                    <div>
                        <div class="fw-semibold">View Drivers</div>
                        <small class="muted">View active driver records</small>
                    </div>
                    <i class="bi bi-chevron-right ms-auto muted"></i>
                </a>
            </div>
        </div>
    </div>

{{-- CHECKER DASHBOARD --}}
@elseif ($role === 'checker')

    <div class="row g-4 mb-4">
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card">
                <span class="muted">Approved Drivers</span>
                <div class="stat-number">{{ $totalDrivers }}</div>
                <small class="muted">Active fleet driver records</small>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card">
                <span class="muted">Pending Requests</span>
                <div class="stat-number">{{ $pendingRequests }}</div>
                <small class="muted">Awaiting Checker review</small>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card">
                <span class="muted">Approved by Me</span>
                <div class="stat-number">{{ $approvedByMe }}</div>
                <small class="muted">Requests approved by you</small>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card">
                <span class="muted">Rejected by Me</span>
                <div class="stat-number">{{ $rejectedByMe }}</div>
                <small class="muted">Requests rejected by you</small>
            </div>
        </div>
    </div>

    <div class="content-card">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h5 class="fw-bold mb-1">Pending Driver Requests</h5>
                <small class="muted">Review submissions before applying changes</small>
            </div>
            <a href="{{ route('driver-approvals.index') }}"
               class="btn btn-primary">
                Open Approval Queue
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>Request</th>
                        <th>Driver</th>
                        <th>Action</th>
                        <th>Maker</th>
                        <th>Submitted</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pendingQueue as $item)
                        <tr>
                            <td>#{{ $item->id }}</td>
                            <td>
                                {{ $item->driver?->name
                                    ?? data_get($item->payload, 'driver.name', 'New driver') }}
                            </td>
                            <td>{{ ucfirst($item->action) }}</td>
                            <td>{{ $item->maker?->name ?? 'Unknown' }}</td>
                            <td>{{ $item->submitted_at?->format('d M Y H:i') ?? '—' }}</td>
                            <td>
                                <a href="{{ route('driver-approvals.show', $item) }}"
                                   class="btn btn-sm btn-outline-primary">
                                    Review
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center muted py-4">
                                No pending requests. You're up to date.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endif

@endsection