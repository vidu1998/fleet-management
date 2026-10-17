 @extends('layouts.admin')

@section('title', 'Approved Driver History')

@section('content')
<div class="container-fluid py-4">

    <h2 class="mb-2">Approved Driver History</h2>
    <p class="text-muted mb-4">
        Driver requests submitted by you and approved by a Checker.
    </p>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Request ID</th>
                        <th>Driver</th>
                        <th>Action</th>
                        <th>Approved By</th>
                        <th>Approval Date</th>
                        <th>Checker Comment</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($approvedRequests as $item)
                        <tr>
                            <td>#{{ $item->id }}</td>
                            <td>
                                {{ data_get(
                                    $item->payload,
                                    'driver.name',
                                    $item->driver?->name ?? '—'
                                ) }}
                            </td>
                            <td>{{ ucfirst($item->action) }}</td>
                            <td>{{ $item->checker?->name ?? '—' }}</td>
                            <td>
                                {{ $item->reviewed_at
                                    ? $item->reviewed_at->format('d M Y, h:i A')
                                    : '—' }}
                            </td>
                            <td>{{ $item->checker_comment ?: '—' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                No approved driver requests found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $approvedRequests->links() }}
    </div>

</div>
@endsection