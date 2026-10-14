@php
    $units = config('units.numbers');
@endphp

<x-calc.page
    title="Number to Billion Converter - SolveKit"
    description="Professional number to billion converter for large number conversions. Convert any number to billions with precision."
    lede="Express a number in billions, or turn billions back into a full number."
    about="A billion is 1,000,000,000 (10⁹) in the short scale used in the US and UK, so a number is divided by one billion to express it in billions."
    :calc="['engine' => 'number-scale', 'units' => config('units.numbers'), 'list' => ['thousand', 'lakh', 'million', 'crore', 'trillion'], 'quickRef' => [1000000, 10000000, 100000000, 1000000000, 10000000000, 100000000000], 'min' => 0]"
    :how-to="[
        ['name' => 'Choose a direction', 'text' => 'Number to billions, or the reverse.'],
        ['name' => 'Enter the number', 'text' => 'The result, other number words and the full written number update as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do I write 4,500,000,000 in billions?', 'answer' => '4.5 billion.'],
        ['question' => 'How many zeros are in a billion?', 'answer' => 'Nine.'],
        ['question' => 'How many millions is a billion?', 'answer' => '1,000 million.'],
    ]"
>
    <x-calc.segmented name="direction" legend="Direction" :options="['one:billion' => 'Number → Billions', 'billion:one' => 'Billions → Number']" selected="one:billion" />

    <x-calc.field name="value" label="Number" value="4500000000" min="0" suffix="" suffix-ref="value-suffix" placeholder="Enter a number" />

    <x-calc.result label="Billions" />

    <x-calc.options :examples="[
        'World population' => ['value' => 8100000000, 'direction' => 'one:billion'],
        '2.75 billion' => ['value' => 2.75, 'direction' => 'billion:one'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Written out" :rows="[
            'western' => ['label' => 'Western grouping'],
            'indian' => ['label' => 'Indian grouping'],
            'scientific' => ['label' => 'Scientific notation'],
            'digits' => ['label' => 'Digits'],
        ]" />
        <x-calc.unit-list :grow="false" :units="$units" :keys="['thousand', 'lakh', 'million', 'crore', 'trillion']" heading="4500000000  in other words" />
        <x-calc.quick-ref />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>billions = number ÷ 1,000,000,000</li>
            <li>number = billions × 1,000,000,000</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
