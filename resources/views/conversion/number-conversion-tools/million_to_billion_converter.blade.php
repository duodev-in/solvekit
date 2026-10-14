@php
    $units = config('units.numbers');
@endphp

<x-calc.page
    title="Million to Billion Converter - SolveKit"
    description="Professional million to billion converter with short and long scale support. Convert between millions and billions with precision."
    lede="Convert millions to billions, or billions to millions, in the short or long scale."
    about="In the short scale a billion is 1,000 million (10⁹). In the long scale a billion is a million million (10¹²); 1,000 million is called a milliard there."
    :calc="['engine' => 'number-scale', 'unitSets' => ['short' => config('units.numbers'), 'long' => config('units.numbers_long_scale')], 'unitSetControl' => 'scale', 'list' => ['one', 'thousand', 'lakh', 'crore', 'trillion'], 'quickRef' => [1, 10, 100, 500, 1000, 5000], 'min' => 0]"
    :how-to="[
        ['name' => 'Choose a direction', 'text' => 'Millions to billions, or the reverse.'],
        ['name' => 'Enter the number', 'text' => 'The result, other number words and the full written number update as you type.'],
    ]"
    :faqs="[
        ['question' => 'How many millions are in a billion?', 'answer' => '1,000 in the short scale used in the US and UK. In the long scale, 1,000,000.'],
        ['question' => 'What is a milliard?', 'answer' => 'The long-scale name for 1,000 million (10⁹), used in many European languages.'],
        ['question' => 'How many zeros does a billion have?', 'answer' => 'Nine in the short scale (1,000,000,000).'],
    ]"
>
    <x-calc.segmented name="direction" legend="Direction" :options="['million:billion' => 'Millions → Billions', 'billion:million' => 'Billions → Millions']" selected="million:billion" />

    <x-calc.segmented name="scale" legend="Number scale" :options="['short' => 'Short scale (US, UK)', 'long' => 'Long scale (traditional European)']" selected="short" />

    <x-calc.field name="value" label="Number" value="2500" min="0" suffix="million" suffix-ref="value-suffix" placeholder="Enter a number" />

    <x-calc.result label="Billions" />

    <x-calc.options :examples="[
        'Population 8,100 million' => ['value' => 8100, 'direction' => 'million:billion'],
        'Market cap 3 billion' => ['value' => 3, 'direction' => 'billion:million'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Written out" :rows="[
            'western' => ['label' => 'Western grouping'],
            'indian' => ['label' => 'Indian grouping'],
            'scientific' => ['label' => 'Scientific notation'],
            'digits' => ['label' => 'Digits'],
        ]" />
        <x-calc.unit-list :grow="false" :units="$units" :keys="['one', 'thousand', 'lakh', 'crore', 'trillion']" heading="2500 million in other words" />
        <x-calc.quick-ref />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>short scale: billions = millions ÷ 1,000</li>
            <li>long scale: billions = millions ÷ 1,000,000</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
