
@extends('layouts.admin')

@section('title', 'Driver Management')
@section('header', 'Driver Management')

@section('content')
<div class="container-fluid px-0">

    {{-- Flash messages --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Page heading --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1" style="color:#17243a;">Driver Management</h2>
            <p class="text-muted mb-0">
                View driver profiles, licence categories and submitted changes.
            </p>
        </div>

        @if (auth()->user()->role === 'maker' && !auth()->user()->is_super_admin)
            <a href="{{ route('drivers.create') }}" class="btn btn-primary px-4 py-2">
                <i class="bi bi-person-plus-fill me-2"></i>
                Register Driver
            </a>
        @endif
    </div>

    {{-- Summary --}}
    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-xl-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3 p-4">
                    <div class="rounded-3 d-flex align-items-center justify-content-center bg-primary-subtle text-primary"
                         style="width:52px;height:52px;font-size:24px;">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Drivers on this page</div>
                        <div class="fs-3 fw-bold">
                            {{ $drivers->count() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3 p-4">
                    <div class="rounded-3 d-flex align-items-center justify-content-center bg-success-subtle text-success"
                         style="width:52px;height:52px;font-size:24px;">
                        <i class="bi bi-person-check-fill"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Total approved drivers</div>
                        <div class="fs-3 fw-bold">
                            {{ $drivers->total() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if (auth()->user()->role === 'maker' && !auth()->user()->is_super_admin)
            <div class="col-sm-6 col-xl-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center gap-3 p-4">
                        <div class="rounded-3 d-flex align-items-center justify-content-center bg-warning-subtle text-warning"
                             style="width:52px;height:52px;font-size:24px;">
                            <i class="bi bi-clock-history"></i>
                        </div>
                        <div>
                            <div class="text-muted small">Recent requests</div>
                            <div class="fs-3 fw-bold">
                                {{ $myRequests->count() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    {{-- Drivers table --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white border-0 px-4 pt-4 pb-3">
            <h5 class="fw-bold mb-1">Approved Drivers</h5>
            <p class="text-muted small mb-0">
                Driver records currently active in the system.
            </p>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead style="background:#f5f7fb;">
                    <tr class="text-muted small text-uppercase">
                        <th class="ps-4 py-3">Driver</th>
                        <th>Contact Information</th>
                        <th>Driving Mileage</th>
                        <th>Licence Categories</th>
                        <th class="text-center pe-4">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($drivers as $driver)
                        <tr>
                            {{-- Driver name --}}
                            <td class="ps-4 py-3">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-primary bg-primary-subtle"
                                         style="width:44px;height:44px;min-width:44px;">
                                        {{ strtoupper(substr($driver->name, 0, 1)) }}
                                    </div>

                                    <div>
                                        <div class="fw-semibold text-dark">
                                            {{ $driver->name }}
                                        </div>
                                        <small class="text-muted">
                                            Driver ID: #{{ $driver->id }}
                                        </small>
                                    </div>
                                </div>
                            </td>

                            {{-- Contact --}}
                            <td>
                                <div class="mb-1">
                                    <i class="bi bi-telephone text-muted me-2"></i>
                                    {{ $driver->phone ?: 'Not provided' }}
                                </div>

                                <div class="small text-muted">
                                    <i class="bi bi-envelope me-2"></i>
                                    {{ $driver->email ?: 'Not provided' }}
                                </div>
                            </td>

                            {{-- Mileage --}}
                            <td>
                                <span class="fw-semibold">
                                    {{ number_format((float) $driver->drive_mileage, 2) }}
                                </span>
                                <small class="text-muted">km</small>
                            </td>

                            {{-- Licence categories --}}
                            <td>
                                @forelse ($driver->licenceCategories as $licence)
                                    <span class="badge rounded-pill bg-primary-subtle text-primary border border-primary-subtle me-1 mb-1 px-3 py-2">
                                        {{ $licence->licence_category }}
                                    </span>
                                @empty
                                    <span class="text-muted small">
                                        No categories recorded
                                    </span>
                                @endforelse
                            </td>

                            {{-- Actions --}}
                            <td class="text-center pe-4">
                                <div class="d-flex justify-content-center flex-wrap gap-2">
                                    <a href="{{ route('drivers.show', $driver) }}"
                                       class="btn btn-sm btn-outline-primary"
                                       title="View driver details">
                                        <i class="bi bi-eye me-1"></i>
                                        Show Details
                                    </a>

                                    @if (auth()->user()->role === 'maker' && !auth()->user()->is_super_admin)
                                        <a href="{{ route('drivers.edit', $driver) }}"
                                           class="btn btn-sm btn-outline-secondary"
                                           title="Submit changes for approval">
                                            <i class="bi bi-pencil-square me-1"></i>
                                            Edit
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <i class="bi bi-people text-muted" style="font-size:42px;"></i>
                                <h6 class="fw-bold mt-3">No approved drivers found</h6>
                                <p class="text-muted mb-3">
                                    Approved driver records will appear here.
                                </p>

                                @if (auth()->user()->role === 'maker' && !auth()->user()->is_super_admin)
                                    <a href="{{ route('drivers.create') }}"
                                       class="btn btn-primary btn-sm">
                                        <i class="bi bi-plus-lg me-1"></i>
                                        Register First Driver
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer bg-white border-0 px-4 py-3">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                <small class="text-muted">
                    Showing {{ $drivers->firstItem() ?? 0 }}
                    to {{ $drivers->lastItem() ?? 0 }}
                    of {{ $drivers->total() }} drivers
                </small>

                <div>
                    {{ $drivers->links() }}
                </div>
            </div>
        </div>
    </div>

    {{-- Maker request history --}}
    @if (auth()->user()->role === 'maker' && !auth()->user()->is_super_admin)
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 px-4 pt-4 pb-3">
                <h5 class="fw-bold mb-1">My Recent Requests</h5>
                <p class="text-muted small mb-0">
                    Track driver submissions awaiting review or already reviewed.
                </p>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background:#f5f7fb;">
                        <tr class="text-muted small text-uppercase">
                            <th class="ps-4 py-3">Request</th>
                            <th>Driver</th>
                            <th>Action</th>
                            <th>Submitted</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($myRequests as $item)
                            @php
                                $statusClass = match ($item->status) {
                                    'approved' => 'bg-success-subtle text-success',
                                    'rejected' => 'bg-danger-subtle text-danger',
                                    default => 'bg-warning-subtle text-dark',
                                };
                            @endphp

                            <tr>
                                <td class="ps-4 fw-semibold">
                                    #{{ $item->id }}
                                </td>

                                <td>
                                    {{ $item->driver?->name
                                        ?? data_get($item->payload, 'driver.name', 'New driver') }}
                                </td>

                                <td>
                                    <span class="badge bg-light text-dark border">
                                        {{ ucfirst($item->action) }}
                                    </span>
                                </td>

                                <td>
                                    {{ $item->submitted_at?->format('d M Y, h:i A') ?? '—' }}
                                </td>

                                <td>
                                    <span class="badge rounded-pill {{ $statusClass }} px-3 py-2">
                                        {{ ucfirst($item->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    No driver requests submitted yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif

</div>
@endsection
