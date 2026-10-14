@props([
    'heading' => 'Quick reference',
    'name' => 'quick-ref',
    'columns' => 1,
    'generated' => false,
])

{{-- generated: the list depends on the input and is emptied when the input is cleared. --}}
<x-calc.section :heading="$heading" :heading-ref="$name.'-heading'">
    <ol data-ref="{{ $name }}" @if($generated) data-calc-generated @endif @class(['min-h-0', 'calc-list-columns-2' => $columns === 2])></ol>
</x-calc.section>
