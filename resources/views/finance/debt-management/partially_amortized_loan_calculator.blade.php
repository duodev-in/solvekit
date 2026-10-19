<x-calc.page
    title="Partially Amortized Loan Calculator - SolveKit"
    description="Free partially amortized loan calculator: payments calculated over a long amortization period, with the remaining balance due as a balloon when the term ends."
    lede="Work out a loan that amortizes over longer than its term."
    about="Commercial loans often amortize over 25–30 years but mature in 5–10. The payment is figured on the long period; the balance left at maturity is the balloon. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-loans', 'tool' => 'loan', 'fields' => ['amount', 'rate', 'years', 'amort_years']]"
    :how-to="[
        ['name' => 'Enter the loan', 'text' => 'Amount, rate and term.'],
        ['name' => 'Read the payment', 'text' => 'With the schedule and chart.'],
    ]"
    :faqs="[
        ['question' => 'What is due at the end of a 10-year loan amortized over 25 years?', 'answer' => '120 payments, then a $786,333.96 balloon.'],
        ['question' => 'What is the monthly payment?', 'answer' => '$7,067.79.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="amount" label="Loan amount" value="1000000" step="0.01" suffix="$" />
        <x-calc.field name="rate" label="Interest rate" value="7" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="years" label="Term" value="10" min="0" step="any" suffix="years" />
        <x-calc.field name="amort_years" label="Amortization period" value="25" min="0" step="any" suffix="years" />
    </div>

    <x-calc.result label="Monthly payment" />

    <x-calc.options :decimals="false" :examples="[
        '10/25' => ['amount' => 1000000, 'rate' => 7, 'years' => 10, 'amort_years' => 25],
        '7/30' => ['amount' => 500000, 'rate' => 6.5, 'years' => 7, 'amort_years' => 30],
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
