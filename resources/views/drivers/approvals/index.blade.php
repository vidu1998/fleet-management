@extends('layouts.admin')

@section('title', 'Driver Approvals')

@section('header', 'Driver Approval Queue')

@section('content')
<div class="container-fluid">
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="mb-4">
        <h3 class="fw-bold">Driver Approval Queue</h3>
        <p class="text-muted mb-0">
            Review Maker submissions before applying changes to active driver records.
        </p>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Request</th>
                        <th>Driver</th>
                        <th>Action</th>
                        <th>Maker</th>
                        <th>Submitted</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($requests as $item)
                        <tr>
                            <td>#{{ $item->id }}</td>
                            <td>
                                {{ $item->driver?->name
                                    ?? data_get($item->payload, 'driver.name', 'New driver') }}
                            </td>
                            <td>{{ ucfirst($item->action) }}</td>
                            <td>{{ $item->maker?->name ?? 'Unknown' }}</td>
                            <td>{{ $item->submitted_at?->format('Y-m-d H:i') }}</td>
                            <td><span class="badge bg-warning text-dark">Pending</span></td>
                            <td>
                                <a href="{{ route('driver-approvals.show', $item) }}"
                                   class="btn btn-sm btn-primary">
                                    Review
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-5">
                                <i class="bi bi-check-circle fs-2 d-block mb-2"></i>
                                There are no pending driver requests.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-body">
            {{ $requests->links() }}
        </div>
    </div>
</div>
@endsection