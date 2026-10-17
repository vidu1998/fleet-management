<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\VehicleChangeRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class VehicleApprovalController extends Controller
{
    /**
     * Only Checkers and Super Admins can review vehicle requests.
     */
    private function authorizeChecker(): void
{
    $user = Auth::user();

    abort_unless(
        $user && $user->role === 'checker',
        403,
        'Only Checkers are authorized to review vehicle requests.'
    );
}

    /**
     * Display pending vehicle requests.
     */
    public function index()
    {
        $this->authorizeChecker();

        $pendingRequests = VehicleChangeRequest::with([
            'maker',
            'vehicle',
        ])
            ->where('status', 'pending')
            ->latest('submitted_at')
            ->paginate(15);

        return view(
            'vehicles.approvals.index',
            compact('pendingRequests')
        );
    }

    /**
     * Display a proposed vehicle request.
     */
    public function show(VehicleChangeRequest $vehicleChangeRequest)
    {
        $this->authorizeChecker();

        $vehicleChangeRequest->load([
            'maker',
            'checker',
            'vehicle',
        ]);

        $vehicleData = $vehicleChangeRequest->payload['vehicle'] ?? [];

        return view(
            'vehicles.approvals.show',
            compact('vehicleChangeRequest', 'vehicleData')
        );
    }

    /**
     * Approve a vehicle creation or update request.
     */
    public function approve(VehicleChangeRequest $vehicleChangeRequest)
    {
        $this->authorizeChecker();

        $user = Auth::user();

        abort_if(
            $vehicleChangeRequest->maker_id === $user->id,
            403,
            'You cannot approve your own request.'
        );

        if ($vehicleChangeRequest->status !== 'pending') {
            return redirect()
                ->route('vehicle-approvals.index')
                ->with('error', 'This request has already been reviewed.');
        }

        DB::transaction(function () use (
            $vehicleChangeRequest,
            $user
        ) {
            $changeRequest = VehicleChangeRequest::whereKey(
                $vehicleChangeRequest->id
            )->lockForUpdate()->firstOrFail();

            if ($changeRequest->status !== 'pending') {
                abort(409, 'This request has already been reviewed.');
            }

            $data = $changeRequest->payload['vehicle'] ?? [];

            if (empty($data)) {
                abort(422, 'The vehicle request contains no vehicle data.');
            }

            // Check registration number again when approving.
            $duplicate = Vehicle::where(
                'registration_no',
                $data['registration_no'] ?? ''
            );

            if ($changeRequest->action === 'update') {
                $duplicate->where('id', '!=', $changeRequest->vehicle_id);
            }

            if ($duplicate->exists()) {
                abort(
                    422,
                    'This registration number is already in use. Reject this request and ask the Maker to correct it.'
                );
            }

            if ($changeRequest->action === 'create') {
                $vehicle = Vehicle::create($data);

                $changeRequest->vehicle_id = $vehicle->id;
            } elseif ($changeRequest->action === 'update') {
                $vehicle = Vehicle::findOrFail(
                    $changeRequest->vehicle_id
                );

                $vehicle->update($data);
            } else {
                abort(422, 'Unknown vehicle request action.');
            }

            $changeRequest->status = 'approved';
            $changeRequest->checker_id = $user->id;
            $changeRequest->checker_comment = null;
            $changeRequest->reviewed_at = now();
            $changeRequest->save();
        });

        return redirect()
            ->route('vehicle-approvals.index')
            ->with('success', 'Vehicle request approved successfully.');
    }

    /**
     * Reject a pending vehicle request.
     */
    public function reject(
        Request $request,
        VehicleChangeRequest $vehicleChangeRequest
    ) {
        $this->authorizeChecker();

        abort_if(
            $vehicleChangeRequest->maker_id === Auth::id(),
            403,
            'You cannot reject your own request.'
        );

        $validated = $request->validate([
            'checker_comment' => [
                'required',
                'string',
                'max:2000',
            ],
        ]);

        if ($vehicleChangeRequest->status !== 'pending') {
            return redirect()
                ->route('vehicle-approvals.index')
                ->with('error', 'This request has already been reviewed.');
        }

        DB::transaction(function () use (
            $vehicleChangeRequest,
            $validated
        ) {
            $changeRequest = VehicleChangeRequest::whereKey(
                $vehicleChangeRequest->id
            )->lockForUpdate()->firstOrFail();

            if ($changeRequest->status !== 'pending') {
                abort(409, 'This request has already been reviewed.');
            }

            $changeRequest->status = 'rejected';
            $changeRequest->checker_id = Auth::id();
            $changeRequest->checker_comment =
                $validated['checker_comment'];
            $changeRequest->reviewed_at = now();
            $changeRequest->save();
        });

        return redirect()
            ->route('vehicle-approvals.index')
            ->with('success', 'Vehicle request rejected.');
    }

    /**
     * Display approved vehicle request history.
     */
    public function approvedHistory()
    {
        $this->authorizeChecker();

        $user = Auth::user();

        $query = VehicleChangeRequest::with([
            'maker',
            'checker',
            'vehicle',
        ])->where('status', 'approved');

        // Checkers see only requests they approved.
        // Super Admins can see all approved requests.
        if (!(bool) $user->is_super_admin) {
            $query->where('checker_id', $user->id);
        }

        $approvedRequests = $query
            ->latest('reviewed_at')
            ->paginate(15);

        return view(
            'vehicles.approvals.approved-history',
            compact('approvedRequests')
        );
    }
}
