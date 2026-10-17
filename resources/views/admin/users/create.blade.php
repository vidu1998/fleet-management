
@extends('layouts.admin')

@section('title', 'Create Checker')
@section('header', 'Create User Account')

@section('content')

<div class="mb-4">
    <div class="d-flex align-items-center gap-2 mb-2">
        <a href="{{ route('admin.users.index') }}"
           class="btn btn-sm btn-light border"
           aria-label="Back to user management">
            <i class="bi bi-arrow-left"></i>
        </a>
        <span class="small muted">User Management / Create Checker</span>
    </div>

    <h1 class="page-heading">Create Checker Account</h1>
    <p class="muted mb-0">
        Register a new user and assign Checker permissions.
    </p>
</div>

<div class="row g-4">

    {{-- Main form --}}
    <div class="col-12 col-xl-8">
        <div class="content-card p-0 overflow-hidden">

            <div class="p-4 border-bottom">
                <div class="d-flex align-items-center gap-3">
                    <div class="stat-icon bg-primary-subtle text-primary">
                        <i class="bi bi-person-plus-fill"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-1">Account Information</h5>
                        <p class="muted small mb-0">
                            Enter the details required to create the account.
                        </p>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.users.store') }}">
                @csrf

                <div class="p-4 p-md-5">

                    {{-- Name --}}
                    <div class="mb-4">
                        <label for="name" class="form-label fw-semibold">
                            Full Name <span class="text-danger">*</span>
                        </label>

                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <i class="bi bi-person text-secondary"></i>
                            </span>
                            <input
                                type="text"
                                id="name"
                                name="name"
                                value="{{ old('name') }}"
                                class="form-control @error('name') is-invalid @enderror"
                                placeholder="Enter user's full name"
                                maxlength="255"
                                autocomplete="name"
                                required
                                autofocus>
                        </div>

                        @error('name')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div class="mb-4">
                        <label for="email" class="form-label fw-semibold">
                            Email Address <span class="text-danger">*</span>
                        </label>

                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <i class="bi bi-envelope text-secondary"></i>
                            </span>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                class="form-control @error('email') is-invalid @enderror"
                                placeholder="name@company.com"
                                maxlength="255"
                                autocomplete="email"
                                required>
                        </div>

                        @error('email')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror

                        <div class="form-text">
                            Use a unique email address for this account.
                        </div>
                    </div>

                    <hr class="my-4">

                    <h6 class="fw-bold mb-3">
                        <i class="bi bi-shield-lock me-2 text-primary"></i>
                        Account Security
                    </h6>

                    {{-- Password --}}
                    <div class="mb-4">
                        <label for="password" class="form-label fw-semibold">
                            Password <span class="text-danger">*</span>
                        </label>

                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <i class="bi bi-key text-secondary"></i>
                            </span>
                            <input
                                type="password"
                                id="password"
                                name="password"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="Create a strong password"
                                minlength="12"
                                autocomplete="new-password"
                                required>
                            <button
                                class="btn btn-outline-secondary"
                                type="button"
                                onclick="togglePassword('password', this)"
                                aria-label="Show or hide password">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>

                        @error('password')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror

                        <div class="form-text">
                            Use at least 12 characters.
                        </div>
                    </div>

                    {{-- Confirm password --}}
                    <div class="mb-2">
                        <label for="password_confirmation" class="form-label fw-semibold">
                            Confirm Password <span class="text-danger">*</span>
                        </label>

                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <i class="bi bi-check2-circle text-secondary"></i>
                            </span>
                            <input
                                type="password"
                                id="password_confirmation"
                                name="password_confirmation"
                                class="form-control"
                                placeholder="Re-enter the password"
                                minlength="12"
                                autocomplete="new-password"
                                required>
                            <button
                                class="btn btn-outline-secondary"
                                type="button"
                                onclick="togglePassword('password_confirmation', this)"
                                aria-label="Show or hide password confirmation">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>

                </div>

                {{-- Form actions --}}
                <div class="border-top p-4 d-flex flex-wrap justify-content-end gap-2"
                     style="background: #fafbfd;">
                    <a href="{{ route('admin.users.index') }}"
                       class="btn btn-outline-secondary px-4">
                        Cancel
                    </a>

                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-person-check-fill me-2"></i>
                        Create Checker
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Information panel --}}
    <div class="col-12 col-xl-4">
        <div class="content-card mb-4">
            <div class="d-flex align-items-center gap-3 mb-3">
                <div class="stat-icon bg-success-subtle text-success">
                    <i class="bi bi-shield-check"></i>
                </div>
                <div>
                    <h6 class="fw-bold mb-1">Checker Role</h6>
                    <span class="badge rounded-pill bg-success-subtle text-success">
                        Approval role
                    </span>
                </div>
            </div>

            <p class="muted small">
                The new account will be assigned the Checker role automatically.
            </p>

            <div class="d-flex gap-2 mb-3">
                <i class="bi bi-check-circle-fill text-success mt-1"></i>
                <div class="small">
                    <strong>Review submissions</strong>
                    <div class="muted">Designed for reviewing Maker-submitted changes.</div>
                </div>
            </div>

            <div class="d-flex gap-2">
                <i class="bi bi-lock-fill text-primary mt-1"></i>
                <div class="small">
                    <strong>Restricted privileges</strong>
                    <div class="muted">This form does not grant Super Admin privileges.</div>
                </div>
            </div>
        </div>

        <div class="content-card">
            <h6 class="fw-bold mb-3">
                <i class="bi bi-info-circle text-primary me-2"></i>
                Before Creating
            </h6>

            <ul class="small muted ps-3 mb-0">
                <li class="mb-2">Verify the user's name and email address.</li>
                <li class="mb-2">Use a unique email address.</li>
                <li class="mb-2">Set a strong password and communicate it securely.</li>
                <li>The account will be saved when you submit this form.</li>
            </ul>
        </div>
    </div>

</div>

<script>
    function togglePassword(inputId, button) {
        const input = document.getElementById(inputId);
        const icon = button.querySelector('i');

        const showPassword = input.type === 'password';
        input.type = showPassword ? 'text' : 'password';

        icon.classList.toggle('bi-eye', !showPassword);
        icon.classList.toggle('bi-eye-slash', showPassword);
    }
</script>

@endsection
