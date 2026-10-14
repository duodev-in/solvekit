@props([
    'heading',
    'rows' => [],
    'hint' => 'Click a row to copy',
    'grow' => false,
    'columns' => 1,
])

{{-- rows: [key => ['label' => …, 'unit' => …]] — values are filled by the tool script via setRow(key). --}}
<x-calc.section :heading="$heading" heading-ref="rows-heading" :hint="$hint" :grow="$grow">
    <div @class(['calc-list min-h-0', 'calc-list-columns-2' => $columns === 2]) data-collapsible>
        @foreach($rows as $key => $row)
            <button type="button" class="calc-row" data-calc-row="{{ $key }}" data-row-unit="{{ $row['unit'] ?? '' }}">
                <span class="calc-row-label">{{ $row['label'] }}</span>
                <span class="calc-row-value" data-row-value>—</span>
            </button>
        @endforeach
    </div>
    @if(count($rows) > 4)
        <button type="button" data-calc-expand class="h-11 text-sm font-semibold text-primary-700">Show all {{ count($rows) }}</button>
    @endif
</x-calc.section>
