@extends('layouts.admin')

@section('title', 'Driver Details')

@section('header', 'Driver Details')

@section('content')
<div class="container-fluid">

    @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h3 class="fw-bold mb-1">{{ $driver->name }}</h3>
            <p class="text-muted mb-0">
                Driver ID: {{ $driver->id }}
            </p>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('drivers.index') }}" class="btn btn-light border">
                <i class="bi bi-arrow-left me-1"></i> Back
            </a>

            @if (auth()->user()->role === 'maker' && !auth()->user()->is_super_admin)
            <a href="{{ route('drivers.edit', $driver) }}"
                class="btn btn-primary">
                <i class="bi bi-pencil-square me-1"></i> Submit Changes
            </a>
            @endif
        </div>
    </div>

    {{-- Driver Information --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0">
                <i class="bi bi-person-vcard me-2"></i>Personal Information
            </h5>
        </div>

        <div class="card-body">
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="text-muted small">Full Name</div>
                    <div class="fw-semibold">{{ $driver->name }}</div>
                </div>

                <div class="col-md-6">
                    <div class="text-muted small">Phone</div>
                    <div>{{ $driver->phone ?: 'Not provided' }}</div>
                </div>

                <div class="col-md-6">
                    <div class="text-muted small">Email</div>
                    <div>{{ $driver->email ?: 'Not provided' }}</div>
                </div>
                <div class="col-md-6">
                    <div class="text-muted small">Join Date</div>
                    <div>
                        {{ $driver->joined_date?->format('d M Y') ?? 'Not provided' }}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="text-muted small">Blood Group</div>
                    <div>{{ $driver->blood_group ?: 'Not provided' }}</div>
                </div>

                <div class="col-md-6">
                    <div class="text-muted small">Drive Mileage</div>
                    <div class="fw-semibold">
                        {{ number_format((float) $driver->drive_mileage, 2) }}
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="text-muted small">Smoker</div>
                    <span class="badge {{ $driver->is_smoker ? 'bg-warning text-dark' : 'bg-success' }}">
                        {{ $driver->is_smoker ? 'Yes' : 'No' }}
                    </span>
                </div>

                <div class="col-md-3">
                    <div class="text-muted small">Drinker</div>
                    <span class="badge {{ $driver->is_drinker ? 'bg-warning text-dark' : 'bg-success' }}">
                        {{ $driver->is_drinker ? 'Yes' : 'No' }}
                    </span>
                </div>

                <div class="col-12">
                    <div class="text-muted small">Address</div>
                    <div>{{ $driver->address ?: 'Not provided' }}</div>
                </div>

                <div class="col-12">
                    <div class="text-muted small">Driving Licence Document</div>

                    @if ($driver->licence_file_path)
                    <span class="badge bg-success me-2">Uploaded</span>
                    <span class="text-muted">
                        {{ basename($driver->licence_file_path) }}
                    </span>
                    <div class="mt-2">
                        <a href="{{ route('drivers.licence', $driver) }}"
                            class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-file-earmark-text me-1"></i>
                            View Licence
                        </a>
                    </div>
                    @else
                    <span class="text-muted">No licence document uploaded.</span>
                    @endif
                </div>

                <div class="col-md-6">
                    <div class="text-muted small">Created</div>
                    <div>{{ $driver->created_at?->format('Y-m-d H:i') }}</div>
                </div>

                <div class="col-md-6">
                    <div class="text-muted small">Last Updated</div>
                    <div>{{ $driver->updated_at?->format('Y-m-d H:i') }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Licence Categories --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0">
                <i class="bi bi-card-checklist me-2"></i>Driving Licence Categories
            </h5>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Category</th>
                        <th>Received Date</th>
                        <th>Expiry Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($driver->licenceCategories as $licence)
                    <tr>
                        <td class="fw-semibold">
                            {{ $licence->licence_category }}
                        </td>
                        <td>
                            {{ $licence->receive_date?->format('Y-m-d') ?? '—' }}
                        </td>
                        <td>
                            {{ $licence->expiry_date?->format('Y-m-d') ?? '—' }}
                        </td>
                        <td>
                            @if (!$licence->expiry_date)
                            <span class="badge bg-secondary">No expiry date</span>
                            @elseif ($licence->expiry_date->isPast())
                            <span class="badge bg-danger">Expired</span>
                            @else
                            <span class="badge bg-success">Valid</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4">
                            No licence categories recorded.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Acknowledgements --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0">
                <i class="bi bi-chat-square-text me-2"></i>Driver Acknowledgements
            </h5>
        </div>

        <div class="card-body">
            @forelse ($driver->acknowledgements as $ack)
            @php
            $levelClass = match ($ack->critical_level) {
            'critical' => 'danger',
            'high' => 'warning',
            'medium' => 'info',
            default => 'secondary',
            };
            @endphp

            <div class="border rounded p-3 mb-3">
                <div class="d-flex justify-content-between align-items-start gap-3 mb-2">
                    <span class="badge bg-{{ $levelClass }}">
                        {{ ucfirst($ack->critical_level) }}
                    </span>
                    <small class="text-muted">
                        {{ $ack->created_at?->format('Y-m-d H:i') }}
                    </small>
                </div>
                <p class="mb-0">{{ $ack->message }}</p>
            </div>
            @empty
            <p class="text-muted mb-0">
                No acknowledgements recorded for this driver.
            </p>
            @endforelse
        </div>
    </div>
</div>
@endsection