@props([
    'title',
    'description' => '',
    'categoryTitle' => null,
    'relatedTools' => [],
])

@php
    $normalizedTitle = strtolower($title);
    $calculationText = match (true) {
        str_contains($normalizedTitle, 'time zone') || str_contains($normalizedTitle, 'timezone') => 'The result is calculated from the selected date, time, and time-zone rules, including the applicable UTC offset and daylight-saving adjustment.',
        str_contains($normalizedTitle, 'calculator') => 'Enter the requested values and the tool applies the relevant formula to produce the result and supporting breakdown.',
        str_contains($normalizedTitle, 'to ') || str_contains($normalizedTitle, 'converter') || str_contains($normalizedTitle, 'conversion') => 'Enter a value, choose the relevant units, and the tool applies the standard relationship between those units to calculate the result.',
        default => 'Enter the available values and the tool calculates the result using the measurement relationship described for this tool.',
    };
@endphp

<div class="space-y-6 text-sm text-slate-600">
    <section>
        <p class="text-xs font-semibold uppercase tracking-[0.14em] text-slate-400">What this tool does</p>
        <h2 class="mt-2 text-lg font-semibold text-slate-900">{{ $title }}</h2>
        <p class="mt-2 leading-6">{{ $description !== '' ? $description : 'A focused calculator for accurate, repeatable results.' }}</p>
    </section>

    <section class="border-t border-slate-200 pt-5">
        <p class="text-xs font-semibold uppercase tracking-[0.14em] text-slate-400">How the calculation works</p>
        <p class="mt-2 leading-6">{{ $calculationText }}</p>
    </section>

    @if($categoryTitle)
        <p class="border-t border-slate-200 pt-4 text-xs text-slate-500">Part of {{ $categoryTitle }}.</p>
    @endif

    @if(count($relatedTools) > 0)
        <section class="border-t border-slate-200 pt-5">
            <p class="text-xs font-semibold uppercase tracking-[0.14em] text-slate-400">Related tools</p>
            <nav class="mt-3 divide-y divide-slate-200 border-y border-slate-200" aria-label="Related tools">
                @foreach($relatedTools as $relatedTool)
                    <a href="{{ route($relatedTool['route_name']) }}" class="flex items-center justify-between gap-3 py-3 text-slate-700 transition hover:text-primary-600">
                        <span>{{ $relatedTool['title'] }}</span>
                        <span aria-hidden="true">&rarr;</span>
                    </a>
                @endforeach
            </nav>
        </section>
    @endif
</div>
