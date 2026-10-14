@php
    $units = config('units.numbers');
@endphp

<x-calc.page
    title="Crore to Lakh Converter - SolveKit"
    description="Professional crore to lakh converter for the Indian numbering system. Convert between crores and lakhs with precision."
    lede="Convert crores to lakhs, or lakhs to crores, in the Indian numbering system."
    about="In the Indian numbering system a lakh is 1,00,000 (10⁵) and a crore is 1,00,00,000 (10⁷), so one crore is 100 lakh. Multiply crores by 100 for lakhs, or divide lakhs by 100 for crores."
    :calc="['engine' => 'number-scale', 'units' => config('units.numbers'), 'list' => ['one', 'thousand', 'million', 'billion', 'trillion'], 'quickRef' => [0.5, 1, 2, 5, 10, 25], 'min' => 0]"
    :how-to="[
        ['name' => 'Choose a direction', 'text' => 'Crores to lakhs, or the reverse.'],
        ['name' => 'Enter the number', 'text' => 'The result, other number words and the full written number update as you type.'],
    ]"
    :faqs="[
        ['question' => 'How many lakhs are in a crore?', 'answer' => 'Exactly 100 lakh.'],
        ['question' => 'How is a crore written?', 'answer' => '1,00,00,000 in Indian grouping, or 10,000,000 (ten million) in Western grouping.'],
        ['question' => 'What is 50 lakh in crores?', 'answer' => '0.5 crore (half a crore).'],
    ]"
>
    <x-calc.segmented name="direction" legend="Direction" :options="['crore:lakh' => 'Crores → Lakhs', 'lakh:crore' => 'Lakhs → Crores']" selected="crore:lakh" />

    <x-calc.field name="value" label="Number" value="2.5" min="0" suffix="crore" suffix-ref="value-suffix" placeholder="Enter a number" />

    <x-calc.result label="Lakhs" />

    <x-calc.options :examples="[
        'Flat price 85 lakh' => ['value' => 85, 'direction' => 'lakh:crore'],
        'Turnover 12 crore' => ['value' => 12, 'direction' => 'crore:lakh'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Written out" :rows="[
            'western' => ['label' => 'Western grouping'],
            'indian' => ['label' => 'Indian grouping'],
            'scientific' => ['label' => 'Scientific notation'],
            'digits' => ['label' => 'Digits'],
        ]" />
        <x-calc.unit-list :grow="false" :units="$units" :keys="['one', 'thousand', 'million', 'billion', 'trillion']" heading="2.5 crore in other words" />
        <x-calc.quick-ref />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>lakhs = crores × 100</li>
            <li>crores = lakhs ÷ 100</li>
            <li>1 lakh = 10⁵ · 1 crore = 10⁷</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
