<x-calc.page
    title="Opportunity Cost Calculator - SolveKit"
    description="Free opportunity cost calculator: what you give up by choosing one use of money over another, compounded over the years."
    lede="Compare a choice with the best alternative."
    about="Opportunity cost = value of the best alternative − value of the chosen option. For money: A(1 + r_alt)^t − A(1 + r_chosen)^t. Spending $30,000 on a car instead of investing it at 7% for 20 years gives up about $116,000. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-invest', 'tool' => 'opportunity_cost', 'fields' => ['amount', 'chosen', 'alternative', 'years']]"
    :how-to="[
        ['name' => 'Enter the amount', 'text' => ''],
        ['name' => 'Enter both returns', 'text' => 'Spending is 0%.'],
    ]"
    :faqs="[
        ['question' => 'What is the opportunity cost of spending $30,000 instead of investing at 7% for 20 years?', 'answer' => '$86,090.53.'],
        ['question' => 'And of cash at 4% against stocks at 7% for 10 years on $10,000?', 'answer' => '$4,869.07.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="amount" label="Amount" value="30000" step="0.01" suffix="$" />
        <x-calc.field name="chosen" label="Return of your choice" value="0" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="alternative" label="Return of the alternative" value="7" step="any" suffix="%" />
        <x-calc.field name="years" label="Years" value="20" min="0" step="any" suffix="years" />
    </div>

    <x-calc.result label="Opportunity cost" />

    <x-calc.options :decimals="false" :examples="[
        'Spend vs invest' => ['amount' => 30000, 'chosen' => 0, 'alternative' => 7, 'years' => 20],
        'Cash vs stocks' => ['amount' => 10000, 'chosen' => 4, 'alternative' => 7, 'years' => 10],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'chosen' => ['label' => 'Your choice becomes'],
            'alternative' => ['label' => 'Alternative becomes'],
            'percent' => ['label' => 'Gap as a share'],
            'yearly' => ['label' => 'Per year'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>cost = A(1 + r_alt)^t − A(1 + r)^t</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
