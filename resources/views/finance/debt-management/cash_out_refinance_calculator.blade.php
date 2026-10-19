<x-calc.page
    title="Cash-Out Refinance Calculator - SolveKit"
    description="Free cash-out refinance calculator: new loan, payment and loan-to-value when taking cash out of home equity."
    lede="Plan a cash-out refinance."
    about="A cash-out refinance replaces the mortgage with a larger one and pays you the difference. Most lenders cap the new loan at 80% of the home value (90% for VA). Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-loans', 'tool' => 'refinance', 'fields' => ['balance', 'rate', 'remaining', 'new_rate', 'new_years', 'costs', 'cash_out', 'value', 'roll_costs']]"
    :how-to="[
        ['name' => 'Enter the current loan', 'text' => ''],
        ['name' => 'Enter the new loan and costs', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the payment taking $50,000 out of a $400,000 home with $200,000 owed?', 'answer' => '$1,660.41; LTV 64%.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="balance" label="Current balance" value="200000" step="0.01" suffix="$" />
        <x-calc.field name="rate" label="Current rate" value="6.5" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="remaining" label="Years left" value="25" min="0" step="any" suffix="years" />
        <x-calc.field name="new_rate" label="New rate" value="6.75" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="new_years" label="New term" value="30" min="0" step="any" suffix="years" />
        <x-calc.field name="costs" label="Closing costs" value="6000" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="cash_out" label="Cash out" value="50000" step="0.01" suffix="$" />
        <x-calc.field name="value" label="Home or car value" value="400000" step="0.01" suffix="$" />
    </div>

    <x-calc.checkbox name="roll_costs" label="Add closing costs to the loan" :checked="false" />

    <x-calc.result label="New monthly payment" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['balance' => 200000, 'rate' => 6.5, 'remaining' => 25, 'new_rate' => 6.75, 'new_years' => 30, 'costs' => 6000, 'cash_out' => 50000, 'value' => 400000, 'roll_costs' => true],
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
