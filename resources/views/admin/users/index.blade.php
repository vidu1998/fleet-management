
@extends('layouts.admin')

@section('title', 'User Management')
@section('header', 'User Management')

@section('content')

{{-- Page heading --}}
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div>
        <h1 class="page-heading">User Management</h1>
        <p class="muted mb-0">Manage system users, permissions and Maker–Checker roles.</p>
    </div>

    <a href="{{ route('admin.users.create') }}" class="btn btn-primary px-4 py-2">
        <i class="bi bi-person-plus-fill me-2"></i>Create Checker
    </a>
</div>

{{-- Statistics --}}
<div class="row g-3 mb-4">
    <div class="col-12 col-sm-4">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="muted small">Total Users</div>
                    <div class="stat-number">{{ $totalUsers }}</div>
                    <small class="muted">All system accounts</small>
                </div>
                <div class="stat-icon bg-primary-subtle text-primary">
                    <i class="bi bi-people-fill"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-4">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="muted small">Makers</div>
                    <div class="stat-number">{{ $totalMakers }}</div>
                    <small class="muted">Submit changes</small>
                </div>
                <div class="stat-icon bg-warning-subtle text-warning">
                    <i class="bi bi-pencil-square"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-4">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="muted small">Checkers</div>
                    <div class="stat-number">{{ $totalCheckers }}</div>
                    <small class="muted">Review changes</small>
                </div>
                <div class="stat-icon bg-success-subtle text-success">
                    <i class="bi bi-shield-check"></i>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Users panel --}}
<div class="content-card p-0 overflow-hidden">

    {{-- Panel heading --}}
    <div class="p-4 border-bottom d-flex flex-wrap justify-content-between align-items-center gap-2">
        <div>
            <h5 class="fw-bold mb-1">Registered Accounts</h5>
            <small class="muted">View and manage access to the system.</small>
        </div>

        <span class="badge rounded-pill bg-light text-dark border px-3 py-2">
            {{ $users->total() }} records
        </span>
    </div>

    {{-- Search and filters --}}
    <div class="p-4 border-bottom" style="background: #fafbfd;">
        <form method="GET" action="{{ route('admin.users.index') }}">
            <div class="row g-3">
                <div class="col-12 col-md-6">
                    <label for="search" class="form-label small fw-semibold">Search users</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white">
                            <i class="bi bi-search text-secondary"></i>
                        </span>
                        <input
                            type="text"
                            id="search"
                            name="search"
                            value="{{ request('search') }}"
                            class="form-control"
                            placeholder="Name or email address">
                    </div>
                </div>

                <div class="col-12 col-md-3">
                    <label for="role" class="form-label small fw-semibold">Filter by role</label>
                    <select name="role" id="role" class="form-select">
                        <option value="">All roles</option>
                        <option value="maker" @selected(request('role') === 'maker')>Maker</option>
                        <option value="checker" @selected(request('role') === 'checker')>Checker</option>
                        <option value="admin" @selected(request('role') === 'admin')>Super Admin</option>
                    </select>
                </div>

                <div class="col-12 col-md-3 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-dark flex-grow-1">
                        <i class="bi bi-funnel me-1"></i>Filter
                    </button>
                    <a href="{{ route('admin.users.index') }}"
                       class="btn btn-outline-secondary"
                       title="Reset filters">
                        <i class="bi bi-arrow-counterclockwise"></i>
                    </a>
                </div>
            </div>
        </form>
    </div>

    {{-- User table --}}
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead style="background: #f5f7fb;">
                <tr>
                    <th class="px-4 py-3 text-secondary small">USER</th>
                    <th class="py-3 text-secondary small">ROLE</th>
                    <th class="py-3 text-secondary small">ACCOUNT TYPE</th>
                    <th class="py-3 text-secondary small">CREATED</th>
                    <th class="px-4 py-3 text-secondary small text-end">ACTIONS</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td class="px-4 py-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="avatar flex-shrink-0">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="fw-semibold text-dark">
                                        {{ $user->name }}
                                    </div>
                                    <div class="small muted">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>

                        <td>
                            @if ($user->is_super_admin)
                                <span class="badge rounded-pill bg-primary-subtle text-primary px-3 py-2">
                                    <i class="bi bi-shield-lock me-1"></i>Super Admin
                                </span>
                            @elseif ($user->role === 'checker')
                                <span class="badge rounded-pill bg-success-subtle text-success px-3 py-2">
                                    <i class="bi bi-check-circle me-1"></i>Checker
                                </span>
                            @else
                                <span class="badge rounded-pill bg-warning-subtle text-dark px-3 py-2">
                                    <i class="bi bi-pencil me-1"></i>Maker
                                </span>
                            @endif
                        </td>

                        <td>
                            <span class="small">
                                {{ $user->is_super_admin ? 'Privileged account' : 'Standard account' }}
                            </span>
                        </td>

                        <td class="text-nowrap small muted">
                            {{ $user->created_at?->format('d M Y') ?? '—' }}
                        </td>

                        <td class="px-4 text-end">
                            @if (!$user->is_super_admin && $user->id !== auth()->id())
                                <form method="POST"
                                      action="{{ route('admin.users.updateRole', $user) }}"
                                      class="d-inline-flex align-items-center justify-content-end gap-2">
                                    @csrf
                                    @method('PATCH')

                                    <select name="role"
                                            class="form-select form-select-sm"
                                            style="width: 110px;"
                                            aria-label="Role for {{ $user->name }}">
                                        <option value="maker" @selected($user->role === 'maker')>
                                            Maker
                                        </option>
                                        <option value="checker" @selected($user->role === 'checker')>
                                            Checker
                                        </option>
                                    </select>

                                    <button type="submit" class="btn btn-sm btn-outline-primary">
                                        Save
                                    </button>
                                </form>
                            @else
                                <span class="small muted">
                                    <i class="bi bi-lock-fill me-1"></i>Protected
                                </span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <i class="bi bi-people display-5 text-secondary"></i>
                            <h6 class="mt-3 fw-semibold">No users found</h6>
                            <p class="muted small mb-0">
                                Try changing your search or filter.
                            </p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="p-4 border-top d-flex flex-wrap justify-content-between align-items-center gap-3">
        <small class="muted">
            @if ($users->total() > 0)
                Showing {{ $users->firstItem() }}–{{ $users->lastItem() }}
                of {{ $users->total() }} users
            @else
                No records to display
            @endif
        </small>

        <div>
            {{ $users->links() }}
        </div>
    </div>
</div>

@endsection
