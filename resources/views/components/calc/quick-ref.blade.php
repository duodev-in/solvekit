@props([
    'heading' => 'Quick reference',
    'name' => 'quick-ref',
    'columns' => 1,
    'generated' => false,
    'collapse' => false,
])

{{-- generated: the list depends on the input and is emptied when the input is cleared.
     collapse: long generated lists show 8 rows and a "Show all" button. --}}
<x-calc.section :heading="$heading" :heading-ref="$name.'-heading'">
    <ol data-ref="{{ $name }}" @if($generated) data-calc-generated @endif @if($collapse) data-collapsible data-collapse-long @endif @class(['min-h-0', 'calc-list-columns-2' => $columns === 2])></ol>
    @if($collapse)
        <button type="button" data-calc-expand hidden class="h-11 w-full text-sm font-semibold text-primary-700">Show all</button>
    @endif
</x-calc.section>
