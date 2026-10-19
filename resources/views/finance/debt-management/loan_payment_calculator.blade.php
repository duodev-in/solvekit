<x-calc.page
    title="Loan Payment Calculator - SolveKit"
    description="Free loan payment calculator: monthly payment from loan amount, interest rate and term."
    lede="Find the monthly payment on a loan."
    about="Monthly payment = P × r ÷ [1 − (1 + r)^−n], with r = annual rate ÷ 12 and n = months. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-loans', 'tool' => 'loan', 'fields' => ['amount', 'rate', 'months']]"
    :how-to="[
        ['name' => 'Enter the loan', 'text' => 'Amount, rate and term.'],
        ['name' => 'Read the payment', 'text' => 'With the schedule and chart.'],
    ]"
    :faqs="[
        ['question' => 'What is the payment on $15,000 at 9% for 48 months?', 'answer' => '$373.28.'],
        ['question' => 'And $5,000 at 12% for 24 months?', 'answer' => '$235.37.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="amount" label="Loan amount" value="15000" step="0.01" suffix="$" />
        <x-calc.field name="rate" label="Interest rate" value="9" step="any" suffix="%" />
        <x-calc.field name="months" label="Term" value="48" min="0" step="1" suffix="months" />
    </div>

    <x-calc.result label="Monthly payment" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['amount' => 15000, 'rate' => 9, 'months' => 48],
        'Short' => ['amount' => 5000, 'rate' => 12, 'months' => 24],
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
