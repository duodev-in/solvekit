@props([
    'units',
    'from',
    'to',
    'value' => null,
    'label' => 'Value',
    'min' => null,
    'groups' => null,
])

{{-- groups: [group label => [unit keys]] renders the menus with option groups. --}}
@php
    $optionLabel = fn ($unit) => $unit['symbol'] !== '' ? "{$unit['name']} ({$unit['symbol']})" : $unit['name'];
    $options = $groups
        ? collect($groups)->map(fn ($keys) => collect($keys)->mapWithKeys(fn ($key) => [$key => $optionLabel($units[$key])])->all())->all()
        : collect($units)->mapWithKeys(fn ($unit, $key) => [$key => $optionLabel($unit)])->all();
@endphp

<div class="grid grid-cols-[minmax(0,1fr)_2.75rem] items-end gap-3 sm:grid-cols-[minmax(0,1.2fr)_2.75rem_minmax(0,1fr)]">
    <div class="flex min-w-0 flex-col gap-1.5">
        <label for="calc-value" class="text-[13px] font-semibold text-slate-700">{{ $label }}</label>
        <div class="flex h-12 overflow-hidden rounded-lg border border-slate-300 bg-white focus-within:border-primary-600 focus-within:ring-2 focus-within:ring-primary-500/30">
            <input
                id="calc-value"
                name="value"
                type="number"
                inputmode="decimal"
                step="any"
                @if(! is_null($min)) min="{{ $min }}" @endif
                @if(! is_null($value)) value="{{ $value }}" @endif
                placeholder="Enter a value"
                autocomplete="off"
                class="h-full min-w-0 flex-1 bg-transparent px-3.5 font-mono text-lg font-semibold text-slate-900 outline-none placeholder:font-sans placeholder:text-sm placeholder:font-normal placeholder:text-slate-400"
            >
            <label for="calc-from" class="sr-only">From unit</label>
            <select id="calc-from" name="from" class="max-w-[48%] border-0 border-l border-slate-200 bg-slate-50 px-2.5 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @include('components.calc.partials.unit-options', ['options' => $options, 'selected' => $from])
            </select>
        </div>
    </div>

    <button type="button" data-calc-swap aria-label="Swap units" class="flex h-12 w-11 items-center justify-center rounded-lg border border-slate-300 bg-white text-slate-600 hover:border-primary-500 hover:text-primary-700 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-600 max-sm:order-last max-sm:w-full max-sm:col-span-2 max-sm:h-10">
        <svg class="size-[18px] sm:block" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 7h13l-4-4M17 17H4l4 4"/></svg>
    </button>

    <div class="col-span-2 flex min-w-0 flex-col gap-1.5 sm:col-span-1">
        <label for="calc-to" class="text-[13px] font-semibold text-slate-700">Convert to</label>
        <select id="calc-to" name="to" class="h-12 w-full min-w-0 rounded-lg border border-slate-300 bg-white px-3 text-[15px] text-slate-900 focus:border-primary-600 focus:outline-none focus:ring-2 focus:ring-primary-500/30">
            @include('components.calc.partials.unit-options', ['options' => $options, 'selected' => $to])
        </select>
    </div>
</div>
