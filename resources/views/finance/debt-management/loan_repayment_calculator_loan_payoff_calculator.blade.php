<x-calc.page
    title="Loan Repayment Calculator | Loan Payoff Calculator - SolveKit"
    description="Free loan repayment and payoff calculator: how long it takes to repay a loan at a given monthly payment, and the payment to finish by a target."
    lede="Find how long it takes to repay a loan."
    about="Months to repay n = −ln(1 − Br ÷ PMT) ÷ ln(1 + r). The payment must be more than the monthly interest. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-loans', 'tool' => 'payoff', 'fields' => ['balance', 'rate', 'payment', 'target']]"
    :how-to="[
        ['name' => 'Enter balance, rate and payment', 'text' => ''],
        ['name' => 'Add a target', 'text' => 'Optional.'],
    ]"
    :faqs="[
        ['question' => 'How long to repay $15,000 at 9% paying $400 a month?', 'answer' => '3 years 9 months, with $2,679.09 interest.'],
        ['question' => 'What payment clears it in 3 years?', 'answer' => '$477.00 a month to finish in 3 years ($77.00 more).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="balance" label="Loan balance" value="15000" step="0.01" suffix="$" />
        <x-calc.field name="rate" label="Interest rate" value="9" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="payment" label="Monthly payment" value="400" step="0.01" suffix="$" />
        <x-calc.field name="target" label="Target (optional)" value="3" min="0" step="any" suffix="years" />
    </div>

    <x-calc.result label="Time to pay off" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['balance' => 15000, 'rate' => 9, 'payment' => 400, 'target' => 3],
        'Bigger payment' => ['balance' => 15000, 'rate' => 9, 'payment' => 700, 'target' => ''],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Balance" name="chart" />
        <x-calc.rows heading="Details" :rows="[
            'interest' => ['label' => 'Total interest'],
            'total' => ['label' => 'Total paid'],
            'last' => ['label' => 'Final payment'],
            'target' => ['label' => 'Payment for your target'],
        ]" />
        <x-calc.grid heading="Amortization by year" name="schedule" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>n = −ln(1 − Br ÷ PMT) ÷ ln(1 + r)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
