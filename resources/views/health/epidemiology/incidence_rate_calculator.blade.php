<x-calc.page
    title="Incidence Rate Calculator - SolveKit"
    description="Free incidence calculator: incidence proportion (risk) or incidence rate per person-time, per 100 to 100,000."
    lede="Calculate incidence."
    about="Cumulative incidence (risk) = new cases during a period ÷ people at risk at the start. The incidence rate = new cases ÷ total person-time at risk, as when people are followed for different lengths of time. Both are usually given per 1,000 or 100,000. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-misc', 'tool' => 'incidence', 'fields' => ['mode', 'cases', 'population', 'per', 'years']]"
    :how-to="[
        ['name' => 'Choose the measure', 'text' => ''],
        ['name' => 'Enter cases and population or person-time', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the incidence of 45 cases in 12,000 people at risk?', 'answer' => '3.75 per 1,000.'],
    ]"
>
    <x-calc.segmented name="mode" legend="Measure" :options="['proportion' => 'Cumulative incidence', 'rate' => 'Incidence rate']" selected="proportion" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="cases" label="New cases" value="45" min="0" step="1" />
        <x-calc.field name="population" label="Population at risk (or person-years)" value="12000" min="0" step="1" />
        <x-calc.select name="per" label="Per" :options="['100' => '100', '1000' => '1,000', '10000' => '10,000', '100000' => '100,000']" selected="1000" />
    </div>

    <x-calc.field name="years" label="Period in years (optional)" value="1" min="0" step="any" />

    <x-calc.result label="Incidence" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mode' => 'proportion', 'cases' => 45, 'population' => 12000, 'per' => '1000', 'years' => 1],
        'Rate' => ['mode' => 'rate', 'cases' => 30, 'population' => 25000, 'per' => '100000', 'years' => 1],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'percent' => ['label' => 'As a percentage'],
            'formula' => ['label' => 'Formula'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>incidence = cases ÷ population</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
