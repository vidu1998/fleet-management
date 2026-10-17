<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\DriverChangeRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $currentUser = Auth::user();

        abort_unless($currentUser, 401);

        $isSuperAdmin = (bool) $currentUser->is_super_admin;
        $role = $isSuperAdmin ? 'admin' : $currentUser->role;

        // Common fleet statistics
        $totalDrivers = Driver::count();

        // Super Admin statistics
        $totalUsers = 0;
        $totalMakers = 0;
        $totalCheckers = 0;
        $superAdmins = 0;
        $recentUsers = collect();

        // Maker statistics
        $myRequests = 0;
        $pendingRequests = 0;
        $approvedRequests = 0;
        $rejectedRequests = 0;
        $recentRequests = collect();

        // Checker statistics
        $approvedByMe = 0;
        $rejectedByMe = 0;
        $pendingQueue = collect();

        if ($isSuperAdmin) {
            $totalUsers = User::count();

            $totalMakers = User::where('role', 'maker')
                ->where('is_super_admin', false)
                ->count();

            $totalCheckers = User::where('role', 'checker')
                ->where('is_super_admin', false)
                ->count();

            $superAdmins = User::where('is_super_admin', true)->count();

            $recentUsers = User::latest()->take(5)->get();
        } elseif ($role === 'maker') {
            $requests = DriverChangeRequest::where(
                'maker_id',
                $currentUser->id
            );

            $myRequests = (clone $requests)->count();

            $pendingRequests = (clone $requests)
                ->where('status', 'pending')->count();

            $approvedRequests = (clone $requests)
                ->where('status', 'approved')->count();

            $rejectedRequests = (clone $requests)
                ->where('status', 'rejected')->count();

            $recentRequests = DriverChangeRequest::with(['driver', 'checker'])
                ->where('maker_id', $currentUser->id)
                ->latest()
                ->take(8)
                ->get();
        } elseif ($role === 'checker') {
            $pendingRequests = DriverChangeRequest::where('status', 'pending')
                ->count();

            $approvedByMe = DriverChangeRequest::where(
                'checker_id',
                $currentUser->id
            )->where('status', 'approved')->count();

            $rejectedByMe = DriverChangeRequest::where(
                'checker_id',
                $currentUser->id
            )->where('status', 'rejected')->count();

            $pendingQueue = DriverChangeRequest::with(['maker', 'driver'])
                ->where('status', 'pending')
                ->latest()
                ->take(8)
                ->get();
        } else {
            abort(403, 'Your account has no valid dashboard role.');
        }

        return view('admin.dashboard', compact(
            'role',
            'totalDrivers',
            'totalUsers',
            'totalMakers',
            'totalCheckers',
            'superAdmins',
            'recentUsers',
            'myRequests',
            'pendingRequests',
            'approvedRequests',
            'rejectedRequests',
            'recentRequests',
            'approvedByMe',
            'rejectedByMe',
            'pendingQueue'
        ));
    }
}