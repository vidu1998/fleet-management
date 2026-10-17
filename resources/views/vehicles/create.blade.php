
@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">{{ $pageTitle ?? 'Vehicle Details' }}</h2>

    <form action="{{ $formAction }}" method="POST">
        @csrf

        @if(($formMethod ?? 'POST') !== 'POST')
            @method($formMethod)
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                Please correct the errors below.
            </div>
        @endif

        <div class="card shadow-sm border-0">
            <div class="card-header bg-white">
                <h5 class="mb-0">Vehicle Information</h5>
            </div>

            <div class="card-body">
                <div class="row g-3">
                    @php
                        $fields = [
                            'registration_no' => 'Registration Number',
                            'make' => 'Make',
                            'manufacture_year' => 'Manufacture Year',
                            'color' => 'Color',
                            'purchased_price' => 'Purchased Price (LKR)',
                            'current_odo_reading' => 'Current ODO Reading (km)',
                            'engine_condition_percentage' => 'Engine Condition (%)',
                            'body_condition_percentage' => 'Body Condition (%)',
                            'current_location' => 'Current Location',
                            'parking_location' => 'Parking Location',
                        ];
                    @endphp

                    @foreach($fields as $field => $label)
                        <div class="col-md-6">
                            <label class="form-label" for="{{ $field }}">
                                {{ $label }}
                                @if(in_array($field, [
                                    'registration_no', 'make',
                                    'manufacture_year', 'current_odo_reading',
                                    'engine_condition_percentage',
                                    'body_condition_percentage'
                                ]))
                                    <span class="text-danger">*</span>
                                @endif
                            </label>

                            <input
                                id="{{ $field }}"
                                name="{{ $field }}"
                                class="form-control @error($field) is-invalid @enderror"
                                value="{{ old($field, $vehicle->$field) }}"
                                @if(in_array($field, [
                                    'manufacture_year',
                                    'current_odo_reading',
                                    'purchased_price',
                                    'engine_condition_percentage',
                                    'body_condition_percentage'
                                ]))
                                    type="number"
                                @else
                                    type="text"
                                @endif
                                @if(in_array($field, [
                                    'engine_condition_percentage',
                                    'body_condition_percentage'
                                ]))
                                    min="0" max="100"
                                @elseif($field === 'manufacture_year')
                                    min="1900" max="{{ date('Y') + 1 }}"
                                @elseif($field === 'current_odo_reading' || $field === 'purchased_price')
                                    min="0" step="0.01"
                                @endif
                                @if(in_array($field, [
                                    'registration_no', 'make',
                                    'manufacture_year', 'current_odo_reading',
                                    'engine_condition_percentage',
                                    'body_condition_percentage'
                                ]))
                                    required
                                @endif
                            >

                            @error($field)
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    @endforeach

                    <div class="col-md-6">
                        <label for="type" class="form-label">Vehicle Type *</label>
                        <select id="type" name="type" class="form-select" required>
                            <option value="">Select type</option>
                            @foreach(['Car','Bus','Lorry','Van','Motorcycle','Other'] as $type)
                                <option value="{{ $type }}"
                                    @selected(old('type', $vehicle->type) === $type)>
                                    {{ $type }}
                                </option>
                            @endforeach
                        </select>
                        @error('type') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="fuel_type" class="form-label">Fuel Type *</label>
                        <select id="fuel_type" name="fuel_type" class="form-select" required>
                            <option value="">Select fuel</option>
                            @foreach(['Diesel','Petrol','EV','CNG','LPG'] as $fuel)
                                <option value="{{ $fuel }}"
                                    @selected(old('fuel_type', $vehicle->fuel_type) === $fuel)>
                                    {{ $fuel }}
                                </option>
                            @endforeach
                        </select>
                        @error('fuel_type') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>

                    @foreach([
                        'purchased_date' => 'Purchased Date',
                        'insurance_expire_date' => 'Insurance Expiry Date',
                        'road_tax_expire_date' => 'Road Tax Expiry Date'
                    ] as $field => $label)
                        <div class="col-md-6">
                            <label for="{{ $field }}" class="form-label">{{ $label }}</label>
                            <input
                                type="date"
                                id="{{ $field }}"
                                name="{{ $field }}"
                                class="form-control @error($field) is-invalid @enderror"
                                value="{{ old($field, $vehicle->$field?->format('Y-m-d')) }}"
                            >
                            @error($field)
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="mt-4 d-flex gap-2">
            <button type="submit" class="btn btn-primary">
                Submit for Approval
            </button>
            <a href="{{ route('vehicles.index') }}" class="btn btn-secondary">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
