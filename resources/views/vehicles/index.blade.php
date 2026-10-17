
@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Vehicle Management</h2>
        <a href="{{ route('vehicles.create') }}" class="btn btn-primary">
            + Add Vehicle
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Reg. No.</th>
                        <th>Make</th>
                        <th>Year</th>
                        <th>Type</th>
                        <th>Fuel</th>
                        <th>ODO (km)</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($vehicles as $vehicle)
                        <tr>
                            <td>{{ $vehicle->registration_no }}</td>
                            <td>{{ $vehicle->make }}</td>
                            <td>{{ $vehicle->manufacture_year }}</td>
                            <td>{{ $vehicle->type }}</td>
                            <td>{{ $vehicle->fuel_type }}</td>
                            <td>{{ number_format((float) $vehicle->current_odo_reading, 2) }}</td>
                            <td>
                                <a href="{{ route('vehicles.show', $vehicle) }}"
                                   class="btn btn-sm btn-outline-info">Details</a>

                                <a href="{{ route('vehicles.edit', $vehicle) }}"
                                   class="btn btn-sm btn-outline-primary">Edit</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                No approved vehicles found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{ $vehicles->links() }}
        </div>
    </div>

    @if(isset($myRequests) && $myRequests->isNotEmpty())
        <div class="card shadow-sm border-0 mt-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">My Recent Vehicle Requests</h5>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Action</th>
                            <th>Status</th>
                            <th>Submitted</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($myRequests as $request)
                            <tr>
                                <td>{{ $request->id }}</td>
                                <td>{{ ucfirst($request->action) }}</td>
                                <td>{{ ucfirst($request->status) }}</td>
                                <td>{{ $request->submitted_at?->format('d M Y H:i') ?? '—' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
@endsection
