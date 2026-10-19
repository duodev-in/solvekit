<x-calc.page
    title="GDP per Capita Calculator - SolveKit"
    description="Free GDP per Capita Calculator: GDP per capita = GDP ÷ population. GDP per person is a common, rough measure of living standards."
    lede="Work out the GDP per capita from GDP and population."
    about="GDP per person is a common, rough measure of living standards. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'gdp_per_capita', 'fields' => ['gdp', 'population']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'GDP, Population.'],
        ['name' => 'Read the result', 'text' => 'The GDP per capita appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the GDP per capita?', 'answer' => 'GDP per capita = GDP ÷ population.'],
        ['question' => 'What is the GDP per capita for GDP $25,000,000,000,000, population 330,000,000?', 'answer' => '$75,757.58.'],
        ['question' => 'And for GDP $3,900,000,000,000, population 1,430,000,000?', 'answer' => '$2,727.27.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Use PPP figures to compare countries.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="gdp" label="GDP" value="25000000000000" step="0.01" suffix="$" />
        <x-calc.field name="population" label="Population" value="330000000" step="any" />
    </div>

    <x-calc.result label="GDP per capita" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['gdp' => 25000000000000, 'population' => 330000000],
        'Example B' => ['gdp' => 3900000000000, 'population' => 1430000000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>GDP per capita = GDP ÷ population</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
