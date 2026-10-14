@props([
    'heading' => 'Quick reference',
    'name' => 'quick-ref',
    'columns' => 1,
])

<x-calc.section :heading="$heading" :heading-ref="$name.'-heading'">
    <ol data-ref="{{ $name }}" @class(['min-h-0', 'calc-list-columns-2' => $columns === 2])></ol>
</x-calc.section>
