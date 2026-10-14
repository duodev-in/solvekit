@extends('superadmin.layout.auth')

@section('title', 'Verify email | SolveKit')

@section('content')
    <div class="rounded-2xl border border-zinc-200 bg-white p-6 text-center shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
        <h1 class="text-2xl font-semibold">Verify your email address</h1>
        <p class="mt-3 text-sm text-zinc-600 dark:text-zinc-400">Check your inbox for the verification link before entering the administration area.</p>
        @if(session('status')) <flux:callout variant="success" class="mt-5">{{ session('status') }}</flux:callout> @endif
        <form method="POST" action="{{ route('admin.verification.send') }}" class="mt-6">@csrf <flux:button type="submit" variant="primary">Send another link</flux:button></form>
        <form method="POST" action="{{ route('admin.logout') }}" class="mt-3">@csrf <flux:button type="submit" variant="ghost">Sign out</flux:button></form>
    </div>
@endsection
