<x-calc.page
    title="Car Refinance Calculator - SolveKit"
    description="Free car refinance calculator: new auto loan payment, monthly saving and total saving from refinancing at a lower rate."
    lede="See what refinancing a car loan saves."
    about="Refinancing an auto loan helps when rates fall or your credit improves. Fees are usually small, but stretching the term adds interest. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-loans', 'tool' => 'refinance', 'fields' => ['balance', 'rate', 'remaining', 'new_rate', 'new_years', 'costs', 'roll_costs']]"
    :how-to="[
        ['name' => 'Enter the current loan', 'text' => ''],
        ['name' => 'Enter the new loan and costs', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What does refinancing $22,000 from 11% to 7% save?', 'answer' => '$41.78 a month; $1,805.64 less paid over both terms.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="balance" label="Current balance" value="22000" step="0.01" suffix="$" />
        <x-calc.field name="rate" label="Current rate" value="11" step="any" suffix="%" />
        <x-calc.field name="remaining" label="Years left" value="4" min="0" step="any" suffix="years" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="new_rate" label="New rate" value="7" step="any" suffix="%" />
        <x-calc.field name="new_years" label="New term" value="4" min="0" step="any" suffix="years" />
        <x-calc.field name="costs" label="Closing costs" value="200" step="0.01" suffix="$" />
    </div>

    <x-calc.checkbox name="roll_costs" label="Add closing costs to the loan" :checked="false" />

    <x-calc.result label="New monthly payment" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['balance' => 22000, 'rate' => 11, 'remaining' => 4, 'new_rate' => 7, 'new_years' => 4, 'costs' => 200, 'roll_costs' => false],
        'Longer term' => ['balance' => 22000, 'rate' => 11, 'remaining' => 4, 'new_rate' => 7, 'new_years' => 6, 'costs' => 200, 'roll_costs' => false],
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
