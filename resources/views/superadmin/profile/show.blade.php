@extends('superadmin.layout.app')

@section('title', 'Profile | SolveKit')

@section('content')
    <div>
        <p class="text-sm font-medium text-zinc-500">Account</p>
        <h1 class="mt-1 text-3xl font-semibold">Profile settings</h1>
    </div>

    <div class="mt-8 grid gap-6 lg:grid-cols-2">
        <form method="POST" action="{{ route('admin.profile.update') }}" class="space-y-4 rounded-sm border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
            @csrf
            @method('PUT')

            <flux:heading size="lg">Basic details</flux:heading>
            <flux:input name="name" label="Name" value="{{ auth()->user()->name }}" placeholder="Full name" required />
            <flux:input type="email" name="email" label="Email" value="{{ auth()->user()->email }}" placeholder="you@example.com" required />

            <flux:button type="submit" variant="primary">Save changes</flux:button>
        </form>

        <form method="POST" action="{{ route('admin.profile.password.update') }}" class="space-y-4 rounded-sm border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
            @csrf
            @method('PUT')

            <flux:heading size="lg">Security</flux:heading>
            <flux:input type="password" name="current_password" label="Current password" placeholder="Current password" required />
            <flux:input type="password" name="password" label="New password" placeholder="Minimum 8 characters" autocomplete="new-password" required />
            <flux:input type="password" name="password_confirmation" label="Confirm password" placeholder="Repeat the password" autocomplete="new-password" required />

            <flux:button type="submit" variant="primary">Update password</flux:button>
        </form>
    </div>

    <form method="POST" action="{{ route('admin.profile.destroy') }}" class="mt-8 rounded-sm border border-red-200 bg-red-50 p-5 shadow-sm dark:border-red-900/60 dark:bg-red-950/30" onsubmit="return confirm('Delete this account? This action cannot be undone.');">
        @csrf
        @method('DELETE')

        <flux:heading size="lg" class="text-red-700 dark:text-red-300">Delete account</flux:heading>
        <p class="mt-2 text-sm text-red-700/80 dark:text-red-300/80">This action is permanent and removes all access tied to this account.</p>

        <div class="mt-4 max-w-md">
            <flux:input type="password" name="delete_password" label="Confirm current password" placeholder="Enter your password" required />
        </div>

        <div class="mt-4">
            <flux:button type="submit" variant="danger">Delete account</flux:button>
        </div>
    </form>
@endsection
