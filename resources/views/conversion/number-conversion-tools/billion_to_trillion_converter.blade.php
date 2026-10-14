@php
    $units = config('units.numbers');
@endphp

<x-calc.page
    title="Billion to Trillion Converter - SolveKit"
    description="Professional billion to trillion converter with short and long scale support. Convert between billions and trillions with precision."
    lede="Convert billions to trillions, or trillions to billions, in the short or long scale."
    about="In the short scale used in the US and UK today, a trillion is 1,000 billion (10¹² vs 10⁹). In the traditional European long scale, a billion is 10¹² and a trillion is 10¹⁸, so a trillion is a million billion."
    :calc="['engine' => 'number-scale', 'unitSets' => ['short' => config('units.numbers'), 'long' => config('units.numbers_long_scale')], 'unitSetControl' => 'scale', 'list' => ['one', 'thousand', 'lakh', 'million', 'crore'], 'quickRef' => [1, 10, 100, 500, 1000, 5000], 'min' => 0]"
    :how-to="[
        ['name' => 'Choose a direction', 'text' => 'Billions to trillions, or the reverse.'],
        ['name' => 'Enter the number', 'text' => 'The result, other number words and the full written number update as you type.'],
    ]"
    :faqs="[
        ['question' => 'How many billions are in a trillion?', 'answer' => '1,000 in the short scale (US and modern UK). In the long scale it is 1,000,000.'],
        ['question' => 'How many zeros does a trillion have?', 'answer' => '12 in the short scale (1,000,000,000,000) and 18 in the long scale.'],
        ['question' => 'Which scale should I use?', 'answer' => 'The short scale, unless you are reading older British texts or translating from languages such as French, German or Spanish, which use the long scale.'],
    ]"
>
    <x-calc.segmented name="direction" legend="Direction" :options="['billion:trillion' => 'Billions → Trillions', 'trillion:billion' => 'Trillions → Billions']" selected="billion:trillion" />

    <x-calc.segmented name="scale" legend="Number scale" :options="['short' => 'Short scale (US, UK)', 'long' => 'Long scale (traditional European)']" selected="short" />

    <x-calc.field name="value" label="Number" value="2500" min="0" suffix="billion" suffix-ref="value-suffix" placeholder="Enter a number" />

    <x-calc.result label="Trillions" />

    <x-calc.options :examples="[
        'US GDP 27 trillion' => ['value' => 27, 'direction' => 'trillion:billion'],
        'Budget 750 billion' => ['value' => 750, 'direction' => 'billion:trillion'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Written out" :rows="[
            'western' => ['label' => 'Western grouping'],
            'indian' => ['label' => 'Indian grouping'],
            'scientific' => ['label' => 'Scientific notation'],
            'digits' => ['label' => 'Digits'],
        ]" />
        <x-calc.unit-list :grow="false" :units="$units" :keys="['one', 'thousand', 'lakh', 'million', 'crore']" heading="2500 billion in other words" />
        <x-calc.quick-ref />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>short scale: trillions = billions ÷ 1,000</li>
            <li>long scale: trillions = billions ÷ 1,000,000</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
