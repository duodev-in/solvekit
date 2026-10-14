@props([
    'units',
    'keys' => null,
    'heading' => 'In other units',
    'columns' => null,
    'grow' => true,
])

@php
    $keys ??= array_keys($units);
    $columns ??= count($keys) > 10 ? 2 : 1;
@endphp

<x-calc.section :heading="$heading" heading-ref="list-heading" hint="Click a row to copy" :grow="$grow">
    <div @class(['calc-list min-h-0', 'calc-list-columns-2' => $columns === 2]) data-collapsible>
        @foreach($keys as $key)
            <button type="button" class="calc-row" data-calc-row="{{ $key }}" data-row-unit="{{ $units[$key]['symbol'] }}">
                <span class="calc-row-label">{{ $units[$key]['name'] }} <span class="text-slate-400">({{ $units[$key]['symbol'] }})</span></span>
                <span class="calc-row-value" data-row-value>—</span>
            </button>
        @endforeach
    </div>
    @if(count($keys) > 4)
        <button type="button" data-calc-expand class="h-11 text-sm font-semibold text-primary-700">Show all {{ count($keys) }} units</button>
    @endif
</x-calc.section>
