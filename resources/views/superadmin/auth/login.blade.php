@extends('superadmin.layout.auth')

@section('title', 'Admin login | SolveKit')

@section('content')
    <div class="mb-8 text-center">
        <p class="text-sm font-semibold uppercase tracking-[0.2em] text-zinc-500">SolveKit</p>
        <h1 class="mt-3 text-3xl font-semibold tracking-tight">Administration sign in</h1>
        <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">For superadmins and developers only.</p>
    </div>

    <form method="POST" action="{{ route('admin.login.store') }}" class="space-y-5 rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
        @csrf
        <flux:input name="email" type="email" label="Email" value="{{ old('email') }}" placeholder="you@example.com" required autofocus />
        <flux:input name="password" type="password" label="Password" placeholder="Enter your password" required />
        @error('email') <flux:callout variant="danger">{{ $message }}</flux:callout> @enderror
        <flux:button type="submit" variant="primary" class="w-full">Sign in</flux:button>
    </form>
@endsection
