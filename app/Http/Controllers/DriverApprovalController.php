<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\DriverAcknowledgement;
use App\Models\DriverChangeRequest;
use App\Models\DriverLicenceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DriverApprovalController extends Controller
{
    private function authorizeChecker(): void
{
    abort_unless(
        Auth::user()?->role === 'checker'
        && !(bool) Auth::user()?->is_super_admin,
        403,
        'Only Checker users can review driver requests.'
    );
}

    public function index()
    {
        $this->authorizeChecker();

        $requests = DriverChangeRequest::with(['maker', 'driver'])
            ->where('status', 'pending')
            ->latest()
            ->paginate(10);

        return view('drivers.approvals.index', compact('requests'));
    }

    public function show(DriverChangeRequest $driverChangeRequest)
    {
        $this->authorizeChecker();

        return view('drivers.approvals.show', [
            'changeRequest' => $driverChangeRequest->load(['maker', 'driver']),
        ]);
    }

    public function approve(
        Request $request,
        DriverChangeRequest $driverChangeRequest
    ) {
        $this->authorizeChecker();

        $validated = $request->validate([
            'checker_comment' => ['nullable', 'string', 'max:2000'],
        ]);

        DB::transaction(function () use (
            $driverChangeRequest,
            $validated
        ) {
            // Lock and re-read the request to prevent double approval.
            $changeRequest = DriverChangeRequest::whereKey(
                $driverChangeRequest->id
            )->lockForUpdate()->firstOrFail();

            abort_unless(
                $changeRequest->status === 'pending',
                422,
                'This request has already been reviewed.'
            );

            // A Maker must not approve their own request.
            abort_if(
                $changeRequest->maker_id === Auth::id(),
                403,
                'You cannot approve your own request.'
            );

            $payload = $changeRequest->payload;
            $driverData = $payload['driver'] ?? [];

            if ($changeRequest->action === 'create') {
                $driver = Driver::create($driverData);
                $changeRequest->driver_id = $driver->id;
            } elseif ($changeRequest->action === 'update') {
                $driver = Driver::whereKey(
                    $changeRequest->driver_id
                )->lockForUpdate()->firstOrFail();

                $driver->fill($driverData);
                $driver->save();

                // Replace related records only after approval.
                $driver->licenceCategories()->delete();
                $driver->acknowledgements()->delete();
            } else {
                abort(422, 'Unknown driver request action.');
            }

            foreach ($payload['licence_categories'] ?? [] as $category) {
                $driver->licenceCategories()->create([
                    'licence_category' => $category['licence_category'],
                    'expiry_date' => $category['expiry_date'] ?? null,
                    'receive_date' => $category['receive_date'] ?? null,
                ]);
            }

            foreach ($payload['acknowledgements'] ?? [] as $acknowledgement) {
                $driver->acknowledgements()->create([
                    'message' => $acknowledgement['message'],
                    'critical_level' => $acknowledgement['critical_level'],
                ]);
            }

            $changeRequest->status = 'approved';
            $changeRequest->checker_id = Auth::id();
            $changeRequest->checker_comment =
                $validated['checker_comment'] ?? null;
            $changeRequest->reviewed_at = now();
            $changeRequest->save();
        });

        return redirect()
            ->route('driver-approvals.index')
            ->with('success', 'Driver request approved successfully.');
    }
public function approvedHistory()
{
    $this->authorizeChecker();

    $user = Auth::user();

    $approvedRequests = DriverChangeRequest::with([
        'maker',
        'checker',
        'driver',
    ])
        ->where('status', 'approved')
        ->where('checker_id', $user->id)
        ->latest('reviewed_at')
        ->paginate(15);

    return view(
        'drivers.approvals.approved-history',
        compact('approvedRequests')
    );
}
    public function reject(
        Request $request,
        DriverChangeRequest $driverChangeRequest
    ) {
        $this->authorizeChecker();

        $validated = $request->validate([
            'checker_comment' => ['required', 'string', 'max:2000'],
        ]);

        DB::transaction(function () use (
            $driverChangeRequest,
            $validated
        ) {
            $changeRequest = DriverChangeRequest::whereKey(
                $driverChangeRequest->id
            )->lockForUpdate()->firstOrFail();

            abort_unless(
                $changeRequest->status === 'pending',
                422,
                'This request has already been reviewed.'
            );

            abort_if(
                $changeRequest->maker_id === Auth::id(),
                403,
                'You cannot reject your own request.'
            );

            $changeRequest->status = 'rejected';
            $changeRequest->checker_id = Auth::id();
            $changeRequest->checker_comment = $validated['checker_comment'];
            $changeRequest->reviewed_at = now();
            $changeRequest->save();
        });

        return redirect()
            ->route('driver-approvals.index')
            ->with('success', 'Driver request rejected.');
    }
}