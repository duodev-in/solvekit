<x-calc.page
    title="GDP Deflator Formula Calculator - SolveKit"
    description="Free GDP Deflator Formula Calculator: deflator = nominal GDP ÷ real GDP × 100. The GDP deflator measures the price level of all goods and services in GDP relative to a base year."
    lede="Work out the GDP deflator from nominal GDP and real GDP."
    about="The GDP deflator measures the price level of all goods and services in GDP relative to a base year. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'gdp_deflator_formula', 'fields' => ['nominal', 'real']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Nominal GDP, Real GDP.'],
        ['name' => 'Read the result', 'text' => 'The GDP deflator appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the GDP deflator?', 'answer' => 'Deflator = nominal GDP ÷ real GDP × 100.'],
        ['question' => 'What is the GDP deflator for nominal GDP $25,000, real GDP $21,000?', 'answer' => '119.05.'],
        ['question' => 'And for nominal GDP $8,000, real GDP $8,400?', 'answer' => '95.24.'],
        ['question' => 'What does the result tell me?', 'answer' => '100 in the base year; 119 means prices 19% higher.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="nominal" label="Nominal GDP" value="25000" step="0.01" suffix="$" />
        <x-calc.field name="real" label="Real GDP" value="21000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="GDP deflator" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['nominal' => 25000, 'real' => 21000],
        'Example B' => ['nominal' => 8000, 'real' => 8400],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>deflator = nominal GDP ÷ real GDP × 100</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
