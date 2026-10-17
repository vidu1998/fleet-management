<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\DriverChangeRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;


class DriverController extends Controller
{
    /**
     * Only Maker users can submit driver changes.
     */
    private function authorizeMaker(): void
    {
        $user = Auth::user();

        abort_unless(
            $user &&
                $user->role === 'maker' &&
                !(bool) $user->is_super_admin,
            403,
            'Only Maker users can submit driver changes.'
        );
    }

    /**
     * Display active drivers and the current Maker's recent requests.
     */
    public function index()
    {
        $user = Auth::user();

        $drivers = Driver::with('licenceCategories')
            ->orderBy('name')
            ->paginate(10);

        $myRequests = DriverChangeRequest::where('maker_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        return view('drivers.index', compact('drivers', 'myRequests'));
    }


    /**
     * Display the new driver form.
     */
    public function create()
    {
        $this->authorizeMaker();

        return view('drivers.create', [
            'driver' => new Driver(),
            'licenceCategories' => collect(),
            'acknowledgements' => collect(),
            'formAction' => route('drivers.store'),
            'formMethod' => 'POST',
            'pageTitle' => 'Submit New Driver',
        ]);
    }

    /**
     * Submit a new driver for Checker approval.
     */
    public function store(Request $request)
    {
        $this->authorizeMaker();

        $validated = $this->validateDriver($request);

        $payload = $this->makePayload($validated, $request);

        DriverChangeRequest::create([
            'driver_id' => null,
            'maker_id' => Auth::id(),
            'action' => 'create',
            'payload' => $payload,
            'status' => 'pending',
            'submitted_at' => now(),
        ]);

        return redirect()
            ->route('drivers.index')
            ->with(
                'success',
                'Driver creation request submitted for Checker approval.'
            );
    }

    /**
     * Display the edit form for an existing driver.
     * Existing related records are loaded into the same form.
     */
    public function edit(Driver $driver)
    {
        $this->authorizeMaker();

        $hasPendingRequest = DriverChangeRequest::where(
            'driver_id',
            $driver->id
        )->where('status', 'pending')->exists();

        if ($hasPendingRequest) {
            return redirect()
                ->route('drivers.index')
                ->with(
                    'error',
                    'This driver already has a pending request.'
                );
        }

        $driver->load(['licenceCategories', 'acknowledgements']);

        return view('drivers.create', [
            'driver' => $driver,
            'licenceCategories' => $driver->licenceCategories,
            'acknowledgements' => $driver->acknowledgements,
            'formAction' => route('drivers.update', $driver),
            'formMethod' => 'PUT',
            'pageTitle' => 'Submit Driver Changes',
        ]);
    }

    /**
     * Submit driver changes for Checker approval.
     */
    public function update(Request $request, Driver $driver)
    {
        $this->authorizeMaker();

        $hasPendingRequest = DriverChangeRequest::where(
            'driver_id',
            $driver->id
        )->where('status', 'pending')->exists();

        if ($hasPendingRequest) {
            return redirect()
                ->route('drivers.index')
                ->with(
                    'error',
                    'This driver already has a pending request.'
                );
        }

        $validated = $this->validateDriver($request, $driver);

        $payload = $this->makePayload($validated, $request);

        DriverChangeRequest::create([
            'driver_id' => $driver->id,
            'maker_id' => Auth::id(),
            'action' => 'update',
            'payload' => $payload,
            'status' => 'pending',
            'submitted_at' => now(),
        ]);

        return redirect()
            ->route('drivers.index')
            ->with(
                'success',
                'Driver changes submitted for Checker approval.'
            );
    }

    /**
     * Validate driver details and related form rows.
     *
     * Empty licence rows are ignored.
     * Empty acknowledgement rows are ignored.
     * Acknowledgements are optional.
     */
    private function validateDriver(
        Request $request,
        ?Driver $driver = null
    ): array {
        /*
         * Filter completely blank licence-category rows before validation.
         * A category name is required only when the row is being used.
         */
        $licenceCategories = collect(
            $request->input('licence_categories', [])
        )
            ->filter(function ($row) {
                return is_array($row) &&
                    filled(trim((string) ($row['licence_category'] ?? '')));
            })
            ->values()
            ->all();

        /*
         * Filter acknowledgement rows with blank messages.
         * The user may submit a driver without any acknowledgements.
         */
        $acknowledgements = collect(
            $request->input('acknowledgements', [])
        )
            ->filter(function ($row) {
                return is_array($row) &&
                    filled(trim((string) ($row['message'] ?? '')));
            })
            ->values()
            ->all();

        $request->merge([
            'licence_categories' => $licenceCategories,
            'acknowledgements' => $acknowledgements,
        ]);

        $phoneRule = Rule::unique('drivers', 'phone');

        if ($driver) {
            $phoneRule->ignore($driver->id);
        }

        return $request->validate([
            // Driver details
            'name' => ['required', 'string', 'max:255'],

            'phone' => [
                'nullable',
                'string',
                'max:20',
                $phoneRule,
            ],

            'email' => [
                'nullable',
                'email',
                'max:255',
                Rule::unique('drivers', 'email')->ignore($driver?->id),
            ],
'joined_date' => [
    'required',
    'date',
    'before_or_equal:today',
],
            'drive_mileage' => [
                'required',
                'numeric',
                'min:0',
            ],

            'blood_group' => [
                'nullable',
                Rule::in([
                    'A+',
                    'A-',
                    'B+',
                    'B-',
                    'AB+',
                    'AB-',
                    'O+',
                    'O-',
                ]),
            ],

            'is_smoker' => ['nullable', 'boolean'],
            'is_drinker' => ['nullable', 'boolean'],
            'address' => ['nullable', 'string', 'max:2000'],

            'licence_file' => [
                'nullable',
                'file',
                'mimes:pdf,jpg,jpeg,png',
                'max:5120',
            ],

            // Multiple licence categories
            'licence_categories' => [
                'nullable',
                'array',
                'max:10',
            ],

            'licence_categories.*.licence_category' => [
                'required',
                'string',
                'max:20',
            ],

            'licence_categories.*.expiry_date' => [
                'nullable',
                'date',
            ],

            'licence_categories.*.receive_date' => [
                'nullable',
                'date',
            ],

            // Optional acknowledgements
            'acknowledgements' => [
                'nullable',
                'array',
                'max:20',
            ],

            'acknowledgements.*.message' => [
                'required',
                'string',
                'max:2000',
            ],

            'acknowledgements.*.critical_level' => [
                'required',
                Rule::in(['normal', 'medium', 'high', 'critical']),
            ],
        ]);
    }


    public function licence(Driver $driver)
{
    abort_unless(
        $driver->licence_file_path,
        404,
        'No licence document found.'
    );

    $disk = Storage::disk('public');

    abort_unless(
        $disk->exists($driver->licence_file_path),
        404,
        'Licence file not found.'
    );

    return response()->file(
        $disk->path($driver->licence_file_path)
    );
}

    public function show(Driver $driver)
    {
        $driver->load([
            'licenceCategories',
            'acknowledgements',
        ]);

        return view('drivers.show', compact('driver'));
    }

    
    /**
     * Prepare the JSON payload stored in DriverChangeRequest.
     */
    private function makePayload(
        array $validated,
        Request $request
    ): array {
        $driverData = collect($validated)
            ->except([
                'licence_file',
                'licence_categories',
                'acknowledgements',
            ])
            ->all();

        $driverData['is_smoker'] = $request->boolean('is_smoker');
        $driverData['is_drinker'] = $request->boolean('is_drinker');

        /*
         * If no new file is uploaded during an update, omit
         * licence_file_path so approval preserves the existing path.
         */
        if ($request->hasFile('licence_file')) {
            $driverData['licence_file_path'] = $request
                ->file('licence_file')
                ->store('driver-licences', 'public');
        }

        return [
            'driver' => $driverData,

            'licence_categories' => array_values(
                $validated['licence_categories'] ?? []
            ),

            'acknowledgements' => array_values(
                $validated['acknowledgements'] ?? []
            ),
        ];
    }
}
