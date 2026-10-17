
<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\DriverApprovalController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\VehicleApprovalController;
/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Dashboard Redirect
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    $user = Auth::user();

    if (!$user) {
        return redirect()->route('login');
    }

    if ((bool) $user->is_super_admin) {
        return redirect()->route('admin.dashboard');
    }

    if ($user->role === 'checker') {
        return redirect()->route('checker.dashboard');
    }

    return redirect()->route('maker.dashboard');

})->middleware('auth')->name('dashboard');

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Maker and Checker Dashboards
    |--------------------------------------------------------------------------
    */

    Route::view('/maker/dashboard', 'maker.dashboard')
        ->name('maker.dashboard');

    Route::view('/checker/dashboard', 'checker.dashboard')
        ->name('checker.dashboard');

    /*
    |--------------------------------------------------------------------------
    | Profile Management
    |--------------------------------------------------------------------------
    */

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    /*
    |--------------------------------------------------------------------------
    | Driver Management
    |--------------------------------------------------------------------------
    */

    Route::get('/drivers', [DriverController::class, 'index'])
        ->name('drivers.index');

    Route::get('/drivers/create', [DriverController::class, 'create'])
        ->name('drivers.create');

    Route::post('/drivers', [DriverController::class, 'store'])
        ->name('drivers.store');

    Route::get('/drivers/{driver}/edit', [DriverController::class, 'edit'])
        ->whereNumber('driver')
        ->name('drivers.edit');

    Route::put('/drivers/{driver}', [DriverController::class, 'update'])
        ->whereNumber('driver')
        ->name('drivers.update');

    Route::get('/drivers/{driver}', [DriverController::class, 'show'])
        ->whereNumber('driver')
        ->name('drivers.show');

    /*
    |--------------------------------------------------------------------------
    | Driver Maker–Checker Approvals
    |--------------------------------------------------------------------------
    */

    Route::get('/driver-approvals', [
        DriverApprovalController::class,
        'index',
    ])->name('driver-approvals.index');

    Route::get('/driver-approvals/{driverChangeRequest}', [
        DriverApprovalController::class,
        'show',
    ])->whereNumber('driverChangeRequest')
      ->name('driver-approvals.show');

    Route::post('/driver-approvals/{driverChangeRequest}/approve', [
        DriverApprovalController::class,
        'approve',
    ])->whereNumber('driverChangeRequest')
      ->name('driver-approvals.approve');

    Route::post('/driver-approvals/{driverChangeRequest}/reject', [
        DriverApprovalController::class,
        'reject',
    ])->whereNumber('driverChangeRequest')
      ->name('driver-approvals.reject');

Route::get('/drivers/{driver}/licence', [DriverController::class, 'licence'])
    ->whereNumber('driver')
    ->name('drivers.licence');
   Route::get('/checker/approved-history', [
    DriverApprovalController::class,
    'approvedHistory',
])->name('driver-approvals.approved-history');

// Vehicle Management
    Route::get('/vehicles', [VehicleController::class, 'index'])
        ->name('vehicles.index');

    Route::get('/vehicles/create', [VehicleController::class, 'create'])
        ->name('vehicles.create');

    Route::post('/vehicles', [VehicleController::class, 'store'])
        ->name('vehicles.store');

    Route::get('/vehicles/{vehicle}/edit', [VehicleController::class, 'edit'])
        ->whereNumber('vehicle')
        ->name('vehicles.edit');

    Route::put('/vehicles/{vehicle}', [VehicleController::class, 'update'])
        ->whereNumber('vehicle')
        ->name('vehicles.update');

    Route::get('/vehicles/{vehicle}', [VehicleController::class, 'show'])
        ->whereNumber('vehicle')
        ->name('vehicles.show');


    // Vehicle Approvals
    Route::get('/vehicle-approvals', [
        VehicleApprovalController::class,
        'index',
    ])->name('vehicle-approvals.index');

    Route::get('/vehicle-approvals/approved-history', [
        VehicleApprovalController::class,
        'approvedHistory',
    ])->name('vehicle-approvals.approved-history');

    Route::get('/vehicle-approvals/{vehicleChangeRequest}', [
        VehicleApprovalController::class,
        'show',
    ])->whereNumber('vehicleChangeRequest')
      ->name('vehicle-approvals.show');

    Route::post('/vehicle-approvals/{vehicleChangeRequest}/approve', [
        VehicleApprovalController::class,
        'approve',
    ])->whereNumber('vehicleChangeRequest')
      ->name('vehicle-approvals.approve');

    Route::post('/vehicle-approvals/{vehicleChangeRequest}/reject', [
        VehicleApprovalController::class,
        'reject',
    ])->whereNumber('vehicleChangeRequest')
      ->name('vehicle-approvals.reject');






});

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';
