<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserManagementController extends Controller
{
    /**
     * Allow only Super Admin users.
     */
    private function authorizeSuperAdmin(): void
    {
        abort_unless(
            (bool) Auth::user()?->is_super_admin,
            403,
            'Only Super Admins can manage users.'
        );
    }

    /**
     * Display users, search, filters and statistics.
     */
    public function index(Request $request)
    {
        $this->authorizeSuperAdmin();

        $query = User::query();

        if ($request->filled('search')) {
            $search = $request->input('search');

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if (in_array($request->input('role'), ['maker', 'checker', 'admin'], true)) {
            if ($request->input('role') === 'admin') {
                $query->where('is_super_admin', true);
            } else {
                $query->where('role', $request->input('role'))
                    ->where('is_super_admin', false);
            }
        }

        $totalUsers = User::count();

        $totalMakers = User::where('role', 'maker')
            ->where('is_super_admin', false)
            ->count();

        $totalCheckers = User::where('role', 'checker')
            ->where('is_super_admin', false)
            ->count();

        $users = $query->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('admin.users.index', compact(
            'users',
            'totalUsers',
            'totalMakers',
            'totalCheckers'
        ));
    }

    /**
     * Show the Create Checker form.
     */
    public function create()
    {
        $this->authorizeSuperAdmin();

        return view('admin.users.create');
    }

    /**
     * Create a Checker account.
     */
    public function store(Request $request)
    {
        $this->authorizeSuperAdmin();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:12', 'confirmed'],
        ]);

        $user = new User();
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->password = Hash::make($validated['password']);
        $user->role = 'checker';
        $user->is_super_admin = false;
        $user->save();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Checker account created successfully.');
    }

    /**
     * Change a user's role between Maker and Checker.
     */
    public function updateRole(Request $request, User $user)
    {
        $this->authorizeSuperAdmin();

        abort_if(
            (bool) $user->is_super_admin,
            403,
            'Super Admin accounts cannot be changed here.'
        );

        abort_if(
            (int) $user->id === (int) Auth::id(),
            403,
            'You cannot change your own role here.'
        );

        $validated = $request->validate([
            'role' => ['required', Rule::in(['maker', 'checker'])],
        ]);

        $user->role = $validated['role'];
        $user->save();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User role updated successfully.');
    }
}
