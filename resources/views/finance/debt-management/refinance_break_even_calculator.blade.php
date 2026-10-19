<x-calc.page
    title="Refinance Break-Even Calculator - SolveKit"
    description="Free refinance break-even calculator: months until the monthly saving repays the closing costs."
    lede="Find when a refinance breaks even."
    about="Break-even months = closing costs ÷ (current payment − new payment). If you expect to keep the loan longer than that, the refinance saves money. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-loans', 'tool' => 'refinance', 'fields' => ['balance', 'rate', 'remaining', 'new_rate', 'new_years', 'costs', 'roll_costs']]"
    :how-to="[
        ['name' => 'Enter the current loan', 'text' => ''],
        ['name' => 'Enter the new loan and costs', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How long to recover $5,000 of costs refinancing $250,000 from 7% to 6.25%?', 'answer' => '32 months (2.609 years).'],
        ['question' => 'And for a 0.25-point drop?', 'answer' => '64 months (5.325 years).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="balance" label="Current balance" value="250000" step="0.01" suffix="$" />
        <x-calc.field name="rate" label="Current rate" value="7" step="any" suffix="%" />
        <x-calc.field name="remaining" label="Years left" value="28" min="0" step="any" suffix="years" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="new_rate" label="New rate" value="6.25" step="any" suffix="%" />
        <x-calc.field name="new_years" label="New term" value="30" min="0" step="any" suffix="years" />
        <x-calc.field name="costs" label="Closing costs" value="5000" step="0.01" suffix="$" />
    </div>

    <x-calc.checkbox name="roll_costs" label="Add closing costs to the loan" :checked="false" />

    <x-calc.result label="New monthly payment" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['balance' => 250000, 'rate' => 7, 'remaining' => 28, 'new_rate' => 6.25, 'new_years' => 30, 'costs' => 5000, 'roll_costs' => false],
        'Small drop' => ['balance' => 250000, 'rate' => 6.5, 'remaining' => 28, 'new_rate' => 6.25, 'new_years' => 30, 'costs' => 5000, 'roll_costs' => false],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'saving' => ['label' => 'Monthly saving'],
            'breakeven' => ['label' => 'Break-even'],
            'interest' => ['label' => 'Interest'],
            'lifetime' => ['label' => 'Over both terms'],
            'loan' => ['label' => 'New loan amount'],
            'ltv' => ['label' => 'New loan-to-value'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>saving = PMT_old − PMT_new</li>
            <li>break-even = closing costs ÷ saving</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
