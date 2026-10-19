<x-calc.page
    title="Real GDP Calculator - SolveKit"
    description="Free Real GDP Calculator: real GDP = nominal GDP ÷ deflator × 100. Real GDP removes price changes to measure output."
    lede="Work out the real GDP from nominal GDP and GDP deflator (base = 100)."
    about="Real GDP removes price changes to measure output. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'real_gdp', 'fields' => ['nominal', 'deflator']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Nominal GDP, GDP deflator (base = 100).'],
        ['name' => 'Read the result', 'text' => 'The real GDP appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the real GDP?', 'answer' => 'Real GDP = nominal GDP ÷ deflator × 100.'],
        ['question' => 'What is the real GDP for nominal GDP $25,000, GDP deflator 120?', 'answer' => '$20,833.33.'],
        ['question' => 'And for nominal GDP $1,800, GDP deflator 95?', 'answer' => '$1,894.74.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Compare years with real, not nominal, GDP.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="nominal" label="Nominal GDP" value="25000" step="0.01" suffix="$" />
        <x-calc.field name="deflator" label="GDP deflator (base = 100)" value="120" step="any" />
    </div>

    <x-calc.result label="Real GDP" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['nominal' => 25000, 'deflator' => 120],
        'Example B' => ['nominal' => 1800, 'deflator' => 95],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>real GDP = nominal GDP ÷ deflator × 100</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
