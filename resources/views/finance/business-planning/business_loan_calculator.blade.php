<x-calc.page
    title="Business Loan Calculator - SolveKit"
    description="Free business loan calculator: monthly payment, total interest and APR with fees for term loans and SBA loans."
    lede="Estimate a business loan payment."
    about="Term loans repay with level payments. SBA 7(a) loans run up to 10 years (25 for real estate) with a guarantee fee; online lenders may quote factor rates instead, which convert to much higher APRs. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-loans', 'tool' => 'loan', 'fields' => ['amount', 'rate', 'years', 'fee']]"
    :how-to="[
        ['name' => 'Enter the loan', 'text' => 'Amount, rate and term.'],
        ['name' => 'Read the payment', 'text' => 'With the schedule and chart.'],
    ]"
    :faqs="[
        ['question' => 'What is the payment on $100,000 at 10% over 10 years?', 'answer' => '$1,321.51; APR 10.73% with $3,000.00 of fees.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="amount" label="Loan amount" value="100000" step="0.01" suffix="$" />
        <x-calc.field name="rate" label="Interest rate" value="10" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="years" label="Term" value="7" min="0" step="any" suffix="years" />
        <x-calc.field name="fee" label="Fees (% of the loan)" value="3" step="any" suffix="%" />
    </div>

    <x-calc.result label="Monthly payment" />

    <x-calc.options :decimals="false" :examples="[
        'SBA 7(a)' => ['amount' => 100000, 'rate' => 10, 'years' => 10, 'fee' => 3],
        'Bank term loan' => ['amount' => 250000, 'rate' => 8.5, 'years' => 5, 'fee' => 1],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Balance" name="chart" />
        <x-calc.rows heading="Details" :rows="[
            'interest' => ['label' => 'Total interest'],
            'total' => ['label' => 'Total paid'],
            'payoff' => ['label' => 'Paid off in'],
            'saved' => ['label' => 'Interest saved'],
            'apr' => ['label' => 'APR'],
            'share' => ['label' => 'Interest as a share of the loan'],
        ]" />
        <x-calc.grid heading="Amortization by year" name="schedule" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>PMT = P × r ÷ [1 − (1 + r)^−n]</li>
            <li>r = annual rate ÷ 12, n = months</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
