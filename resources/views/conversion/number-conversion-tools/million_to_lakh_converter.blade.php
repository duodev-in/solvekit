@php
    $units = config('units.numbers');
@endphp

<x-calc.page
    title="Million to Lakh Converter - SolveKit"
    description="Professional million to lakh converter for converting between international and Indian number systems with precision."
    lede="Convert millions to lakhs, or lakhs to millions."
    about="A million is 10⁶ and a lakh is 10⁵, so one million is exactly 10 lakh. Multiply millions by 10 for lakhs, or divide lakhs by 10 for millions."
    :calc="['engine' => 'number-scale', 'units' => config('units.numbers'), 'list' => ['one', 'thousand', 'crore', 'billion', 'trillion'], 'quickRef' => [0.5, 1, 2, 5, 10, 50], 'min' => 0]"
    :how-to="[
        ['name' => 'Choose a direction', 'text' => 'Millions to lakhs, or the reverse.'],
        ['name' => 'Enter the number', 'text' => 'The result, other number words and the full written number update as you type.'],
    ]"
    :faqs="[
        ['question' => 'How many lakhs are in a million?', 'answer' => 'Exactly 10 lakh.'],
        ['question' => 'What is 1 lakh in millions?', 'answer' => '0.1 million.'],
        ['question' => 'How many millions is 1 crore?', 'answer' => '10 million, which is 100 lakh.'],
    ]"
>
    <x-calc.segmented name="direction" legend="Direction" :options="['million:lakh' => 'Millions → Lakhs', 'lakh:million' => 'Lakhs → Millions']" selected="million:lakh" />

    <x-calc.field name="value" label="Number" value="3" min="0" suffix="million" suffix-ref="value-suffix" placeholder="Enter a number" />

    <x-calc.result label="Lakhs" />

    <x-calc.options :examples="[
        'Salary 2.4 million' => ['value' => 2.4, 'direction' => 'million:lakh'],
        'Car 18 lakh' => ['value' => 18, 'direction' => 'lakh:million'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Written out" :rows="[
            'western' => ['label' => 'Western grouping'],
            'indian' => ['label' => 'Indian grouping'],
            'scientific' => ['label' => 'Scientific notation'],
            'digits' => ['label' => 'Digits'],
        ]" />
        <x-calc.unit-list :grow="false" :units="$units" :keys="['one', 'thousand', 'crore', 'billion', 'trillion']" heading="3 million in other words" />
        <x-calc.quick-ref />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>lakhs = millions × 10</li>
            <li>millions = lakhs ÷ 10</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
