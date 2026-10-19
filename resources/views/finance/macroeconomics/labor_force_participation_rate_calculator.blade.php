<x-calc.page
    title="Labor Force Participation Rate Calculator - SolveKit"
    description="Free Labor Force Participation Rate Calculator: LFPR = labor force ÷ civilian non-institutional population 16+. The share of working-age people who are working or looking for work (BLS definition)."
    lede="Work out the participation rate from labor force (employed + unemployed) and working-age civilian population (16+)."
    about="The share of working-age people who are working or looking for work (BLS definition). Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'labor_force_participation_rate', 'fields' => ['labor', 'population']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Labor force (employed + unemployed), Working-age civilian population (16+).'],
        ['name' => 'Read the result', 'text' => 'The participation rate appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the participation rate?', 'answer' => 'LFPR = labor force ÷ civilian non-institutional population 16+.'],
        ['question' => 'What is the participation rate for labor force 168,000,000, working-age civilian population 268,000,000?', 'answer' => '62.69%.'],
        ['question' => 'And for labor force 3,100, working-age civilian population 5,000?', 'answer' => '62%.'],
        ['question' => 'What does the result tell me?', 'answer' => 'The US rate has been around 62–63% in recent years.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="labor" label="Labor force (employed + unemployed)" value="168000000" step="any" />
        <x-calc.field name="population" label="Working-age civilian population (16+)" value="268000000" step="any" />
    </div>

    <x-calc.result label="Participation rate" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['labor' => 168000000, 'population' => 268000000],
        'Example B' => ['labor' => 3100, 'population' => 5000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>LFPR = labor force ÷ civilian non-institutional population 16+</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
