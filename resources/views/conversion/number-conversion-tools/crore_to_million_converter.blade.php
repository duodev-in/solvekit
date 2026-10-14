@php
    $units = config('units.numbers');
@endphp

<x-calc.page
    title="Crore to Million Converter - SolveKit"
    description="Professional crore to million converter for converting between Indian and international number systems with precision."
    lede="Convert crores to millions, or millions to crores."
    about="A crore is 10⁷ (ten million) and a million is 10⁶, so one crore is exactly 10 million. Multiply crores by 10 for millions, or divide millions by 10 for crores."
    :calc="['engine' => 'number-scale', 'units' => config('units.numbers'), 'list' => ['one', 'thousand', 'lakh', 'billion', 'trillion'], 'quickRef' => [1, 5, 10, 50, 100, 1000], 'min' => 0]"
    :how-to="[
        ['name' => 'Choose a direction', 'text' => 'Crores to millions, or the reverse.'],
        ['name' => 'Enter the number', 'text' => 'The result, other number words and the full written number update as you type.'],
    ]"
    :faqs="[
        ['question' => 'How many millions are in a crore?', 'answer' => 'Exactly 10 million.'],
        ['question' => 'What is 1 billion in crores?', 'answer' => '100 crore.'],
        ['question' => 'How do I convert crore rupees to million?', 'answer' => 'Multiply by 10: ₹5 crore is ₹50 million.'],
    ]"
>
    <x-calc.segmented name="direction" legend="Direction" :options="['crore:million' => 'Crores → Millions', 'million:crore' => 'Millions → Crores']" selected="crore:million" />

    <x-calc.field name="value" label="Number" value="5" min="0" suffix="crore" suffix-ref="value-suffix" placeholder="Enter a number" />

    <x-calc.result label="Millions" />

    <x-calc.options :examples="[
        'Startup round 50 crore' => ['value' => 50, 'direction' => 'crore:million'],
        'Revenue 120 million' => ['value' => 120, 'direction' => 'million:crore'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Written out" :rows="[
            'western' => ['label' => 'Western grouping'],
            'indian' => ['label' => 'Indian grouping'],
            'scientific' => ['label' => 'Scientific notation'],
            'digits' => ['label' => 'Digits'],
        ]" />
        <x-calc.unit-list :grow="false" :units="$units" :keys="['one', 'thousand', 'lakh', 'billion', 'trillion']" heading="5 crore in other words" />
        <x-calc.quick-ref />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>millions = crores × 10</li>
            <li>crores = millions ÷ 10</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
