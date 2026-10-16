@props([
    'heading' => 'Punnett square',
    'name' => 'grid',
])

{{-- Filled by the tool script: a table of gametes (headers) and offspring genotypes (cells). --}}
<x-calc.section :heading="$heading" :heading-ref="$name.'-heading'">
    <div class="overflow-x-auto p-4">
        <table data-ref="{{ $name }}" data-calc-grid class="mx-auto border-collapse text-center font-mono text-[13px]"></table>
    </div>
</x-calc.section>
