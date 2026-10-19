<x-calc.page
    title="Early Loan Payoff Calculator - SolveKit"
    description="Free early loan payoff calculator: the extra monthly payment needed to pay off a loan by a target date and the interest saved."
    lede="Find the extra payment to pay off a loan early."
    about="The payment for a target is the level payment on the balance over the target months. The extra is that minus your current payment. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-loans', 'tool' => 'early_payoff', 'fields' => ['balance', 'rate', 'payment', 'target']]"
    :how-to="[
        ['name' => 'Enter the loan', 'text' => ''],
        ['name' => 'Enter the target', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How much extra pays off $180,000 at 6.25% in 10 years instead of paying $1,400?', 'answer' => '$621.04 a month, saving $55,967.99.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="balance" label="Balance" value="180000" step="0.01" suffix="$" />
        <x-calc.field name="rate" label="Interest rate" value="6.25" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="payment" label="Current monthly payment" value="1400" step="0.01" suffix="$" />
        <x-calc.field name="target" label="Pay off in" value="10" min="0" step="any" suffix="years" />
    </div>

    <x-calc.result label="Extra each month" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['balance' => 180000, 'rate' => 6.25, 'payment' => 1400, 'target' => 10],
        'Car loan' => ['balance' => 18000, 'rate' => 8, 'payment' => 450, 'target' => 2],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'now' => ['label' => 'At your current payment'],
            'saved' => ['label' => 'Interest saved'],
            'needed' => ['label' => 'Payment needed'],
            'interest' => ['label' => 'Interest with the new payment'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>PMT = B r ÷ [1 − (1 + r)^−n]</li>
            <li>extra = PMT − current</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
