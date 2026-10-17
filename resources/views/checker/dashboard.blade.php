
@extends('layouts.admin')

@section('title', 'Checker Dashboard')
@section('header', 'Checker Dashboard')

@section('content')
<div class="container-fluid px-0">

    {{-- Welcome Header --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div>
            <h1 class="page-heading mb-1">
                Welcome, {{ auth()->user()->name }}
            </h1>
            <p class="text-secondary mb-0">
                Review driver and vehicle requests, manage approvals, and track approval history.
            </p>
        </div>

        <div class="text-secondary small">
            <i class="bi bi-calendar3 me-1"></i>
            {{ now()->format('d M Y') }}
        </div>
    </div>

    {{-- Overall Statistics --}}
    <div class="row g-3 mb-4">

        <div class="col-12 col-sm-6 col-xl-3">
            <a href="{{ route('driver-approvals.index') }}"
               class="text-decoration-none">
                <div class="card dashboard-stat-card stat-pending h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="dashboard-stat-icon bg-warning-subtle text-warning-emphasis">
                            <i class="bi bi-hourglass-split"></i>
                        </div>
                        <div>
                            <p class="text-secondary small mb-1">Pending Driver Requests</p>
                            <h3 class="fw-bold mb-0">{{ $pendingCount ?? 0 }}</h3>
                            <small class="text-secondary">Review drivers</small>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <a href="{{ route('vehicle-approvals.index') }}"
               class="text-decoration-none">
                <div class="card dashboard-stat-card stat-pending h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="dashboard-stat-icon bg-info-subtle text-info">
                            <i class="bi bi-truck"></i>
                        </div>
                        <div>
                            <p class="text-secondary small mb-1">Pending Vehicle Requests</p>
                            <h3 class="fw-bold mb-0">{{ $pendingVehicleCount ?? 0 }}</h3>
                            <small class="text-secondary">Review vehicles</small>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card dashboard-stat-card stat-approved h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="dashboard-stat-icon bg-success-subtle text-success">
                        <i class="bi bi-check-circle"></i>
                    </div>
                    <div>
                        <p class="text-secondary small mb-1">Approved by Me</p>
                        <h3 class="fw-bold mb-0">
                            {{ ($approvedCount ?? 0) + ($approvedVehicleCount ?? 0) }}
                        </h3>
                        <small class="text-secondary">Driver and vehicle requests</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card dashboard-stat-card stat-rejected h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="dashboard-stat-icon bg-danger-subtle text-danger">
                        <i class="bi bi-x-circle"></i>
                    </div>
                    <div>
                        <p class="text-secondary small mb-1">Rejected by Me</p>
                        <h3 class="fw-bold mb-0">
                            {{ ($rejectedCount ?? 0) + ($rejectedVehicleCount ?? 0) }}
                        </h3>
                        <small class="text-secondary">Driver and vehicle requests</small>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- Pending Driver Requests --}}
    <div class="card dashboard-main-card mb-4">
        <div class="card-header bg-white d-flex flex-wrap justify-content-between align-items-center gap-2 py-3">
            <div>
                <h5 class="fw-bold mb-1">
                    <i class="bi bi-people text-primary me-2"></i>
                    Pending Driver Requests
                </h5>
                <p class="text-secondary small mb-0">
                    Driver registrations and changes awaiting review.
                </p>
            </div>

            <a href="{{ route('driver-approvals.index') }}"
               class="btn btn-primary btn-sm">
                View All Driver Requests
                <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>

        <div class="card-body p-0">
            @if(isset($pendingRequests) && $pendingRequests->isNotEmpty())
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Request ID</th>
                                <th>Driver</th>
                                <th>Type</th>
                                <th>Submitted By</th>
                                <th>Submitted Date</th>
                                <th>Status</th>
                                <th class="text-end pe-4">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendingRequests as $request)
                                <tr>
                                    <td class="ps-4 fw-semibold">#{{ $request->id }}</td>
                                    <td>
                                        {{ data_get($request->payload, 'driver.name')
                                            ?? $request->driver?->name
                                            ?? 'New Driver' }}
                                    </td>
                                    <td>
                                        <span class="badge bg-info-subtle text-info-emphasis">
                                            {{ ucfirst($request->action) }}
                                        </span>
                                    </td>
                                    <td>{{ $request->maker?->name ?? 'Unknown' }}</td>
                                    <td>
                                        {{ $request->submitted_at?->format('d M Y, h:i A') ?? '—' }}
                                    </td>
                                    <td>
                                        <span class="badge bg-warning-subtle text-warning-emphasis">
                                            {{ ucfirst($request->status) }}
                                        </span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <a href="{{ route('driver-approvals.show', $request) }}"
                                           class="btn btn-outline-primary btn-sm">
                                            <i class="bi bi-eye me-1"></i> Review
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-4">
                    <div class="empty-state-icon mb-3">
                        <i class="bi bi-inbox"></i>
                    </div>
                    <h6 class="fw-bold">No Pending Driver Requests</h6>
                    <p class="text-secondary small mb-0">
                        No driver requests are waiting for review.
                    </p>
                </div>
            @endif
        </div>
    </div>

    {{-- Pending Vehicle Requests --}}
    <div class="card dashboard-main-card mb-4">
        <div class="card-header bg-white d-flex flex-wrap justify-content-between align-items-center gap-2 py-3">
            <div>
                <h5 class="fw-bold mb-1">
                    <i class="bi bi-truck text-info me-2"></i>
                    Pending Vehicle Requests
                </h5>
                <p class="text-secondary small mb-0">
                    Vehicle registrations and changes awaiting review.
                </p>
            </div>

            <a href="{{ route('vehicle-approvals.index') }}"
               class="btn btn-primary btn-sm">
                View All Vehicle Requests
                <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>

        <div class="card-body p-0">
            @if(isset($pendingVehicleRequests) && $pendingVehicleRequests->isNotEmpty())
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Request ID</th>
                                <th>Registration No.</th>
                                <th>Make</th>
                                <th>Type</th>
                                <th>Submitted By</th>
                                <th>Submitted Date</th>
                                <th class="text-end pe-4">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendingVehicleRequests as $request)
                                @php
                                    $vehicleData = data_get($request->payload, 'vehicle', []);
                                @endphp
                                <tr>
                                    <td class="ps-4 fw-semibold">#{{ $request->id }}</td>
                                    <td>
                                        {{ $vehicleData['registration_no']
                                            ?? $request->vehicle?->registration_no
                                            ?? '—' }}
                                    </td>
                                    <td>
                                        {{ $vehicleData['make']
                                            ?? $request->vehicle?->make
                                            ?? '—' }}
                                    </td>
                                    <td>{{ $vehicleData['type'] ?? $request->vehicle?->type ?? '—' }}</td>
                                    <td>{{ $request->maker?->name ?? 'Unknown' }}</td>
                                    <td>
                                        {{ $request->submitted_at?->format('d M Y, h:i A') ?? '—' }}
                                    </td>
                                    <td class="text-end pe-4">
                                        <a href="{{ route('vehicle-approvals.show', $request) }}"
                                           class="btn btn-outline-primary btn-sm">
                                            <i class="bi bi-eye me-1"></i> Review
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-4">
                    <div class="empty-state-icon mb-3">
                        <i class="bi bi-truck"></i>
                    </div>
                    <h6 class="fw-bold">No Pending Vehicle Requests</h6>
                    <p class="text-secondary small mb-0">
                        No vehicle requests are waiting for review.
                    </p>
                </div>
            @endif
        </div>
    </div>

    {{-- Approved Driver History --}}
    <div class="card dashboard-main-card mb-4">
        <div class="card-header bg-white d-flex flex-wrap justify-content-between align-items-center gap-2 py-3">
            <div>
                <h5 class="fw-bold mb-1">
                    <i class="bi bi-check-circle text-success me-2"></i>
                    Approved Driver History
                </h5>
                <p class="text-secondary small mb-0">
                    Recently approved driver registrations and changes.
                </p>
            </div>

            <a href="{{ route('driver-approvals.approved-history') }}"
               class="btn btn-outline-success btn-sm">
                View All Approved
                <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>

        <div class="card-body p-0">
            @if(isset($approvedRequests) && $approvedRequests->isNotEmpty())
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Request ID</th>
                                <th>Driver</th>
                                <th>Type</th>
                                <th>Submitted By</th>
                                <th>Approved Date</th>
                                <th class="text-end pe-4">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($approvedRequests as $request)
                                <tr>
                                    <td class="ps-4 fw-semibold">#{{ $request->id }}</td>
                                    <td>
                                        {{ data_get($request->payload, 'driver.name')
                                            ?? $request->driver?->name
                                            ?? '—' }}
                                    </td>
                                    <td>{{ ucfirst($request->action) }}</td>
                                    <td>{{ $request->maker?->name ?? 'Unknown' }}</td>
                                    <td>
                                        {{ $request->reviewed_at?->format('d M Y, h:i A') ?? '—' }}
                                    </td>
                                    <td class="text-end pe-4">
                                        <a href="{{ route('driver-approvals.show', $request) }}"
                                           class="btn btn-outline-success btn-sm">
                                            <i class="bi bi-eye me-1"></i> View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-4">
                    <h6 class="fw-bold">No Approved Driver Requests Yet</h6>
                </div>
            @endif
        </div>
    </div>

    {{-- Approved Vehicle History --}}
    <div class="card dashboard-main-card mb-4">
        <div class="card-header bg-white d-flex flex-wrap justify-content-between align-items-center gap-2 py-3">
            <div>
                <h5 class="fw-bold mb-1">
                    <i class="bi bi-truck text-success me-2"></i>
                    Approved Vehicle History
                </h5>
                <p class="text-secondary small mb-0">
                    Recently approved vehicle registrations and changes.
                </p>
            </div>

            <a href="{{ route('vehicle-approvals.approved-history') }}"
               class="btn btn-outline-success btn-sm">
                View All Approved
                <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>

        <div class="card-body p-0">
            @if(isset($approvedVehicleRequests) && $approvedVehicleRequests->isNotEmpty())
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Request ID</th>
                                <th>Registration No.</th>
                                <th>Make</th>
                                <th>Type</th>
                                <th>Submitted By</th>
                                <th>Approved Date</th>
                                <th class="text-end pe-4">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($approvedVehicleRequests as $request)
                                @php
                                    $vehicleData = data_get($request->payload, 'vehicle', []);
                                @endphp
                                <tr>
                                    <td class="ps-4 fw-semibold">#{{ $request->id }}</td>
                                    <td>
                                        {{ $vehicleData['registration_no']
                                            ?? $request->vehicle?->registration_no
                                            ?? '—' }}
                                    </td>
                                    <td>{{ $vehicleData['make'] ?? $request->vehicle?->make ?? '—' }}</td>
                                    <td>{{ $vehicleData['type'] ?? $request->vehicle?->type ?? '—' }}</td>
                                    <td>{{ $request->maker?->name ?? 'Unknown' }}</td>
                                    <td>
                                        {{ $request->reviewed_at?->format('d M Y, h:i A') ?? '—' }}
                                    </td>
                                    <td class="text-end pe-4">
                                        <a href="{{ route('vehicle-approvals.show', $request) }}"
                                           class="btn btn-outline-success btn-sm">
                                            <i class="bi bi-eye me-1"></i> View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-4">
                    <h6 class="fw-bold">No Approved Vehicle Requests Yet</h6>
                </div>
            @endif
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="row g-3">

        <div class="col-12 col-md-4">
            <a href="{{ route('drivers.index') }}" class="text-decoration-none">
                <div class="card dashboard-action-card h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="dashboard-action-icon bg-primary-subtle text-primary">
                            <i class="bi bi-people"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="fw-bold text-dark mb-1">View Drivers</h6>
                            <p class="text-secondary small mb-0">Browse approved driver records.</p>
                        </div>
                        <i class="bi bi-chevron-right text-secondary"></i>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-12 col-md-4">
            <a href="{{ route('vehicles.index') }}" class="text-decoration-none">
                <div class="card dashboard-action-card h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="dashboard-action-icon bg-info-subtle text-info">
                            <i class="bi bi-truck"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="fw-bold text-dark mb-1">View Vehicles</h6>
                            <p class="text-secondary small mb-0">Browse approved fleet vehicles.</p>
                        </div>
                        <i class="bi bi-chevron-right text-secondary"></i>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-12 col-md-4">
            <a href="{{ route('vehicle-approvals.index') }}" class="text-decoration-none">
                <div class="card dashboard-action-card h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="dashboard-action-icon bg-warning-subtle text-warning-emphasis">
                            <i class="bi bi-clipboard-check"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="fw-bold text-dark mb-1">Vehicle Approvals</h6>
                            <p class="text-secondary small mb-0">Review pending vehicle submissions.</p>
                        </div>
                        <i class="bi bi-chevron-right text-secondary"></i>
                    </div>
                </div>
            </a>
        </div>

    </div>

