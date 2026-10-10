@extends('superadmin.layout.app')

@section('title', 'Audit Log | SolveKit')

@section('content')
    <div class="flex flex-wrap items-end justify-between gap-4 border-b border-zinc-200 pb-5 dark:border-zinc-800">
        <div>
            <p class="text-sm font-medium text-zinc-500">Administration / Audit logs</p>
            <h1 class="mt-1 text-3xl font-semibold">{{ ucfirst($auditLog->event) }} {{ class_basename($auditLog->auditable_type) }}</h1>
            <p class="mt-1 text-sm text-zinc-500">{{ $auditLog->created_at?->toDayDateTimeString() ?? 'Unknown time' }}</p>
        </div>
        <div class="flex gap-2">
            <flux:button href="{{ route('admin.audit-logs.index') }}" variant="outline">Back to logs</flux:button>
            @if($recordUrl)
                <flux:button href="{{ $recordUrl }}" variant="primary">View record</flux:button>
            @endif
        </div>
    </div>

    <div class="mt-8 grid gap-8 lg:grid-cols-[14rem_1fr]">
        <dl class="space-y-4 text-sm">
            <div>
                <dt class="text-zinc-500">Event</dt>
                <dd class="mt-1 font-medium">{{ ucfirst($auditLog->event) }}</dd>
            </div>
            <div>
                <dt class="text-zinc-500">Performed by</dt>
                <dd class="mt-1 font-medium">{{ $auditLog->user?->name ?? 'System' }}</dd>
            </div>
            <div>
                <dt class="text-zinc-500">IP address</dt>
                <dd class="mt-1 font-medium">{{ $auditLog->ip_address ?? '—' }}</dd>
            </div>
            <div>
                <dt class="text-zinc-500">User agent</dt>
                <dd class="mt-1 break-words font-medium">{{ $auditLog->user_agent ?? '—' }}</dd>
            </div>
        </dl>

        <section>
            <div class="border-b border-zinc-200 pb-3 dark:border-zinc-800">
                <h2 class="text-lg font-semibold">Changes</h2>
                <p class="mt-1 text-sm text-zinc-500">A comparison of the values before and after this event.</p>
            </div>

            <div class="mt-4 overflow-x-auto border-y border-zinc-200 dark:border-zinc-800">
                <table class="w-full min-w-[620px] text-left text-sm">
                    <thead class="border-b border-zinc-200 text-xs uppercase tracking-wide text-zinc-500 dark:border-zinc-800">
                        <tr>
                            <th class="px-3 py-3 font-medium">Field</th>
                            <th class="px-3 py-3 font-medium">Before</th>
                            <th class="px-3 py-3 font-medium">After</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                        @forelse($changes as $change)
                            <tr>
                                <td class="px-3 py-4 font-medium">{{ str_replace('_', ' ', ucfirst($change['field'])) }}</td>
                                <td class="max-w-xs whitespace-pre-wrap break-words px-3 py-4 text-zinc-500">{{ is_array($change['old']) ? json_encode($change['old'], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) : ($change['old'] ?? '—') }}</td>
                                <td class="max-w-xs whitespace-pre-wrap break-words px-3 py-4 text-zinc-800 dark:text-zinc-100">{{ is_array($change['new']) ? json_encode($change['new'], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) : ($change['new'] ?? '—') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-3 py-10 text-center text-zinc-500">No field changes were recorded.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
@endsection
