<x-calc.page
    title="Home Value Calculator (US) - SolveKit"
    description="Free Home Value Calculator (US): value = price × (1 + appreciation)^years. Estimates today's value from the purchase price and an average appreciation rate."
    lede="Work out the estimated value from purchase price, average yearly appreciation and years owned."
    about="Estimates today's value from the purchase price and an average appreciation rate. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'home_value_calculator_us', 'fields' => ['price', 'rate', 'years']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Purchase price, Average yearly appreciation, Years owned.'],
        ['name' => 'Read the result', 'text' => 'The estimated value appears as you type, with gain below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the estimated value?', 'answer' => 'Value = price × (1 + appreciation)^years.'],
        ['question' => 'What is the estimated value for purchase price $300,000, average yearly appreciation 4.5%, years owned 8?', 'answer' => '$426,630.18. Gain: $126,630.18.'],
        ['question' => 'And for purchase price $210,000, average yearly appreciation 6%, years owned 12?', 'answer' => '$422,561.26. Gain: $212,561.26.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Use your area\'s rate from the FHFA House Price Index; an appraisal gives a real value.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="price" label="Purchase price" value="300000" step="0.01" suffix="$" />
        <x-calc.field name="rate" label="Average yearly appreciation" value="4.5" step="any" suffix="%" />
        <x-calc.field name="years" label="Years owned" value="8" min="0" step="any" suffix="years" />
    </div>

    <x-calc.result label="Estimated value" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['price' => 300000, 'rate' => 4.5, 'years' => 8],
        'Example B' => ['price' => 210000, 'rate' => 6, 'years' => 12],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Gain'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>value = price × (1 + appreciation)^years</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
