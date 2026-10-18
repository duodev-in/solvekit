@props([
    'name' => 'shape',
    'label' => 'Shape',
    'shapes' => ['rectangle', 'circle', 'triangle', 'trapezoid', 'l_shape', 'ring', 'oval'],
    'selected' => 'rectangle',
])

{{--
    Shape menu with a small labelled diagram of the chosen shape. The dimension fields for each
    shape sit next to it with data-show-when="{name}:{shape}"; resources/js/calc/construction/geometry.js
    reads them (length, width, diameter, base, height, side_a, side_b, cut_length, cut_width, outer, inner).
--}}
@php
    $names = [
        'rectangle' => 'Rectangle or square',
        'circle' => 'Circle',
        'triangle' => 'Triangle',
        'trapezoid' => 'Trapezoid',
        'l_shape' => 'L-shape',
        'ring' => 'Ring (annulus)',
        'oval' => 'Oval (ellipse)',
    ];
@endphp

<div class="grid grid-cols-[minmax(0,1fr)_7.5rem] items-end gap-3">
    <x-calc.select :name="$name" :label="$label" :options="collect($shapes)->mapWithKeys(fn ($shape) => [$shape => $names[$shape]])->all()" :selected="$selected" />
    <div class="flex h-[4.5rem] items-center justify-center rounded-lg border border-slate-200 bg-slate-50 text-slate-500" aria-hidden="true">
        @foreach($shapes as $shape)
            {{-- The wrapper carries data-show-when: the hidden property only exists on HTML elements. --}}
            <div class="h-full w-full" data-show-when="{{ $name }}:{{ $shape }}" @if($shape !== $selected) hidden @endif>
            <svg viewBox="0 0 120 70" class="h-full w-full" fill="none" stroke="currentColor" stroke-width="1.5" font-size="9" font-family="ui-sans-serif, system-ui">
                @switch($shape)
                    @case('rectangle')
                        <rect x="25" y="14" width="70" height="40" class="fill-white stroke-primary-600" />
                        <text x="60" y="66" text-anchor="middle" stroke="none" fill="currentColor">L</text>
                        <text x="102" y="38" stroke="none" fill="currentColor">W</text>
                        @break
                    @case('circle')
                        <circle cx="60" cy="34" r="26" class="fill-white stroke-primary-600" />
                        <line x1="34" y1="34" x2="86" y2="34" stroke-dasharray="3 2" />
                        <text x="60" y="30" text-anchor="middle" stroke="none" fill="currentColor">D</text>
                        @break
                    @case('triangle')
                        <polygon points="25,56 95,56 50,10" class="fill-white stroke-primary-600" />
                        <line x1="50" y1="10" x2="50" y2="56" stroke-dasharray="3 2" />
                        <text x="60" y="67" text-anchor="middle" stroke="none" fill="currentColor">b</text>
                        <text x="53" y="38" stroke="none" fill="currentColor">h</text>
                        @break
                    @case('trapezoid')
                        <polygon points="20,56 100,56 80,14 40,14" class="fill-white stroke-primary-600" />
                        <text x="60" y="10" text-anchor="middle" stroke="none" fill="currentColor">a</text>
                        <text x="60" y="67" text-anchor="middle" stroke="none" fill="currentColor">b</text>
                        <line x1="60" y1="14" x2="60" y2="56" stroke-dasharray="3 2" />
                        <text x="63" y="40" stroke="none" fill="currentColor">h</text>
                        @break
                    @case('l_shape')
                        <polygon points="25,10 95,10 95,56 25,56" stroke-dasharray="3 2" />
                        <polygon points="25,10 65,10 65,32 95,32 95,56 25,56" class="fill-white stroke-primary-600" />
                        <text x="60" y="67" text-anchor="middle" stroke="none" fill="currentColor">L</text>
                        <text x="102" y="36" stroke="none" fill="currentColor">W</text>
                        <text x="80" y="25" text-anchor="middle" stroke="none" fill="currentColor">cut</text>
                        @break
                    @case('ring')
                        <circle cx="60" cy="34" r="27" class="fill-white stroke-primary-600" />
                        <circle cx="60" cy="34" r="13" class="fill-slate-50 stroke-primary-600" />
                        <text x="92" y="16" stroke="none" fill="currentColor">D</text>
                        <text x="60" y="37" text-anchor="middle" stroke="none" fill="currentColor">d</text>
                        @break
                    @case('oval')
                        <ellipse cx="60" cy="34" rx="38" ry="22" class="fill-white stroke-primary-600" />
                        <line x1="22" y1="34" x2="98" y2="34" stroke-dasharray="3 2" />
                        <line x1="60" y1="12" x2="60" y2="56" stroke-dasharray="3 2" />
                        <text x="78" y="31" stroke="none" fill="currentColor">L</text>
                        <text x="63" y="22" stroke="none" fill="currentColor">W</text>
                        @break
                @endswitch
            </svg>
            </div>
        @endforeach
    </div>
</div>
