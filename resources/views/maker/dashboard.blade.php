
@extends('layouts.admin')

@section('title', 'Maker Dashboard')
@section('header', 'Maker Dashboard')

@section('content')
@php
    $requests = collect($myRequests ?? []);
    $vehicleRequests = collect($myVehicleRequests ?? []);

    $pendingCount = $pendingRequestCount
        ?? $requests->where('status', 'pending')->count()
           + $vehicleRequests->where('status', 'pending')->count();

    $approvedCount = $approvedRequestCount
        ?? $requests->where('status', 'approved')->count()
           + $vehicleRequests->where('status', 'approved')->count();

    $rejectedCount = $rejectedRequestCount
        ?? $requests->where('status', 'rejected')->count()
           + $vehicleRequests->where('status', 'rejected')->count();
@endphp

<div class="mb-4">
    <h1 class="page-heading">
        Welcome, {{ auth()->user()->name }}
    </h1>
    <p class="muted">
        Manage drivers and vehicles, submit changes, and track approvals.
    </p>
</div>

{{-- Summary Cards --}}
<div class="row g-4 mb-4">
    <div class="col-md-6 col-xl-3">
        <div class="stat-card h-100">
            <div class="stat-icon bg-primary-subtle text-primary">
                <i class="bi bi-people"></i>
            </div>
            <h3 class="mt-3 fw-bold">{{ $totalDrivers ?? 0 }}</h3>
            <h6 class="fw-bold">Active Drivers</h6>
            <p class="muted mb-0">Approved driver records.</p>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="stat-card h-100">
            <div class="stat-icon bg-info-subtle text-info">
                <i class="bi bi-truck"></i>
            </div>
            <h3 class="mt-3 fw-bold">{{ $totalVehicles ?? 0 }}</h3>
            <h6 class="fw-bold">Active Vehicles</h6>
            <p class="muted mb-0">Approved vehicle records.</p>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="stat-card h-100">
            <div class="stat-icon bg-warning-subtle text-warning">
                <i class="bi bi-clock-history"></i>
            </div>
            <h3 class="mt-3 fw-bold">{{ $pendingCount }}</h3>
            <h6 class="fw-bold">Pending Requests</h6>
            <p class="muted mb-0">Driver and vehicle requests awaiting review.</p>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="stat-card h-100">
            <div class="stat-icon bg-success-subtle text-success">
                <i class="bi bi-check-circle"></i>
            </div>
            <h3 class="mt-3 fw-bold">{{ $approvedCount }}</h3>
            <h6 class="fw-bold">Approved Requests</h6>
            <p class="muted mb-0">Requests approved by Checkers.</p>
        </div>
    </div>
</div>

{{-- Driver and Vehicle Actions --}}
<div class="row g-4 mb-4">
    <div class="col-md-6">
        <div class="stat-card h-100">
            <div class="stat-icon bg-primary-subtle text-primary">
                <i class="bi bi-person-plus"></i>
            </div>

            <h5 class="mt-3 fw-bold">Driver Management</h5>
            <p class="muted">
                Register drivers or view approved driver records.
            </p>

            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('drivers.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-1"></i> Add Driver
                </a>

                <a href="{{ route('drivers.index') }}"
                   class="btn btn-outline-primary">
                    <i class="bi bi-list-ul me-1"></i> View Drivers
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="stat-card h-100">
            <div class="stat-icon bg-info-subtle text-info">
                <i class="bi bi-truck"></i>
            </div>

            <h5 class="mt-3 fw-bold">Vehicle Management</h5>
            <p class="muted">
                Register vehicles or view approved fleet records.
            </p>

            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('vehicles.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-1"></i> Add Vehicle
                </a>

                <a href="{{ route('vehicles.index') }}"
                   class="btn btn-outline-primary">
                    <i class="bi bi-list-ul me-1"></i> View Vehicles
                </a>
            </div>
        </div>
    </div>
</div>

{{-- Recent Driver Requests --}}
<div class="stat-card mb-4">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
        <div>
            <h5 class="fw-bold mb-1">My Recent Driver Requests</h5>
            <p class="muted mb-0">Track your driver submissions.</p>
        </div>
        <span class="badge bg-secondary">{{ $requests->count() }} requests</span>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Driver</th>
                    <th>Action</th>
                    <th>Submitted</th>
                    <th>Status</th>
                    <th>Checker Comment</th>
                </tr>
            </thead>
            <tbody>
                @forelse($requests as $request)
                    <tr>
                        <td>#{{ $request->id }}</td>
                        <td>
                            {{ data_get($request->payload, 'driver.name')
                                ?? $request->driver?->name
                                ?? 'New Driver' }}
                        </td>
                        <td>{{ ucfirst($request->action) }}</td>
                        <td>
                            {{ $request->submitted_at?->format('d M Y, h:i A')
                                ?? $request->created_at?->format('d M Y, h:i A')
                                ?? '—' }}
                        </td>
                        <td>
                            @php
                                $statusClass = match ($request->status) {
                                    'pending' => 'bg-warning text-dark',
                                    'approved' => 'bg-success',
                                    'rejected' => 'bg-danger',
                                    default => 'bg-secondary',
                                };
                            @endphp
                            <span class="badge {{ $statusClass }}">
                                {{ ucfirst($request->status) }}
                            </span>
                        </td>
                        <td>{{ $request->checker_comment ?: '—' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 muted">
                            No driver requests submitted yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Recent Vehicle Requests --}}
<div class="stat-card">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
        <div>
            <h5 class="fw-bold mb-1">My Recent Vehicle Requests</h5>
            <p class="muted mb-0">Track your vehicle submissions.</p>
        </div>
        <span class="badge bg-secondary">
            {{ $vehicleRequests->count() }} requests
        </span>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Registration No.</th>
                    <th>Action</th>
                    <th>Submitted</th>
                    <th>Status</th>
                    <th>Checker Comment</th>
                </tr>
            </thead>
            <tbody>
                @forelse($vehicleRequests as $request)
                    <tr>
                        <td>#{{ $request->id }}</td>
                        <td>
                            {{ data_get($request->payload, 'vehicle.registration_no')
                                ?? $request->vehicle?->registration_no
                                ?? 'New Vehicle' }}
                        </td>
                        <td>{{ ucfirst($request->action) }}</td>
                        <td>
                            {{ $request->submitted_at?->format('d M Y, h:i A')
                                ?? $request->created_at?->format('d M Y, h:i A')
                                ?? '—' }}
                        </td>
                        <td>
                            @php
                                $statusClass = match ($request->status) {
                                    'pending' => 'bg-warning text-dark',
                                    'approved' => 'bg-success',
                                    'rejected' => 'bg-danger',
                                    default => 'bg-secondary',
                                };
                            @endphp
                            <span class="badge {{ $statusClass }}">
                                {{ ucfirst($request->status) }}
                            </span>
                        </td>
                        <td>{{ $request->checker_comment ?: '—' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 muted">
                            No vehicle requests submitted yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
