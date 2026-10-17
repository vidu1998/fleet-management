@extends('layouts.admin')

@section('title', 'Review Driver Request')

@section('header', 'Review Driver Request')

@section('content')
@php
$payload = $changeRequest->payload;
$driverData = $payload['driver'] ?? [];
@endphp

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold">Request #{{ $changeRequest->id }}</h3>
            <p class="text-muted mb-0">
                Submitted by {{ $changeRequest->maker?->name ?? 'Unknown' }}
                on {{ $changeRequest->submitted_at?->format('Y-m-d H:i') }}
            </p>
        </div>

        <span class="badge bg-warning text-dark fs-6">
            {{ ucfirst($changeRequest->status) }}
        </span>
    </div>

    @if ($errors->any())
    <div class="alert alert-danger">
        @foreach ($errors->all() as $error)
        <div>{{ $error }}</div>
        @endforeach
    </div>
    @endif

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0">Proposed Driver Details</h5>
        </div>
        <div class="card-body">
            <dl class="row mb-0">
                <dt class="col-sm-3">Request Type</dt>
                <dd class="col-sm-9">{{ ucfirst($changeRequest->action) }}</dd>

                <dt class="col-sm-3">Name</dt>
                <dd class="col-sm-9">{{ $driverData['name'] ?? '—' }}</dd>

                <dt class="col-sm-3">Phone</dt>
                <dd class="col-sm-9">{{ $driverData['phone'] ?? '—' }}</dd>

                <dt class="col-sm-3">Email</dt>
                <dd class="col-sm-9">{{ $driverData['email'] ?? '—' }}</dd>
                <dt class="col-sm-3">Join Date</dt>
                <dd class="col-sm-9">
                    @if (!empty($driverData['joined_date']))
                    {{ \Carbon\Carbon::parse($driverData['joined_date'])->format('d M Y') }}
                    @else
                    —
                    @endif
                </dd>
                <dt class="col-sm-3">Mileage</dt>
                <dd class="col-sm-9">{{ $driverData['drive_mileage'] ?? '—' }}</dd>

                <dt class="col-sm-3">Blood Group</dt>
                <dd class="col-sm-9">{{ $driverData['blood_group'] ?? '—' }}</dd>

                <dt class="col-sm-3">Smoker</dt>
                <dd class="col-sm-9">{{ !empty($driverData['is_smoker']) ? 'Yes' : 'No' }}</dd>

                <dt class="col-sm-3">Drinker</dt>
                <dd class="col-sm-9">{{ !empty($driverData['is_drinker']) ? 'Yes' : 'No' }}</dd>

                <dt class="col-sm-3">Address</dt>
                <dd class="col-sm-9">{{ $driverData['address'] ?? '—' }}</dd>

                <dt class="col-sm-3">Licence File</dt>
                <dd class="col-sm-9">
                    {{ !empty($driverData['licence_file_path']) ? 'File uploaded' : 'No new file uploaded' }}
                </dd>
            </dl>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0">Licence Categories</h5>
        </div>
        <div class="table-responsive">
            <table class="table mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Category</th>
                        <th>Expiry Date</th>
                        <th>Received Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($payload['licence_categories'] ?? [] as $licence)
                    <tr>
                        <td>{{ $licence['licence_category'] ?? '—' }}</td>
                        <td>{{ $licence['expiry_date'] ?? '—' }}</td>
                        <td>{{ $licence['receive_date'] ?? '—' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-muted">No categories submitted.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0">Acknowledgements</h5>
        </div>
        <div class="table-responsive">
            <table class="table mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Message</th>
                        <th>Critical Level</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($payload['acknowledgements'] ?? [] as $ack)
                    <tr>
                        <td>{{ $ack['message'] ?? '—' }}</td>
                        <td>{{ ucfirst($ack['critical_level'] ?? 'normal') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="2" class="text-muted">No acknowledgements submitted.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if ($changeRequest->status === 'pending')
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0">Review Decision</h5>
        </div>
        <div class="card-body">
            <form method="POST"
                action="{{ route('driver-approvals.approve', $changeRequest) }}"
                class="mb-3">
                @csrf
                <label class="form-label">Checker Comment (optional)</label>
                <textarea name="checker_comment" class="form-control mb-3"
                    rows="2" placeholder="Approval notes"></textarea>

                <button class="btn btn-success"
                    onclick="return confirm('Approve and apply these driver changes?')">
                    <i class="bi bi-check-lg me-1"></i> Approve Request
                </button>
            </form>

            <hr>

            <form method="POST"
                action="{{ route('driver-approvals.reject', $changeRequest) }}">
                @csrf
                <label class="form-label">Rejection Reason (required)</label>
                <textarea name="checker_comment" class="form-control mb-3"
                    rows="2" required
                    placeholder="Explain why the request is rejected"></textarea>

                <button class="btn btn-danger"
                    onclick="return confirm('Reject this request?')">
                    <i class="bi bi-x-lg me-1"></i> Reject Request
                </button>
            </form>
        </div>
    </div>
    @else
    <div class="alert alert-secondary">
        This request has already been reviewed.
        @if ($changeRequest->checker_comment)
        <div class="mt-2">
            <strong>Checker comment:</strong>
            {{ $changeRequest->checker_comment }}
        </div>
        @endif
    </div>
    @endif

    <a href="{{ route('driver-approvals.index') }}" class="btn btn-light border mt-3">
        Back to Approval Queue
    </a>
</div>
@endsection