</div>
@endsection

@push('styles')
<style>
    .dashboard-stat-card,
    .dashboard-main-card,
    .dashboard-action-card {
        border: 1px solid #e8edf3;
        border-radius: 14px;
        box-shadow: 0 3px 12px rgba(15, 23, 42, .04);
    }

    .dashboard-stat-card,
    .dashboard-action-card {
        transition: transform .2s ease, box-shadow .2s ease;
    }

    .dashboard-stat-card:hover,
    .dashboard-action-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 7px 20px rgba(15, 23, 42, .08);
    }

    .stat-pending {
        border-left: 4px solid #f0ad4e;
    }

    .stat-approved {
        border-left: 4px solid #198754;
    }

    .stat-rejected {
        border-left: 4px solid #dc3545;
    }

    .dashboard-stat-icon,
    .dashboard-action-icon {
        width: 52px;
        height: 52px;
        min-width: 52px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 13px;
        font-size: 1.45rem;
    }

    .dashboard-main-card {
        overflow: hidden;
    }

    .dashboard-main-card .card-header {
        border-bottom: 1px solid #edf0f4;
    }

    .dashboard-main-card .table th {
        color: #64748b;
        font-size: .78rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .04em;
        white-space: nowrap;
        padding-top: 14px;
        padding-bottom: 14px;
    }

    .dashboard-main-card .table td {
        padding-top: 15px;
        padding-bottom: 15px;
    }

    .empty-state-icon {
        width: 64px;
        height: 64px;
        margin: auto;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: #f1f5f9;
        color: #64748b;
        font-size: 1.8rem;
    }

    .dashboard-action-card {
        color: inherit;
    }

    .dashboard-action-card .card-body {
        padding: 20px;
    }

    @media (max-width: 576px) {
        .page-heading {
            font-size: 1.5rem;
        }
    }
</style>
@endpush
