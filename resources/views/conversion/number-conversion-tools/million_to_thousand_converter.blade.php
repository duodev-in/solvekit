@php
    $units = config('units.numbers');
@endphp

<x-calc.page
    title="Million to Thousand Converter - SolveKit"
    description="Professional million to thousand converter for large number conversions. Convert between millions and thousands with precision."
    lede="Convert millions to thousands, or thousands to millions."
    about="A million is a thousand thousands (10⁶ = 10³ × 10³), so millions are multiplied by 1,000 for thousands and thousands are divided by 1,000 for millions."
    :calc="['engine' => 'number-scale', 'units' => config('units.numbers'), 'list' => ['one', 'lakh', 'crore', 'billion', 'trillion'], 'quickRef' => [0.5, 1, 2.5, 5, 10, 100], 'min' => 0]"
    :how-to="[
        ['name' => 'Choose a direction', 'text' => 'Millions to thousands, or the reverse.'],
        ['name' => 'Enter the number', 'text' => 'The result, other number words and the full written number update as you type.'],
    ]"
    :faqs="[
        ['question' => 'How many thousands are in a million?', 'answer' => 'Exactly 1,000.'],
        ['question' => 'What does 2.5M mean in thousands?', 'answer' => '2,500 thousand (2,500K).'],
        ['question' => 'What is 750K in millions?', 'answer' => '0.75 million.'],
    ]"
>
    <x-calc.segmented name="direction" legend="Direction" :options="['million:thousand' => 'Millions → Thousands', 'thousand:million' => 'Thousands → Millions']" selected="million:thousand" />

    <x-calc.field name="value" label="Number" value="2.5" min="0" suffix="million" suffix-ref="value-suffix" placeholder="Enter a number" />

    <x-calc.result label="Thousands" />

    <x-calc.options :examples="[
        'Followers 1.2 million' => ['value' => 1.2, 'direction' => 'million:thousand'],
        'Salary 850 thousand' => ['value' => 850, 'direction' => 'thousand:million'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Written out" :rows="[
            'western' => ['label' => 'Western grouping'],
            'indian' => ['label' => 'Indian grouping'],
            'scientific' => ['label' => 'Scientific notation'],
            'digits' => ['label' => 'Digits'],
        ]" />
        <x-calc.unit-list :grow="false" :units="$units" :keys="['one', 'lakh', 'crore', 'billion', 'trillion']" heading="2.5 million in other words" />
        <x-calc.quick-ref />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>thousands = millions × 1,000</li>
            <li>millions = thousands ÷ 1,000</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
