@extends('layouts.admin')

@section('title', 'Edit Driver')

@section('header', 'Submit Driver Changes')

@section('content')
<div class="container-fluid">

    <div class="mb-4">
        <h3 class="fw-bold">Edit Driver</h3>
        <p class="text-muted mb-0">
            Changes will take effect only after Checker approval.
        </p>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Please correct these errors:</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('drivers.update', $driver) }}"
          method="POST"
          enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Driver details --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Driver Information</h5>
            </div>

            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Full Name *</label>
                        <input type="text" name="name" required
                               class="form-control"
                               value="{{ old('name', $driver->name) }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone"
                               class="form-control"
                               value="{{ old('phone', $driver->phone) }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email" name="email"
                               class="form-control"
                               value="{{ old('email', $driver->email) }}">
                    </div>
<div class="mb-3">
    <label for="joined_date" class="form-label">
        Join Date <span class="text-danger">*</span>
    </label>

    <input
        type="date"
        name="joined_date"
        id="joined_date"
        class="form-control @error('joined_date') is-invalid @enderror"
        value="{{ old('joined_date', $driver->joined_date?->format('Y-m-d')) }}"
        max="{{ date('Y-m-d') }}"
        required
    >

    @error('joined_date')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
                    <div class="col-md-6">
                        <label class="form-label">Drive Mileage *</label>
                        <input type="number" name="drive_mileage"
                               class="form-control"
                               min="0" step="0.01" required
                               value="{{ old('drive_mileage', $driver->drive_mileage) }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Blood Group</label>
                        <select name="blood_group" class="form-select">
                            <option value="">Select</option>
                            @foreach (['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $group)
                                <option value="{{ $group }}"
                                    @selected(old('blood_group', $driver->blood_group) === $group)>
                                    {{ $group }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Smoker</label>
                        <select name="is_smoker" class="form-select">
                            <option value="0" @selected(!(bool) old('is_smoker', $driver->is_smoker))>No</option>
                            <option value="1" @selected((bool) old('is_smoker', $driver->is_smoker))>Yes</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Drinker</label>
                        <select name="is_drinker" class="form-select">
                            <option value="0" @selected(!(bool) old('is_drinker', $driver->is_drinker))>No</option>
                            <option value="1" @selected((bool) old('is_drinker', $driver->is_drinker))>Yes</option>
                        </select>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Address</label>
                        <textarea name="address" rows="3"
                                  class="form-control">{{ old('address', $driver->address) }}</textarea>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Replace Licence Document (optional)</label>
                        <input type="file" name="licence_file"
                               class="form-control"
                               accept=".pdf,.jpg,.jpeg,.png">
                        <small class="text-muted">
                            @if ($driver->licence_file_path)
                                Current file: {{ basename($driver->licence_file_path) }}.
                                Leave blank to retain it.
                            @else
                                No licence document is currently recorded.
                            @endif
                        </small>
                    </div>
                </div>
            </div>
        </div>

        {{-- Licence category --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Licence Category</h5>
            </div>

            <div class="card-body">
                @php
                    $licence = old('licence_categories.0', [
                        'licence_category' => $licenceCategories->first()?->licence_category ?? '',
                        'expiry_date' => $licenceCategories->first()?->expiry_date?->format('Y-m-d') ?? '',
                        'receive_date' => $licenceCategories->first()?->receive_date?->format('Y-m-d') ?? '',
                    ]);
                @endphp

                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Category</label>
                        <input name="licence_categories[0][licence_category]"
                               class="form-control"
                               value="{{ $licence['licence_category'] ?? '' }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Expiry Date</label>
                        <input type="date"
                               name="licence_categories[0][expiry_date]"
                               class="form-control"
                               value="{{ $licence['expiry_date'] ?? '' }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Received Date</label>
                        <input type="date"
                               name="licence_categories[0][receive_date]"
                               class="form-control"
                               value="{{ $licence['receive_date'] ?? '' }}">
                    </div>
                </div>

                <small class="text-muted">
                    This first version edits one category. Additional categories require a repeatable form.
                </small>
            </div>
        </div>

        {{-- Acknowledgement --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Acknowledgement</h5>
            </div>

            <div class="card-body">
                @php
                    $ack = old('acknowledgements.0', [
                        'message' => $acknowledgements->first()?->message ?? '',
                        'critical_level' => $acknowledgements->first()?->critical_level ?? 'normal',
                    ]);
                @endphp

                <div class="row g-3">
                    <div class="col-md-8">
                        <label class="form-label">Message</label>
                        <textarea name="acknowledgements[0][message]"
                                  rows="3" class="form-control">{{ $ack['message'] ?? '' }}</textarea>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Critical Level</label>
                        <select name="acknowledgements[0][critical_level]"
                                class="form-select">
                            @foreach (['normal', 'medium', 'high', 'critical'] as $level)
                                <option value="{{ $level }}"
                                    @selected(($ack['critical_level'] ?? 'normal') === $level)>
                                    {{ ucfirst($level) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2 mb-4">
            <a href="{{ route('drivers.show', $driver) }}"
               class="btn btn-light border">Cancel</a>

            <button type="submit" class="btn btn-primary">
                <i class="bi bi-send me-1"></i> Submit for Approval
            </button>
        </div>
    </form>
</div>
@endsection