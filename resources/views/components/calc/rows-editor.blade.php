@props([
    'name',
    'label',
    'columns' => [],
    'rows' => [],
    'units' => [],
    'unit' => null,
    'unitLabel' => 'Unit',
    'addLabel' => 'Add row',
    'help' => null,
])

{{--
    Editable rows of numbers (rooms, walls, pieces). The values live in a hidden textarea,
    one row per line separated by spaces, so the formula runtime reads them like any field and
    example chips can set them. columns: [key => label]; rows: [[value, …], …];
    units: [unitKey => ['symbol' => …]] for an optional unit menu named {name}_unit.
--}}
<div class="flex min-w-0 flex-col gap-1.5" data-rows-editor="{{ $name }}">
    <div class="flex items-end justify-between gap-3">
        <span id="calc-{{ $name }}-label" class="text-[13px] font-semibold text-slate-700">{{ $label }}</span>
        @if($units)
            <label class="flex items-center gap-2 text-[13px] text-slate-600">
                <span>{{ $unitLabel }}</span>
                <select id="calc-{{ $name }}_unit" name="{{ $name }}_unit" class="h-9 rounded-lg border border-slate-300 bg-white px-2 text-sm font-medium text-slate-900 focus:border-primary-600 focus:outline-none focus:ring-2 focus:ring-primary-500/30">
                    @foreach($units as $key => $option)
                        <option value="{{ $key }}" @selected($key === $unit)>{{ $option['symbol'] }}</option>
                    @endforeach
                </select>
            </label>
        @endif
    </div>
    <div class="relative overflow-x-auto rounded-lg border border-slate-200">
        <table class="w-full border-collapse text-sm" aria-labelledby="calc-{{ $name }}-label">
            <thead class="bg-slate-50 text-left text-[12px] font-semibold text-slate-600">
                <tr>
                    <th scope="col" class="w-8 px-2 py-2 text-center">#</th>
                    @foreach($columns as $key => $columnLabel)
                        <th scope="col" class="px-2 py-2">{{ $columnLabel }}</th>
                    @endforeach
                    <th scope="col" class="w-10 px-1 py-2"><span class="sr-only">Remove</span></th>
                </tr>
            </thead>
            <tbody data-rows-body></tbody>
        </table>
    </div>
    <template data-rows-template>
        <tr class="border-t border-slate-200">
            <th scope="row" class="px-2 py-1.5 text-center font-mono text-[12px] font-medium text-slate-500" data-row-number></th>
            @foreach($columns as $key => $columnLabel)
                <td class="px-1 py-1">
                    <input type="number" inputmode="decimal" step="any" min="0" data-column="{{ $columnLabel }}" class="h-10 w-full min-w-[4.5rem] rounded-md border border-slate-300 bg-white px-2 font-mono text-[15px] font-semibold text-slate-900 focus:border-primary-600 focus:outline-none focus:ring-2 focus:ring-primary-500/30">
                </td>
            @endforeach
            <td class="px-1 py-1 text-center">
                <button type="button" data-row-remove class="inline-flex h-9 w-9 items-center justify-center rounded-md text-slate-400 hover:bg-slate-100 hover:text-red-600 focus:outline-none focus-visible:ring-2 focus-visible:ring-primary-500">
                    <span aria-hidden="true">×</span>
                </button>
            </td>
        </tr>
    </template>
    <div class="flex items-center justify-between gap-3">
        <button type="button" data-row-add class="inline-flex h-9 items-center rounded-lg border border-slate-300 bg-white px-3 text-[13px] font-semibold text-slate-700 hover:border-primary-500 hover:text-primary-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-primary-500">+ {{ $addLabel }}</button>
        @if($help)
            <p class="text-xs text-slate-500">{{ $help }}</p>
        @endif
    </div>
    <textarea id="calc-{{ $name }}" name="{{ $name }}" hidden aria-hidden="true" tabindex="-1">{{ collect($rows)->map(fn ($row) => implode(' ', $row))->implode("\n") }}</textarea>
</div>
