<x-calc.page
    title="Mortgage Refinance Calculator - SolveKit"
    description="Free mortgage refinance calculator: new payment, monthly saving, break-even on closing costs and the lifetime cost of refinancing."
    lede="See whether refinancing your mortgage pays off."
    about="Refinancing replaces your loan with a new one. It pays when the monthly saving recovers the closing costs (usually 2–5% of the loan) before you move or refinance again. Restarting a 30-year term can lower the payment but add interest overall. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-loans', 'tool' => 'refinance', 'fields' => ['balance', 'rate', 'remaining', 'new_rate', 'new_years', 'costs', 'value', 'roll_costs']]"
    :how-to="[
        ['name' => 'Enter the current loan', 'text' => ''],
        ['name' => 'Enter the new loan and costs', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'Does refinancing $300,000 from 7.25% to 6% pay off with $6,000 of costs?', 'answer' => 'The payment falls by $313.93; break-even in 20 months (1.593 years).'],
        ['question' => 'What about a 15-year loan at 5.5%?', 'answer' => '$2,451.25 a month; $237,251.50 less paid over both terms.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="balance" label="Current balance" value="300000" step="0.01" suffix="$" />
        <x-calc.field name="rate" label="Current rate" value="7.25" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="remaining" label="Years left" value="27" min="0" step="any" suffix="years" />
        <x-calc.field name="new_rate" label="New rate" value="6" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="new_years" label="New term" value="30" min="0" step="any" suffix="years" />
        <x-calc.field name="costs" label="Closing costs" value="6000" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="value" label="Home or car value" value="450000" step="0.01" suffix="$" />
    </div>

    <x-calc.checkbox name="roll_costs" label="Add closing costs to the loan" :checked="false" />

    <x-calc.result label="New monthly payment" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['balance' => 300000, 'rate' => 7.25, 'remaining' => 27, 'new_rate' => 6, 'new_years' => 30, 'costs' => 6000, 'value' => 450000, 'roll_costs' => false],
        'Shorter term' => ['balance' => 300000, 'rate' => 7.25, 'remaining' => 27, 'new_rate' => 5.5, 'new_years' => 15, 'costs' => 6000, 'value' => 450000, 'roll_costs' => false],
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
