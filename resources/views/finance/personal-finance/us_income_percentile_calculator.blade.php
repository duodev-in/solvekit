<x-calc.page
    title="US Income Percentile Calculator - SolveKit"
    description="Free US household income percentile calculator: where your household income ranks among US households, from Census CPS ASEC 2025 income data."
    lede="See where your household income ranks."
    about="Percentiles are interpolated between the Census quintile limits for 2025 household income: $35,800 (20th), $68,600 (40th), $110,300 (60th), $182,400 (80th) and $354,000 (95th); the 2025 median was $87,460. Household income includes everyone in the household and is before taxes. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-life', 'tool' => 'percentile', 'fields' => ['income'], 'data' => ['income' => config('finance_data.income')], 'sym' => 'USD', 'currency' => 'USD', 'currencyFixed' => true]"
    :how-to="[
        ['name' => 'Enter household income', 'text' => 'All earners, before tax.'],
        ['name' => 'Read your percentile', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'Where does $95,000 rank?', 'answer' => 'The 53th percentile.'],
        ['question' => 'And $400,000?', 'answer' => 'Top 5%.'],
    ]"
>
    <x-calc.field name="income" label="Household income before tax" value="95000" step="0.01" suffix="$" />

    <x-calc.result label="Household income percentile" />

    <x-calc.options :decimals="false" :examples="[
        '$95,000' => ['income' => 95000],
        '$400,000' => ['income' => 400000],
        '$40,000' => ['income' => 40000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'median' => ['label' => 'US median (2025)'],
            'ratio' => ['label' => 'Compared with the median'],
            'quintile' => ['label' => 'Quintile'],
            'source' => ['label' => 'Source'],
        ]" />
        <x-calc.quick-ref heading="2025 income limits" name="limits" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>interpolate between Census quintile limits</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
