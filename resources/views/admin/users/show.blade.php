
@extends('layouts.admin')

@section('title', 'User Details')
@section('page-heading', 'User Details')

@section('content')
<div class="mx-auto max-w-3xl space-y-6">

    <a href="{{ route('admin.users.index') }}"
       class="text-sm font-medium text-indigo-600 hover:text-indigo-800">
        ← Back to User Management
    </a>

    <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="flex items-center gap-4 border-b border-slate-200 pb-6">
            <div class="flex h-16 w-16 items-center justify-center
                        rounded-full bg-indigo-100 text-2xl font-bold
                        text-indigo-700">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>

            <div>
                <h1 class="text-2xl font-bold text-slate-900">
                    {{ $user->name }}
                </h1>
                <p class="text-sm text-slate-500">{{ $user->email }}</p>
            </div>
        </div>

        <dl class="mt-6 grid grid-cols-1 gap-6 sm:grid-cols-2">
            <div>
                <dt class="text-sm text-slate-500">Role</dt>
                <dd class="mt-1 font-semibold text-slate-900">
                    {{ $user->is_super_admin
                        ? 'Super Admin'
                        : ucfirst($user->role ?? 'maker') }}
                </dd>
            </div>

            <div>
                <dt class="text-sm text-slate-500">Account Type</dt>
                <dd class="mt-1 font-semibold text-slate-900">
                    {{ $user->is_super_admin
                        ? 'Privileged Administrator'
                        : 'Standard User' }}
                </dd>
            </div>

            <div>
                <dt class="text-sm text-slate-500">Registered On</dt>
                <dd class="mt-1 font-semibold text-slate-900">
                    {{ $user->created_at?->format('d M Y, h:i A') }}
                </dd>
            </div>

            <div>
                <dt class="text-sm text-slate-500">Last Updated</dt>
                <dd class="mt-1 font-semibold text-slate-900">
                    {{ $user->updated_at?->format('d M Y, h:i A') }}
                </dd>
            </div>
        </dl>
    </div>
</div>
@endsection
