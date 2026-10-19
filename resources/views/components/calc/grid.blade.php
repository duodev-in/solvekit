@props([
    'heading' => 'Punnett square',
    'name' => 'grid',
    'scroll' => false,
])

{{-- Filled by the tool script: a table with column headers and a header cell per row (Punnett squares, schedules). Long tables can scroll. --}}
<x-calc.section :heading="$heading" :heading-ref="$name.'-heading'">
    <div @class(['overflow-x-auto p-4', 'max-h-96 overflow-y-auto' => $scroll])>
        <table data-ref="{{ $name }}" data-calc-grid class="mx-auto border-collapse text-center font-mono text-[13px]"></table>
    </div>
</x-calc.section>
