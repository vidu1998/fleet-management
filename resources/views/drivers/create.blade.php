
@extends('layouts.admin')

@section('title', $pageTitle)
@section('header', $pageTitle)

@section('content')
<div class="container-fluid">

    <div class="mb-4">
        <h3 class="fw-bold">{{ $pageTitle }}</h3>
        <p class="text-muted mb-0">
            Your submission must be approved by a Checker before it changes active records.
        </p>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Please correct the following errors:</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ $formAction }}" method="POST" enctype="multipart/form-data">
        @csrf

        @if ($formMethod === 'PUT')
            @method('PUT')
        @endif

        {{-- DRIVER DETAILS --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Driver Details</h5>
            </div>

            <div class="card-body">
                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label">Full Name *</label>
                        <input type="text" name="name"
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name', $driver->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone"
                               class="form-control @error('phone') is-invalid @enderror"
                               value="{{ old('phone', $driver->phone) }}">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email" name="email"
                               class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email', $driver->email) }}">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
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
        value="{{ old('joined_date') }}"
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
                               class="form-control @error('drive_mileage') is-invalid @enderror"
                               min="0" step="0.01"
                               value="{{ old('drive_mileage', $driver->drive_mileage ?? 0) }}"
                               required>
                        @error('drive_mileage')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Blood Group</label>
                        <select name="blood_group" class="form-select">
                            <option value="">Select blood group</option>
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
                            <option value="0"
                                @selected((string) old('is_smoker', (int) ($driver->is_smoker ?? false)) === '0')>
                                No
                            </option>
                            <option value="1"
                                @selected((string) old('is_smoker', (int) ($driver->is_smoker ?? false)) === '1')>
                                Yes
                            </option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Drinker</label>
                        <select name="is_drinker" class="form-select">
                            <option value="0"
                                @selected((string) old('is_drinker', (int) ($driver->is_drinker ?? false)) === '0')>
                                No
                            </option>
                            <option value="1"
                                @selected((string) old('is_drinker', (int) ($driver->is_drinker ?? false)) === '1')>
                                Yes
                            </option>
                        </select>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Address</label>
                        <textarea name="address" rows="3"
                                  class="form-control">{{ old('address', $driver->address) }}</textarea>
                    </div>

                    <div class="col-12">
                        <label class="form-label">
                            Driving Licence File (PDF, JPG or PNG; max 5 MB)
                        </label>
                        <input type="file" name="licence_file"
                               class="form-control @error('licence_file') is-invalid @enderror"
                               accept=".pdf,.jpg,.jpeg,.png">
                        @error('licence_file')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        @if ($driver->licence_file_path)
                            <small class="text-muted d-block mt-1">
                                An existing licence file is recorded. Upload a new file only if you want to replace it.
                            </small>
                        @endif
                    </div>

                </div>
            </div>
        </div>

        {{-- MULTIPLE LICENCE CATEGORIES --}}
        @php
            $licenceRows = old('licence_categories');

            if ($licenceRows === null) {
                $licenceRows = $licenceCategories->map(fn ($item) => [
                    'licence_category' => $item->licence_category,
                    'expiry_date' => $item->expiry_date?->format('Y-m-d') ?? '',
                    'receive_date' => $item->receive_date?->format('Y-m-d') ?? '',
                ])->values()->all();
            }

            if (empty($licenceRows)) {
                $licenceRows = [[
                    'licence_category' => '',
                    'expiry_date' => '',
                    'receive_date' => '',
                ]];
            }

            $ackRows = old('acknowledgements');

            if ($ackRows === null) {
                $ackRows = $acknowledgements->map(fn ($item) => [
                    'message' => $item->message,
                    'critical_level' => $item->critical_level,
                ])->values()->all();
            }

            if (empty($ackRows)) {
                $ackRows = [[
                    'message' => '',
                    'critical_level' => 'normal',
                ]];
            }
        @endphp

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0">Driving Licence Categories</h5>
                    <small class="text-muted">
                        One driver can have multiple categories.
                    </small>
                </div>

                <button type="button" id="addLicence"
                        class="btn btn-outline-primary btn-sm">
                    <i class="bi bi-plus-circle me-1"></i> Add Category
                </button>
            </div>

            <div class="card-body">
                <div id="licenceRows">
                    @foreach ($licenceRows as $i => $licence)
                        <div class="licence-row border rounded p-3 mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <strong>Licence Category</strong>
                                <button type="button"
                                        class="btn btn-outline-danger btn-sm remove-row">
                                    Remove
                                </button>
                            </div>

                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label">Category</label>
                                    <input type="text"
                                           name="licence_categories[{{ $i }}][licence_category]"
                                           class="form-control"
                                           maxlength="20"
                                           value="{{ $licence['licence_category'] ?? '' }}"
                                           placeholder="e.g. B1">
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Expiry Date</label>
                                    <input type="date"
                                           name="licence_categories[{{ $i }}][expiry_date]"
                                           class="form-control"
                                           value="{{ $licence['expiry_date'] ?? '' }}">
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Received Date</label>
                                    <input type="date"
                                           name="licence_categories[{{ $i }}][receive_date]"
                                           class="form-control"
                                           value="{{ $licence['receive_date'] ?? '' }}">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <small class="text-muted">
                    You may add multiple categories. Leave a category row blank to ignore it.
                </small>
            </div>
        </div>

        {{-- OPTIONAL ACKNOWLEDGEMENTS --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0">Driver Acknowledgements</h5>
                    <small class="text-muted">
                        Optional. You can manage these separately later.
                    </small>
                </div>

                <button type="button" id="addAcknowledgement"
                        class="btn btn-outline-primary btn-sm">
                    <i class="bi bi-plus-circle me-1"></i> Add Acknowledgement
                </button>
            </div>

            <div class="card-body">
                <div id="acknowledgementRows">
                    @foreach ($ackRows as $i => $ack)
                        <div class="ack-row border rounded p-3 mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <strong>Acknowledgement</strong>
                                <button type="button"
                                        class="btn btn-outline-danger btn-sm remove-row">
                                    Remove
                                </button>
                            </div>

                            <div class="row g-3">
                                <div class="col-md-8">
                                    <label class="form-label">Message</label>
                                    <textarea
                                        name="acknowledgements[{{ $i }}][message]"
                                        rows="2"
                                        class="form-control"
                                        placeholder="Optional driver notice">{{ $ack['message'] ?? '' }}</textarea>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Critical Level</label>
                                    <select
                                        name="acknowledgements[{{ $i }}][critical_level]"
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
                    @endforeach
                </div>

                <small class="text-muted">
                    Leave the message blank to ignore that row. You do not need to add an acknowledgement to register a driver.
                </small>
            </div>
        </div>

        {{-- ACTIONS --}}
        <div class="d-flex justify-content-end gap-2 mb-4">
            <a href="{{ route('drivers.index') }}"
               class="btn btn-light border">
                Cancel
            </a>

            <button type="submit" class="btn btn-primary">
                <i class="bi bi-send me-1"></i>
                Submit for Approval
            </button>
        </div>

    </form>
</div>

{{-- Dynamic row templates --}}
<template id="licenceTemplate">
    <div class="licence-row border rounded p-3 mb-3">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <strong>Licence Category</strong>
            <button type="button" class="btn btn-outline-danger btn-sm remove-row">
                Remove
            </button>
        </div>

        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Category</label>
                <input type="text"
                       name="licence_categories[__INDEX__][licence_category]"
                       class="form-control" maxlength="20" placeholder="e.g. B1">
            </div>

            <div class="col-md-4">
                <label class="form-label">Expiry Date</label>
                <input type="date"
                       name="licence_categories[__INDEX__][expiry_date]"
                       class="form-control">
            </div>

            <div class="col-md-4">
                <label class="form-label">Received Date</label>
                <input type="date"
                       name="licence_categories[__INDEX__][receive_date]"
                       class="form-control">
            </div>
        </div>
    </div>
</template>

<template id="acknowledgementTemplate">
    <div class="ack-row border rounded p-3 mb-3">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <strong>Acknowledgement</strong>
            <button type="button" class="btn btn-outline-danger btn-sm remove-row">
                Remove
            </button>
        </div>

        <div class="row g-3">
            <div class="col-md-8">
                <label class="form-label">Message</label>
                <textarea name="acknowledgements[__INDEX__][message]"
                          rows="2" class="form-control"
                          placeholder="Optional driver notice"></textarea>
            </div>

            <div class="col-md-4">
                <label class="form-label">Critical Level</label>
                <select name="acknowledgements[__INDEX__][critical_level]"
                        class="form-select">
                    <option value="normal">Normal</option>
                    <option value="medium">Medium</option>
                    <option value="high">High</option>
                    <option value="critical">Critical</option>
                </select>
            </div>
        </div>
    </div>
</template>

<script>
document.addEventListener('DOMContentLoaded', function () {
    function addRow(buttonId, containerId, templateId, rowClass) {
        const button = document.getElementById(buttonId);
        const container = document.getElementById(containerId);
        const template = document.getElementById(templateId);

        button.addEventListener('click', function () {
            const index = container.querySelectorAll('.' + rowClass).length;
            const html = template.innerHTML.replaceAll('__INDEX__', index);

            container.insertAdjacentHTML('beforeend', html);
        });

        container.addEventListener('click', function (event) {
            const removeButton = event.target.closest('.remove-row');

            if (!removeButton) {
                return;
            }

            const row = removeButton.closest('.' + rowClass);

            if (row) {
                row.remove();
            }
        });
    }

    addRow(
        'addLicence',
        'licenceRows',
        'licenceTemplate',
        'licence-row'
    );

    addRow(
        'addAcknowledgement',
        'acknowledgementRows',
        'acknowledgementTemplate',
        'ack-row'
    );
});
</script>
@endsection
