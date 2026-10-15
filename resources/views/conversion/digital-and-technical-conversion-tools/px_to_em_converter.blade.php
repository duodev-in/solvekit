@php
    $cssUnits = ['px' => 'Pixels (px)', 'em' => 'em', 'rem' => 'rem', 'percent' => 'Percent (%)', 'pt' => 'Points (pt)', 'pc' => 'Picas (pc)', 'in' => 'Inches (in)', 'cm' => 'Centimeters (cm)', 'mm' => 'Millimeters (mm)'];
    $selectClass = 'h-12 w-full min-w-0 rounded-lg border border-slate-300 bg-white px-3 text-[15px] text-slate-900 focus:border-primary-600 focus:outline-none focus:ring-2 focus:ring-primary-500/30';
@endphp

<x-calc.page
    title="Px to Em Converter - SolveKit"
    description="Professional px to em converter for CSS unit conversion. Convert pixels to em units for responsive web design and scalable typography with base font size calculations."
    lede="Convert CSS pixels to em and rem, or between any CSS length units."
    about="em and rem are multiples of a font size: rem uses the root font size and em uses the parent's. With the browser default of 16px, 1rem = 16px, so px ÷ 16 = rem. The calculator assumes the parent's font size equals the base you enter. Physical units use the CSS definition of 96px per inch."
    :calc="['engine' => 'css-units']"
    :how-to="[
        ['name' => 'Set the base font size', 'text' => 'Usually 16px, the browser default.'],
        ['name' => 'Enter a value and units', 'text' => 'Every CSS unit is listed beside the result.'],
    ]"
    :faqs="[
        ['question' => 'How many pixels is 1rem?', 'answer' => '16px with the default root font size. If you set html { font-size: 62.5% }, 1rem becomes 10px.'],
        ['question' => 'What is the difference between em and rem?', 'answer' => 'rem is relative to the root element\'s font size; em is relative to the parent element\'s, so nested em values compound.'],
        ['question' => 'Should I use px or rem for font sizes?', 'answer' => 'rem respects the reader\'s browser font-size setting, which helps accessibility.'],
    ]"
>
    <div class="grid grid-cols-[minmax(0,1fr)_2.75rem] items-end gap-3 sm:grid-cols-[minmax(0,1fr)_minmax(0,1fr)_2.75rem_minmax(0,1fr)]">
        <x-calc.field name="value" label="Value" value="24" placeholder="Enter a value" />
        <div class="flex min-w-0 flex-col gap-1.5 max-sm:order-first max-sm:col-span-2">
            <label for="calc-from" class="text-[13px] font-semibold text-slate-700">From</label>
            <select id="calc-from" name="from" class="{{ $selectClass }}">
                @foreach($cssUnits as $key => $label)
                    <option value="{{ $key }}" @selected($key === 'px')>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <button type="button" data-calc-swap aria-label="Swap units" class="flex h-12 w-11 items-center justify-center rounded-lg border border-slate-300 bg-white text-slate-600 hover:border-primary-500 hover:text-primary-700 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-600">
            <svg class="size-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 7h13l-4-4M17 17H4l4 4"/></svg>
        </button>
        <div class="col-span-2 flex min-w-0 flex-col gap-1.5 sm:col-span-1">
            <label for="calc-to" class="text-[13px] font-semibold text-slate-700">To</label>
            <select id="calc-to" name="to" class="{{ $selectClass }}">
                @foreach($cssUnits as $key => $label)
                    <option value="{{ $key }}" @selected($key === 'rem')>{{ $label }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <x-calc.field name="base" label="Base font size" value="16" min="0" suffix="px" placeholder="16" />

    <x-calc.result label="In rem" />

    <x-calc.options :examples="[
        'Base 16px' => ['base' => 16],
        'Base 10px (62.5%)' => ['base' => 10],
        'Base 18px' => ['base' => 18],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="In every CSS unit" :rows="[
            'px' => ['label' => 'Pixels', 'unit' => 'px'],
            'rem' => ['label' => 'rem', 'unit' => 'rem'],
            'em' => ['label' => 'em', 'unit' => 'em'],
            'percent' => ['label' => 'Percent of base', 'unit' => '%'],
            'pt' => ['label' => 'Points', 'unit' => 'pt'],
            'pc' => ['label' => 'Picas', 'unit' => 'pc'],
            'in' => ['label' => 'Inches', 'unit' => 'in'],
            'cm' => ['label' => 'Centimeters', 'unit' => 'cm'],
            'mm' => ['label' => 'Millimeters', 'unit' => 'mm'],
        ]" />
        <x-calc.quick-ref heading="px to rem" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>rem = px ÷ root font size</li>
            <li>em = px ÷ parent font size</li>
            <li>1in = 96px · 1pt = 1/72 in</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
