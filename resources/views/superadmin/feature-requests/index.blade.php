@extends('superadmin.layout.app')

@section('title', 'Feature requests | SolveKit')

@section('content')
    <div>
        <p class="text-sm font-medium text-zinc-500">Administration</p>
        <h1 class="mt-1 text-3xl font-semibold">Feature requests</h1>
    </div>

    <div class="mt-8 space-y-4">
        @forelse($featureRequests as $featureRequest)
            <div class="rounded-2xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <div>
                        <p class="text-sm text-zinc-500">{{ $featureRequest->category }} • {{ $featureRequest->name }}</p>
                        <h2 class="mt-1 text-xl font-semibold">{{ $featureRequest->title }}</h2>
                    </div>
                    <span class="rounded-full bg-zinc-100 px-3 py-1 text-xs font-medium uppercase tracking-wide text-zinc-700 dark:bg-zinc-800 dark:text-zinc-200">
                        {{ str_replace('_', ' ', $featureRequest->status) }}
                    </span>
                </div>

                <p class="mt-4 text-sm text-zinc-600 dark:text-zinc-300">{{ $featureRequest->description }}</p>
                <p class="mt-3 text-xs text-zinc-500">Submitted by {{ $featureRequest->email }} • {{ $featureRequest->created_at->format('M d, Y') }}</p>

                <form method="POST" action="{{ route('admin.feature-requests.update', $featureRequest) }}" class="mt-5 grid gap-4 rounded-xl border border-zinc-200 bg-zinc-50 p-4 md:grid-cols-[180px_1fr_auto] dark:border-zinc-700 dark:bg-zinc-950/60">
                    @csrf
                    @method('PUT')

                    <label class="block">
                        <span class="mb-2 block text-xs font-medium uppercase tracking-wide text-zinc-500">Status</span>
                        <select name="status" class="w-full rounded-lg border border-zinc-300 bg-white px-3 py-2 text-sm text-zinc-700 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-200">
                            @foreach(['submitted', 'reviewing', 'planned', 'in_progress', 'completed', 'rejected'] as $status)
                                <option value="{{ $status }}" @selected(old('status', $featureRequest->status) === $status)>{{ str_replace('_', ' ', ucfirst($status)) }}</option>
                            @endforeach
                        </select>
                    </label>

                    <label class="block">
                        <span class="mb-2 block text-xs font-medium uppercase tracking-wide text-zinc-500">Admin notes</span>
                        <textarea name="admin_notes" rows="2" placeholder="Optional internal note" class="w-full rounded-lg border border-zinc-300 bg-white px-3 py-2 text-sm text-zinc-700 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-200">{{ old('admin_notes', $featureRequest->admin_notes) }}</textarea>
                    </label>

                    <div class="flex items-end">
                        <flux:button type="submit" variant="primary">Update</flux:button>
                    </div>
                </form>
            </div>
        @empty
            <div class="rounded-2xl border border-dashed border-zinc-300 bg-white p-8 text-center text-zinc-500 dark:border-zinc-700 dark:bg-zinc-900">
                No feature requests have been submitted yet.
            </div>
        @endforelse
    </div>
@endsection
