<x-calc.page
    title="ARV Calculator – After Repair Value - SolveKit"
    description="Free ARV calculator: the maximum purchase price by the 70% rule for house flipping, and the expected profit."
    lede="Work out the most to pay for a flip."
    about="The 70% rule says pay no more than 70% of the after-repair value (ARV) minus repair costs, leaving about 30% for holding costs, selling costs and profit. ARV comes from recent sales of renovated comparable homes. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-loans', 'tool' => 'arv', 'fields' => ['arv', 'repairs', 'purchase', 'costs', 'rule']]"
    :how-to="[
        ['name' => 'Enter ARV and repairs', 'text' => ''],
        ['name' => 'Add the purchase price', 'text' => 'For the profit.'],
    ]"
    :faqs="[
        ['question' => 'What is the most to pay for a home worth $300,000 after $45,000 of repairs?', 'answer' => '$165,000.'],
        ['question' => 'What profit at $160,000?', 'answer' => '$65,000.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="arv" label="After-repair value" value="300000" step="0.01" suffix="$" />
        <x-calc.field name="repairs" label="Repair costs" value="45000" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="purchase" label="Purchase price (optional)" value="160000" step="0.01" suffix="$" />
        <x-calc.field name="costs" label="Holding and selling costs (% of ARV)" value="10" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="rule" label="Rule (%)" value="70" step="any" suffix="%" />
    </div>

    <x-calc.result label="Maximum offer (70% rule)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['arv' => 300000, 'repairs' => 45000, 'purchase' => 160000, 'costs' => 10, 'rule' => 70],
        '75% rule' => ['arv' => 300000, 'repairs' => 45000, 'purchase' => 170000, 'costs' => 10, 'rule' => 75],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'profit' => ['label' => 'Expected profit'],
            'margin' => ['label' => 'Profit margin'],
            'all' => ['label' => 'All-in cost'],
            'rule' => ['label' => 'Rule'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>max offer = ARV × 70% − repairs</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
