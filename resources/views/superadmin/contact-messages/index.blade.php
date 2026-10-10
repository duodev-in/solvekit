@extends('superadmin.layout.app')

@section('title', 'Contact messages | SolveKit')

@section('content')
    <div>
        <p class="text-sm font-medium text-zinc-500">Administration</p>
        <h1 class="mt-1 text-3xl font-semibold">Contact messages</h1>
    </div>

    <div class="mt-8 space-y-4">
        @forelse($messages as $message)
            <div class="rounded-2xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                <div class="flex flex-wrap items-start justify-between gap-3">
                    <div>
                        <p class="text-sm text-zinc-500">{{ $message->name }} • {{ $message->email }}</p>
                        <h2 class="mt-1 text-xl font-semibold">{{ $message->subject }}</h2>
                    </div>
                    <span class="rounded-full bg-zinc-100 px-3 py-1 text-xs font-medium uppercase tracking-wide text-zinc-700 dark:bg-zinc-800 dark:text-zinc-200">
                        {{ ucfirst($message->status) }}
                    </span>
                </div>

                <p class="mt-4 text-sm text-zinc-600 dark:text-zinc-300">{{ $message->message }}</p>

                @if($message->reply_body)
                    <div class="mt-4 rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800">
                        <p class="font-medium">Reply sent</p>
                        <p class="mt-2 whitespace-pre-line">{{ $message->reply_body }}</p>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.contact-messages.update', $message) }}" class="mt-5 grid gap-4 rounded-xl border border-zinc-200 bg-zinc-50 p-4 md:grid-cols-[180px_1fr_auto] dark:border-zinc-700 dark:bg-zinc-950/60">
                    @csrf
                    @method('PUT')

                    <label class="block">
                        <span class="mb-2 block text-xs font-medium uppercase tracking-wide text-zinc-500">Reply to</span>
                        <input type="email" name="reply_to" value="{{ old('reply_to', auth()->user()->email) }}" placeholder="reply@example.com" class="w-full rounded-lg border border-zinc-300 bg-white px-3 py-2 text-sm text-zinc-700 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-200" required>
                    </label>

                    <label class="block">
                        <span class="mb-2 block text-xs font-medium uppercase tracking-wide text-zinc-500">Reply message</span>
                        <textarea name="reply_body" rows="2" placeholder="Write your reply" class="w-full rounded-lg border border-zinc-300 bg-white px-3 py-2 text-sm text-zinc-700 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-200" required>{{ old('reply_body') }}</textarea>
                    </label>

                    <div class="flex items-end">
                        <flux:button type="submit" variant="primary">Send reply</flux:button>
                    </div>
                </form>
            </div>
        @empty
            <div class="rounded-2xl border border-dashed border-zinc-300 bg-white p-8 text-center text-zinc-500 dark:border-zinc-700 dark:bg-zinc-900">
                No contact messages have been received yet.
            </div>
        @endforelse
    </div>
@endsection
