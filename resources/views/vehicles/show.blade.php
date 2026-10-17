
@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Vehicle Details</h2>
        <a href="{{ route('vehicles.index') }}" class="btn btn-secondary">
            Back to Vehicles
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white">
            <h5 class="mb-0">
                {{ $vehicle->registration_no }} — {{ $vehicle->make }}
            </h5>
        </div>

        <div class="card-body">
            <div class="row g-4">
                @foreach([
                    'Registration Number' => 'registration_no',
                    'Make' => 'make',
                    'Manufacture Year' => 'manufacture_year',
                    'Vehicle Type' => 'type',
                    'Fuel Type' => 'fuel_type',
                    'Color' => 'color',
                    'Purchased Price (LKR)' => 'purchased_price',
                    'Current ODO (km)' => 'current_odo_reading',
                    'Engine Condition (%)' => 'engine_condition_percentage',
                    'Body Condition (%)' => 'body_condition_percentage',
                    'Current Location' => 'current_location',
                    'Parking Location' => 'parking_location',
                ] as $label => $field)
                    <div class="col-md-6">
                        <div class="text-muted small">{{ $label }}</div>
                        <div class="fw-semibold">
                            {{ $vehicle->$field ?? 'Not provided' }}
                        </div>
                    </div>
                @endforeach

                @foreach([
                    'Purchased Date' => 'purchased_date',
                    'Insurance Expiry Date' => 'insurance_expire_date',
                    'Road Tax Expiry Date' => 'road_tax_expire_date',
                ] as $label => $field)
                    <div class="col-md-6">
                        <div class="text-muted small">{{ $label }}</div>
                        <div class="fw-semibold">
                            {{ $vehicle->$field?->format('d M Y') ?? 'Not provided' }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
