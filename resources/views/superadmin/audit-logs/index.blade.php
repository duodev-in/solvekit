@extends('superadmin.layout.app')

@section('title', 'Audit Logs | SolveKit')

@section('content')
    <div class="flex flex-wrap items-end justify-between gap-4 border-b border-zinc-200 pb-5 dark:border-zinc-800">
        <div>
            <p class="text-sm font-medium text-zinc-500">Administration</p>
            <h1 class="mt-1 text-3xl font-semibold">Audit logs</h1>
        </div>
        <span class="text-sm text-zinc-500">{{ $auditLogs->total() }} records</span>
    </div>

    <form method="GET" class="mt-6 flex max-w-md items-end gap-3">
        <div class="min-w-0 flex-1">
            <flux:select name="event" label="Event">
                <option value="">All events</option>
                @foreach($events as $event)
                    <option value="{{ $event }}" @selected(request('event') === $event)>{{ ucfirst($event) }}</option>
                @endforeach
            </flux:select>
        </div>
        <flux:button type="submit" variant="outline">Filter</flux:button>
    </form>

    <div class="mt-8 overflow-x-auto border-y border-zinc-200 dark:border-zinc-800">
        <table class="w-full min-w-[700px] text-left text-sm">
            <thead class="border-b border-zinc-200 text-xs uppercase tracking-wide text-zinc-500 dark:border-zinc-800">
                <tr>
                    <th class="px-3 py-3 font-medium">Event</th>
                    <th class="px-3 py-3 font-medium">Record</th>
                    <th class="px-3 py-3 font-medium">Performed by</th>
                    <th class="px-3 py-3 font-medium">IP address</th>
                    <th class="px-3 py-3 font-medium">When</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                @forelse($auditLogs as $log)
                    <tr>
                        <td class="px-3 py-4 font-medium"><a href="{{ route('admin.audit-logs.show', $log) }}" class="text-primary-600 hover:text-primary-700">{{ ucfirst($log->event) }}</a></td>
                        <td class="px-3 py-4 text-zinc-600 dark:text-zinc-300">{{ class_basename($log->auditable_type) }} #{{ $log->auditable_id }}</td>
                        <td class="px-3 py-4 text-zinc-600 dark:text-zinc-300">{{ $log->user?->name ?? 'System' }}</td>
                        <td class="px-3 py-4 text-zinc-500">{{ $log->ip_address ?? '—' }}</td>
                        <td class="px-3 py-4 text-zinc-500" title="{{ $log->created_at?->toDateTimeString() }}"><div class="flex items-center justify-between gap-3"><span>{{ $log->created_at?->diffForHumans() ?? '—' }}</span><flux:button href="{{ route('admin.audit-logs.show', $log) }}" variant="ghost" size="sm">View</flux:button></div></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-3 py-12 text-center text-zinc-500">No audit logs found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($auditLogs->hasPages())
        <div class="mt-5">{{ $auditLogs->links() }}</div>
    @endif
@endsection
