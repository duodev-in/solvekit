<x-calc.page
    title="NOPAT Calculator - SolveKit"
    description="Free NOPAT Calculator: NOPAT = EBIT × (1 − tax rate). Net operating profit after tax is the profit operations would earn with no debt."
    lede="Work out the NOPAT from operating income (EBIT) and tax rate."
    about="Net operating profit after tax is the profit operations would earn with no debt. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'nopat', 'fields' => ['ebit', 'tax']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Operating income (EBIT), Tax rate.'],
        ['name' => 'Read the result', 'text' => 'The NOPAT appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the NOPAT?', 'answer' => 'NOPAT = EBIT × (1 − tax rate).'],
        ['question' => 'What is the NOPAT for operating income $500,000, tax rate 21%?', 'answer' => '$395,000.00.'],
        ['question' => 'And for operating income $1,800,000, tax rate 25%?', 'answer' => '$1,350,000.00.'],
        ['question' => 'What does the result tell me?', 'answer' => 'It is used for ROIC and economic value added.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="ebit" label="Operating income (EBIT)" value="500000" step="0.01" suffix="$" />
        <x-calc.field name="tax" label="Tax rate" value="21" step="any" suffix="%" />
    </div>

    <x-calc.result label="NOPAT" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['ebit' => 500000, 'tax' => 21],
        'Example B' => ['ebit' => 1800000, 'tax' => 25],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>NOPAT = EBIT × (1 − tax rate)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
