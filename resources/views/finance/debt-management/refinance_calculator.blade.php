<x-calc.page
    title="Refinance Calculator - SolveKit"
    description="Free refinance calculator: compare your current loan with a new one by payment, total interest and break-even."
    lede="Compare your loan with a refinance."
    about="The new payment is the level payment on the new balance and term. Break-even = closing costs ÷ monthly saving. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-loans', 'tool' => 'refinance', 'fields' => ['balance', 'rate', 'remaining', 'new_rate', 'new_years', 'costs', 'roll_costs']]"
    :how-to="[
        ['name' => 'Enter the current loan', 'text' => ''],
        ['name' => 'Enter the new loan and costs', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What does refinancing $200,000 from 7% to 6% save?', 'answer' => '$124.96 a month; break-even 33 months (2.668 years).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="balance" label="Current balance" value="200000" step="0.01" suffix="$" />
        <x-calc.field name="rate" label="Current rate" value="7" step="any" suffix="%" />
        <x-calc.field name="remaining" label="Years left" value="25" min="0" step="any" suffix="years" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="new_rate" label="New rate" value="6" step="any" suffix="%" />
        <x-calc.field name="new_years" label="New term" value="25" min="0" step="any" suffix="years" />
        <x-calc.field name="costs" label="Closing costs" value="4000" step="0.01" suffix="$" />
    </div>

    <x-calc.checkbox name="roll_costs" label="Add closing costs to the loan" :checked="false" />

    <x-calc.result label="New monthly payment" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['balance' => 200000, 'rate' => 7, 'remaining' => 25, 'new_rate' => 6, 'new_years' => 25, 'costs' => 4000, 'roll_costs' => false],
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
