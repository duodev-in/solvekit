<x-calc.page
    title="Appreciation Calculator - SolveKit"
    description="Free Appreciation Calculator: FV = value × (1 + rate)^years. Compound appreciation grows the value by a fixed percentage each year."
    lede="Work out the future value from current value, appreciation a year and years."
    about="Compound appreciation grows the value by a fixed percentage each year. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'appreciation', 'fields' => ['value', 'rate', 'years']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Current value, Appreciation a year, Years.'],
        ['name' => 'Read the result', 'text' => 'The future value appears as you type, with gain below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the future value?', 'answer' => 'FV = value × (1 + rate)^years.'],
        ['question' => 'What is the future value for current value $300,000, appreciation a year 4%, years 10?', 'answer' => '$444,073.29. Gain: $144,073.29.'],
        ['question' => 'And for current value $25,000, appreciation a year 7%, years 15?', 'answer' => '$68,975.79. Gain: $43,975.79.'],
        ['question' => 'What does the result tell me?', 'answer' => 'At 4% a year, value doubles in about 18 years.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="value" label="Current value" value="300000" step="0.01" suffix="$" />
        <x-calc.field name="rate" label="Appreciation a year" value="4" step="any" suffix="%" />
        <x-calc.field name="years" label="Years" value="10" min="0" step="any" suffix="years" />
    </div>

    <x-calc.result label="Future value" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['value' => 300000, 'rate' => 4, 'years' => 10],
        'Example B' => ['value' => 25000, 'rate' => 7, 'years' => 15],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Gain'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>FV = value × (1 + rate)^years</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
