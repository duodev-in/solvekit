@extends('superadmin.layout.app')

@section('title', 'Dashboard | SolveKit')

@section('content')
    @php
        $kpis = [
            ['label' => 'Managed users', 'value' => $userCount, 'accent' => '#0984e2', 'href' => route('admin.users.index')],
            ['label' => 'Active users', 'value' => $activeUserCount, 'accent' => '#10b981', 'href' => route('admin.users.index')],
            ['label' => 'Open bug reports', 'value' => $openBugCount, 'accent' => '#f59e0b', 'href' => route('admin.bug-reports.index')],
            ['label' => 'Feature requests', 'value' => $featureRequestCount, 'accent' => '#8b5cf6', 'href' => route('admin.feature-requests.index')],
        ];

        $bugStatusCounts = [
            'open' => \App\Models\BugReport::where('status', 'open')->count(),
            'in_progress' => \App\Models\BugReport::where('status', 'in_progress')->count(),
            'resolved' => \App\Models\BugReport::where('status', 'resolved')->count(),
            'closed' => \App\Models\BugReport::where('status', 'closed')->count(),
        ];

        $featureStatusCounts = [
            'submitted' => \App\Models\FeatureRequest::where('status', 'submitted')->count(),
            'reviewing' => \App\Models\FeatureRequest::where('status', 'reviewing')->count(),
            'planned' => \App\Models\FeatureRequest::where('status', 'planned')->count(),
            'in_progress' => \App\Models\FeatureRequest::where('status', 'in_progress')->count(),
            'completed' => \App\Models\FeatureRequest::where('status', 'completed')->count(),
        ];

        $chartSegments = function ($counts, $colors) {
            $total = array_sum($counts);

            if ($total === 0) {
                return [
                    ['label' => 'No data', 'value' => 100, 'color' => '#e5e7eb'],
                ];
            }

            $segments = [];
            $offset = 0;
            $entries = array_values($counts);
            $labels = array_keys($counts);

            foreach ($entries as $index => $value) {
                $percentage = ($value / $total) * 100;
                $segments[] = [
                    'label' => $labels[$index],
                    'value' => $value,
                    'percentage' => $percentage,
                    'color' => $colors[$index],
                    'offset' => $offset,
                ];
                $offset += $percentage;
            }

            return $segments;
        };

        $bugSegments = $chartSegments($bugStatusCounts, ['#3b82f6', '#f59e0b', '#10b981', '#94a3b8']);
        $featureSegments = $chartSegments($featureStatusCounts, ['#a78bfa', '#f472b6', '#34d399', '#22d3ee', '#fbbf24']);
    @endphp

    <div class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <p class="text-sm font-medium text-zinc-500">Administration</p>
            <h1 class="mt-1 text-3xl font-semibold tracking-tight">Dashboard</h1>
        </div>
    </div>

    <div class="mt-8 grid gap-4 md:grid-cols-2 xl:grid-cols-4">
        @foreach($kpis as $kpi)
            <a href="{{ $kpi['href'] }}" style="border-left-color: {{ $kpi['accent'] }};" class="border border-l-4 border-zinc-200 bg-white p-5 shadow-sm transition hover:border-zinc-300 dark:border-zinc-800 dark:bg-zinc-900">
                <p class="text-sm text-zinc-500">{{ $kpi['label'] }}</p>
                <p class="mt-3 text-4xl font-semibold tracking-tight">{{ $kpi['value'] }}</p>
            </a>
        @endforeach
    </div>

    <div class="mt-8 grid gap-6 xl:grid-cols-[1.5fr_1fr]">
        <div class="space-y-6">
            <div class="border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                <div class="mb-4 flex items-center justify-between">
                    <h2 class="text-lg font-semibold">Recent audit activity</h2>
                    <span class="text-xs uppercase tracking-wide text-zinc-500">Live</span>
                </div>

                <div class="space-y-4">
                    @forelse($recentAuditLogs as $log)
                        <div class="flex items-start gap-3 border-b border-zinc-100 bg-zinc-50 p-3 dark:border-zinc-800 dark:bg-zinc-950/60">
                            <div class="mt-0.5 flex h-8 w-8 items-center justify-center rounded-full bg-zinc-200 text-xs font-semibold text-zinc-700 dark:bg-zinc-800 dark:text-zinc-200">
                                {{ strtoupper(substr($log->event ?? 'A', 0, 1)) }}
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-medium text-zinc-800 dark:text-zinc-100">
                                    {{ $log->user?->name ?? 'System' }} {{ $log->event }} {{ class_basename($log->auditable_type) }}
                                </p>
                                <p class="mt-1 text-xs text-zinc-500">
                                    {{ $log->created_at?->diffForHumans() ?? 'Recently' }}
                                </p>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-zinc-500">No activity has been recorded yet.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                <h2 class="text-lg font-semibold">Bug report distribution</h2>
                <div class="mt-4 flex items-center gap-5">
                    <div class="relative h-28 w-28 shrink-0 rounded-full" style="background: conic-gradient(#3b82f6 0 {{ $bugSegments[0]['percentage'] ?? 0 }}%, #f59e0b {{ $bugSegments[0]['percentage'] ?? 0 }}% {{ ($bugSegments[0]['percentage'] ?? 0) + ($bugSegments[1]['percentage'] ?? 0) }}%, #10b981 {{ ($bugSegments[0]['percentage'] ?? 0) + ($bugSegments[1]['percentage'] ?? 0) }}% {{ ($bugSegments[0]['percentage'] ?? 0) + ($bugSegments[1]['percentage'] ?? 0) + ($bugSegments[2]['percentage'] ?? 0) }}%, #94a3b8 {{ ($bugSegments[0]['percentage'] ?? 0) + ($bugSegments[1]['percentage'] ?? 0) + ($bugSegments[2]['percentage'] ?? 0) }}% 100%);">
                        <div class="absolute inset-3 rounded-full bg-white dark:bg-zinc-900"></div>
                        <div class="absolute inset-0 flex items-center justify-center text-lg font-semibold">{{ array_sum($bugStatusCounts) }}</div>
                    </div>
                    <div class="space-y-2 text-sm">
                        @foreach($bugSegments as $segment)
                            <div class="flex items-center gap-2">
                                <span class="h-2.5 w-2.5 rounded-full" style="background: {{ $segment['color'] }};"></span>
                                <span class="capitalize text-zinc-600 dark:text-zinc-300">{{ str_replace('_', ' ', $segment['label']) }}</span>
                                <span class="ml-auto font-medium text-zinc-800 dark:text-zinc-100">{{ $segment['value'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                <h2 class="text-lg font-semibold">Feature request distribution</h2>
                <div class="mt-4 flex items-center gap-5">
                    <div class="relative h-28 w-28 shrink-0 rounded-full" style="background: conic-gradient(#a78bfa 0 {{ $featureSegments[0]['percentage'] ?? 0 }}%, #f472b6 {{ $featureSegments[0]['percentage'] ?? 0 }}% {{ ($featureSegments[0]['percentage'] ?? 0) + ($featureSegments[1]['percentage'] ?? 0) }}%, #34d399 {{ ($featureSegments[0]['percentage'] ?? 0) + ($featureSegments[1]['percentage'] ?? 0) }}% {{ ($featureSegments[0]['percentage'] ?? 0) + ($featureSegments[1]['percentage'] ?? 0) + ($featureSegments[2]['percentage'] ?? 0) }}%, #22d3ee {{ ($featureSegments[0]['percentage'] ?? 0) + ($featureSegments[1]['percentage'] ?? 0) + ($featureSegments[2]['percentage'] ?? 0) }}% {{ ($featureSegments[0]['percentage'] ?? 0) + ($featureSegments[1]['percentage'] ?? 0) + ($featureSegments[2]['percentage'] ?? 0) + ($featureSegments[3]['percentage'] ?? 0) }}%, #fbbf24 {{ ($featureSegments[0]['percentage'] ?? 0) + ($featureSegments[1]['percentage'] ?? 0) + ($featureSegments[2]['percentage'] ?? 0) + ($featureSegments[3]['percentage'] ?? 0) }}% 100%);">
                        <div class="absolute inset-3 rounded-full bg-white dark:bg-zinc-900"></div>
                        <div class="absolute inset-0 flex items-center justify-center text-lg font-semibold">{{ array_sum($featureStatusCounts) }}</div>
                    </div>
                    <div class="space-y-2 text-sm">
                        @foreach($featureSegments as $segment)
                            <div class="flex items-center gap-2">
                                <span class="h-2.5 w-2.5 rounded-full" style="background: {{ $segment['color'] }};"></span>
                                <span class="capitalize text-zinc-600 dark:text-zinc-300">{{ str_replace('_', ' ', $segment['label']) }}</span>
                                <span class="ml-auto font-medium text-zinc-800 dark:text-zinc-100">{{ $segment['value'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
