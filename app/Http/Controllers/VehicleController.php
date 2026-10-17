<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\VehicleChangeRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class VehicleController extends Controller
{
    private function authorizeMaker(): void
    {
        $user = Auth::user();

        abort_unless(
            $user &&
            $user->role === 'maker' &&
            !(bool) $user->is_super_admin,
            403,
            'Only Maker users can submit vehicle changes.'
        );
    }

 public function index()
{
    $vehicles = Vehicle::orderBy('registration_no')
        ->paginate(10);

    $myRequests = VehicleChangeRequest::where(
        'maker_id',
        Auth::id()
    )
        ->latest()
        ->take(5)
        ->get();

    return view('vehicles.index', compact(
        'vehicles',
        'myRequests'
    ));
}

    public function create()
    {
        $this->authorizeMaker();

        return view('vehicles.create', [
            'vehicle' => new Vehicle(),
            'formAction' => route('vehicles.store'),
            'formMethod' => 'POST',
            'pageTitle' => 'Submit New Vehicle',
        ]);
    }

    public function store(Request $request)
    {
        $this->authorizeMaker();

        $validated = $this->validateVehicle($request);

        VehicleChangeRequest::create([
            'vehicle_id' => null,
            'maker_id' => Auth::id(),
            'action' => 'create',
            'payload' => ['vehicle' => $validated],
            'status' => 'pending',
            'submitted_at' => now(),
        ]);

        return redirect()
            ->route('vehicles.index')
            ->with('success',
                'Vehicle request submitted for Checker approval.');
    }

    public function show(Vehicle $vehicle)
    {
        return view('vehicles.show', compact('vehicle'));
    }

    public function edit(Vehicle $vehicle)
    {
        $this->authorizeMaker();

        $hasPendingRequest = VehicleChangeRequest::where(
            'vehicle_id',
            $vehicle->id
        )->where('status', 'pending')->exists();

        if ($hasPendingRequest) {
            return redirect()
                ->route('vehicles.index')
                ->with('error',
                    'This vehicle already has a pending request.');
        }

        return view('vehicles.create', [
            'vehicle' => $vehicle,
            'formAction' => route('vehicles.update', $vehicle),
            'formMethod' => 'PUT',
            'pageTitle' => 'Submit Vehicle Changes',
        ]);
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        $this->authorizeMaker();

        $hasPendingRequest = VehicleChangeRequest::where(
            'vehicle_id',
            $vehicle->id
        )->where('status', 'pending')->exists();

        if ($hasPendingRequest) {
            return redirect()
                ->route('vehicles.index')
                ->with('error',
                    'This vehicle already has a pending request.');
        }

        $validated = $this->validateVehicle($request, $vehicle);

        VehicleChangeRequest::create([
            'vehicle_id' => $vehicle->id,
            'maker_id' => Auth::id(),
            'action' => 'update',
            'payload' => ['vehicle' => $validated],
            'status' => 'pending',
            'submitted_at' => now(),
        ]);

        return redirect()
            ->route('vehicles.index')
            ->with('success',
                'Vehicle changes submitted for Checker approval.');
    }

    private function validateVehicle(
        Request $request,
        ?Vehicle $vehicle = null
    ): array {
        return $request->validate([
            'registration_no' => [
                'required',
                'string',
                'max:30',
                Rule::unique('vehicles', 'registration_no')
                    ->ignore($vehicle?->id),
            ],

            'make' => ['required', 'string', 'max:100'],

            'manufacture_year' => [
                'required',
                'integer',
                'min:1900',
                'max:' . (date('Y') + 1),
            ],

            'type' => [
                'required',
                Rule::in([
                    'Car', 'Bus', 'Lorry', 'Van',
                    'Motorcycle', 'Other',
                ]),
            ],

            'fuel_type' => [
                'required',
                Rule::in([
                    'Diesel', 'Petrol', 'EV', 'CNG', 'LPG',
                ]),
            ],

            'color' => ['nullable', 'string', 'max:50'],

            'purchased_date' => [
                'nullable',
                'date',
                'before_or_equal:today',
            ],

            'purchased_price' => [
                'nullable',
                'numeric',
                'min:0',
                'max:999999999999.99',
            ],

            'insurance_expire_date' => ['nullable', 'date'],
            'road_tax_expire_date' => ['nullable', 'date'],

            'current_odo_reading' => [
                'required',
                'numeric',
                'min:0',
                'max:9999999999.99',
            ],

            'engine_condition_percentage' => [
                'required', 'integer', 'between:0,100',
            ],

            'body_condition_percentage' => [
                'required', 'integer', 'between:0,100',
            ],

            'current_location' => [
                'nullable', 'string', 'max:255',
            ],

            'parking_location' => [
                'nullable', 'string', 'max:255',
            ],
        ]);
    }
}
