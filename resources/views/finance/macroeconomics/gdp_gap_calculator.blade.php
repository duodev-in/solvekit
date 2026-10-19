<x-calc.page
    title="GDP Gap Calculator - SolveKit"
    description="Free GDP Gap Calculator: gap = (actual − potential) ÷ potential. The output gap shows whether the economy is producing above or below its sustainable capacity."
    lede="Work out the output gap from actual GDP and potential GDP."
    about="The output gap shows whether the economy is producing above or below its sustainable capacity. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'gdp_gap', 'fields' => ['actual', 'potential']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Actual GDP, Potential GDP.'],
        ['name' => 'Read the result', 'text' => 'The output gap appears as you type, with gap in output below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the output gap?', 'answer' => 'Gap = (actual − potential) ÷ potential.'],
        ['question' => 'What is the output gap for actual GDP $22,500, potential GDP $23,000?', 'answer' => '−2.174%. Gap in output: −$500.00.'],
        ['question' => 'And for actual GDP $1,820, potential GDP $1,750?', 'answer' => '4%. Gap in output: $70.00.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Negative gaps go with high unemployment.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="actual" label="Actual GDP" value="22500" step="0.01" suffix="$" />
        <x-calc.field name="potential" label="Potential GDP" value="23000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Output gap" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['actual' => 22500, 'potential' => 23000],
        'Example B' => ['actual' => 1820, 'potential' => 1750],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Gap in output'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>gap = (actual − potential) ÷ potential</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
