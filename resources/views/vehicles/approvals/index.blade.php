
@extends('layouts.admin')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Vehicle Approvals</h2>
            <p class="text-muted mb-0">Review vehicle registration and update requests.</p>
        </div>

        <a href="{{ route('vehicle-approvals.approved-history') }}"
           class="btn btn-outline-success">
            Approved History
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0">Pending Vehicle Requests</h5>
        </div>

        <div class="card-body table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Request ID</th>
                        <th>Registration No.</th>
                        <th>Request Type</th>
                        <th>Submitted By</th>
                        <th>Submitted Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($pendingRequests as $request)
                        @php
                            $vehicleData = $request->payload['vehicle'] ?? [];
                        @endphp

                        <tr>
                            <td>{{ $request->id }}</td>
                            <td>
                                <strong>
                                    {{ $vehicleData['registration_no']
                                        ?? $request->vehicle?->registration_no
                                        ?? 'Not provided' }}
                                </strong>
                            </td>
                            <td>{{ ucfirst($request->action) }}</td>
                            <td>{{ $request->maker?->name ?? 'Unknown' }}</td>
                            <td>
                                {{ $request->submitted_at?->format('d M Y, h:i A') ?? '—' }}
                            </td>
                            <td>
                                <span class="badge bg-warning text-dark">
                                    {{ ucfirst($request->status) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('vehicle-approvals.show', $request) }}"
                                   class="btn btn-sm btn-primary">
                                    Review
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                No pending vehicle requests.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{ $pendingRequests->links() }}
        </div>
    </div>
</div>
@endsection
