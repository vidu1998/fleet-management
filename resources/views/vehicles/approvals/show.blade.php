
@extends('layouts.admin')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Review Vehicle Request</h2>
            <p class="text-muted mb-0">
                Request #{{ $vehicleChangeRequest->id }}
            </p>
        </div>

        <a href="{{ route('vehicle-approvals.index') }}"
           class="btn btn-outline-secondary">
            Back to Requests
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @php
        $vehicleFields = [
            'registration_no' => 'Registration Number',
            'make' => 'Make',
            'manufacture_year' => 'Manufacture Year',
            'type' => 'Vehicle Type',
            'fuel_type' => 'Fuel Type',
            'color' => 'Color',
            'purchased_date' => 'Purchased Date',
            'purchased_price' => 'Purchased Price (LKR)',
            'insurance_expire_date' => 'Insurance Expiry Date',
            'road_tax_expire_date' => 'Road Tax Expiry Date',
            'current_odo_reading' => 'Current ODO Reading (km)',
            'engine_condition_percentage' => 'Engine Condition (%)',
            'body_condition_percentage' => 'Body Condition (%)',
            'current_location' => 'Current Location',
            'parking_location' => 'Parking Location',
        ];
    @endphp

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0">Proposed Vehicle Details</h5>
        </div>

        <div class="card-body">
            <dl class="row mb-0">
                <dt class="col-md-3">Request Type</dt>
                <dd class="col-md-9">{{ ucfirst($vehicleChangeRequest->action) }}</dd>

                <dt class="col-md-3">Submitted By</dt>
                <dd class="col-md-9">{{ $vehicleChangeRequest->maker?->name ?? 'Unknown' }}</dd>

                <dt class="col-md-3">Submitted Date</dt>
                <dd class="col-md-9">
                    {{ $vehicleChangeRequest->submitted_at?->format('d M Y, h:i A') ?? '—' }}
                </dd>

                <dt class="col-md-3">Status</dt>
                <dd class="col-md-9">{{ ucfirst($vehicleChangeRequest->status) }}</dd>

                @foreach($vehicleFields as $field => $label)
                    <dt class="col-md-3">{{ $label }}</dt>
                    <dd class="col-md-9">
                        @if(in_array($field, [
                            'purchased_date',
                            'insurance_expire_date',
                            'road_tax_expire_date'
                        ]) && !empty($vehicleData[$field]))
                            {{ \Carbon\Carbon::parse($vehicleData[$field])->format('d M Y') }}
                        @elseif($field === 'purchased_price' && isset($vehicleData[$field]))
                            {{ number_format((float) $vehicleData[$field], 2) }}
                        @else
                            {{ $vehicleData[$field] ?? '—' }}
                        @endif
                    </dd>
                @endforeach
            </dl>
        </div>
    </div>

    @if($vehicleChangeRequest->status === 'pending')
        <div class="row g-4">

            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="text-success">Approve Request</h5>
                        <p class="text-muted">
                            Approving applies the proposed vehicle data to the active records.
                        </p>

                        <form
                            action="{{ route('vehicle-approvals.approve', $vehicleChangeRequest) }}"
                            method="POST"
                            onsubmit="return confirm('Are you sure you want to approve this vehicle request?');"
                        >
                            @csrf
                            <button type="submit" class="btn btn-success">
                                Approve Request
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="text-danger">Reject Request</h5>

                        <form
                            action="{{ route('vehicle-approvals.reject', $vehicleChangeRequest) }}"
                            method="POST"
                        >
                            @csrf

                            <div class="mb-3">
                                <label for="checker_comment" class="form-label">
                                    Rejection Reason <span class="text-danger">*</span>
                                </label>

                                <textarea
                                    name="checker_comment"
                                    id="checker_comment"
                                    rows="3"
                                    maxlength="2000"
                                    class="form-control @error('checker_comment') is-invalid @enderror"
                                    required
                                >{{ old('checker_comment') }}</textarea>

                                @error('checker_comment')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button
                                type="submit"
                                class="btn btn-danger"
                                onclick="return confirm('Are you sure you want to reject this request?');"
                            >
                                Reject Request
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    @else
        <div class="alert alert-info">
            This request has already been reviewed.
            Status: <strong>{{ ucfirst($vehicleChangeRequest->status) }}</strong>

            @if($vehicleChangeRequest->checker_comment)
                <div class="mt-2">
                    <strong>Checker Comment:</strong>
                    {{ $vehicleChangeRequest->checker_comment }}
                </div>
            @endif
        </div>
    @endif

</div>
@endsection
