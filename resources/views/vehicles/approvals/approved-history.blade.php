
@extends('layouts.admin')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Approved Vehicle History</h2>
            <p class="text-muted mb-0">
                Previously approved vehicle registration and update requests.
            </p>
        </div>

        <a href="{{ route('vehicle-approvals.index') }}"
           class="btn btn-outline-secondary">
            Pending Requests
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0">Approval Records</h5>
        </div>

        <div class="card-body table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Request ID</th>
                        <th>Registration No.</th>
                        <th>Request Type</th>
                        <th>Submitted By</th>
                        <th>Approved By</th>
                        <th>Approval Date</th>
                        <th>Details</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($approvedRequests as $request)
                        @php
                            $vehicleData = $request->payload['vehicle'] ?? [];
                        @endphp

                        <tr>
                            <td>{{ $request->id }}</td>

                            <td>
                                {{ $vehicleData['registration_no']
                                    ?? $request->vehicle?->registration_no
                                    ?? '—' }}
                            </td>

                            <td>{{ ucfirst($request->action) }}</td>

                            <td>{{ $request->maker?->name ?? 'Unknown' }}</td>

                            <td>{{ $request->checker?->name ?? 'Unknown' }}</td>

                            <td>
                                {{ $request->reviewed_at?->format('d M Y, h:i A') ?? '—' }}
                            </td>

                            <td>
                                <a
                                    href="{{ route('vehicle-approvals.show', $request) }}"
                                    class="btn btn-sm btn-outline-primary"
                                >
                                    View Request
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                No approved vehicle requests found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{ $approvedRequests->links() }}
        </div>
    </div>
</div>
@endsection
