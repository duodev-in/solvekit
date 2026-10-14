@php
    $units = config('units.numbers');
@endphp

<x-calc.page
    title="Number to Million Converter - SolveKit"
    description="Professional number to million converter for large number conversions. Convert any number to millions with precision."
    lede="Express a number in millions, or turn millions back into a full number."
    about="A million is 1,000,000 (10⁶), so a number is divided by one million to express it in millions."
    :calc="['engine' => 'number-scale', 'units' => config('units.numbers'), 'list' => ['thousand', 'lakh', 'crore', 'billion', 'trillion'], 'quickRef' => [10000, 100000, 1000000, 10000000, 100000000, 1000000000], 'min' => 0]"
    :how-to="[
        ['name' => 'Choose a direction', 'text' => 'Number to millions, or the reverse.'],
        ['name' => 'Enter the number', 'text' => 'The result, other number words and the full written number update as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do I write 2,500,000 in millions?', 'answer' => '2.5 million.'],
        ['question' => 'How many zeros are in a million?', 'answer' => 'Six.'],
        ['question' => 'How many lakhs is a million?', 'answer' => '10 lakh.'],
    ]"
>
    <x-calc.segmented name="direction" legend="Direction" :options="['one:million' => 'Number → Millions', 'million:one' => 'Millions → Number']" selected="one:million" />

    <x-calc.field name="value" label="Number" value="2500000" min="0" suffix="" suffix-ref="value-suffix" placeholder="Enter a number" />

    <x-calc.result label="Millions" />

    <x-calc.options :examples="[
        'City population' => ['value' => 8336817, 'direction' => 'one:million'],
        '1.25 million' => ['value' => 1.25, 'direction' => 'million:one'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Written out" :rows="[
            'western' => ['label' => 'Western grouping'],
            'indian' => ['label' => 'Indian grouping'],
            'scientific' => ['label' => 'Scientific notation'],
            'digits' => ['label' => 'Digits'],
        ]" />
        <x-calc.unit-list :grow="false" :units="$units" :keys="['thousand', 'lakh', 'crore', 'billion', 'trillion']" heading="2500000  in other words" />
        <x-calc.quick-ref />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>millions = number ÷ 1,000,000</li>
            <li>number = millions × 1,000,000</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
