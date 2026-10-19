<x-calc.page
    title="Interest-Only Mortgage Calculator - SolveKit"
    description="Free interest-only mortgage calculator: payment during the interest-only period and the higher payment once principal repayment starts."
    lede="Compare interest-only and amortizing payments."
    about="During the interest-only period you pay only interest: L × annual rate ÷ 12. Afterwards the full balance is repaid over the remaining years, so the payment jumps. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-loans', 'tool' => 'loan', 'fields' => ['amount', 'rate', 'years', 'io_years']]"
    :how-to="[
        ['name' => 'Enter the loan', 'text' => 'Amount, rate and term.'],
        ['name' => 'Read the payment', 'text' => 'With the schedule and chart.'],
    ]"
    :faqs="[
        ['question' => 'What is the payment on $400,000 at 6.75% with 10 years interest-only?', 'answer' => '$2,250.00 interest-only for 10 years, then this.'],
        ['question' => 'How much more interest than a normal loan?', 'answer' => '$599,949.45 in total.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="amount" label="Loan amount" value="400000" step="0.01" suffix="$" />
        <x-calc.field name="rate" label="Interest rate" value="6.75" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="years" label="Term" value="30" min="0" step="any" suffix="years" />
        <x-calc.field name="io_years" label="Interest-only period" value="10" min="0" step="any" suffix="years" />
    </div>

    <x-calc.result label="Monthly payment" />

    <x-calc.options :decimals="false" :examples="[
        '10 years interest-only' => ['amount' => 400000, 'rate' => 6.75, 'years' => 30, 'io_years' => 10],
        '5 years' => ['amount' => 400000, 'rate' => 6.75, 'years' => 30, 'io_years' => 5],
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
