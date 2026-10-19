<x-calc.page
    title="Income Elasticity of Demand Calculator - SolveKit"
    description="Free Income Elasticity of Demand Calculator: E = %ΔQ ÷ %ΔIncome (midpoint). Above 1 are luxuries, between 0 and 1 necessities, negative inferior goods."
    lede="Work out the income elasticity from your figures."
    about="Above 1 are luxuries, between 0 and 1 necessities, negative inferior goods. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'income_elasticity_of_demand', 'fields' => ['q1', 'q2', 'i1', 'i2']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Quantity before, Quantity after, Income before, Income after.'],
        ['name' => 'Read the result', 'text' => 'The income elasticity appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the income elasticity?', 'answer' => 'E = %ΔQ ÷ %ΔIncome (midpoint).'],
        ['question' => 'What is the income elasticity for quantity before 100, quantity after 108, income before $50,000, income after $55,000?', 'answer' => '0.8077.'],
        ['question' => 'And for quantity before 40, quantity after 36, income before $30,000, income after $36,000?', 'answer' => '−0.5789.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Use real income.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="q1" label="Quantity before" value="100" step="any" />
        <x-calc.field name="q2" label="Quantity after" value="108" step="any" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="i1" label="Income before" value="50000" step="0.01" suffix="$" />
        <x-calc.field name="i2" label="Income after" value="55000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Income elasticity" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['q1' => 100, 'q2' => 108, 'i1' => 50000, 'i2' => 55000],
        'Example B' => ['q1' => 40, 'q2' => 36, 'i1' => 30000, 'i2' => 36000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>E = %ΔQ ÷ %ΔIncome (midpoint)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
