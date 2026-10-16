@props([
    'heading' => 'Chart',
    'name' => 'plot',
    'label' => null,
])

{{-- Drawn by the tool script (ctx.renderPlot): an SVG line chart with axes and optional markers. --}}
<x-calc.section :heading="$heading">
    <div class="px-3 py-3">
        <svg data-ref="{{ $name }}" data-calc-plot role="img" aria-label="{{ $label ?? $heading }}" class="block h-auto w-full" viewBox="0 0 400 220" preserveAspectRatio="xMidYMid meet"></svg>
    </div>
</x-calc.section>
