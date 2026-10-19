<x-calc.page
    title="Loan Calculator - SolveKit"
    description="Free loan calculator: monthly payment, total interest and an amortization schedule for any loan, with extra payments."
    lede="Work out the payment and total cost of a loan."
    about="An amortizing loan has a fixed payment, P × r ÷ [1 − (1 + r)^−n], where r is the rate per period and n the number of payments. Each payment covers that period's interest and repays some principal. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-loans', 'tool' => 'loan', 'fields' => ['amount', 'rate', 'years', 'extra']]"
    :how-to="[
        ['name' => 'Enter the loan', 'text' => 'Amount, rate and term.'],
        ['name' => 'Add extra payments', 'text' => 'Optional: see how much sooner it is paid off.'],
    ]"
    :faqs="[
        ['question' => 'What is the payment on $20,000 at 8% for 5 years?', 'answer' => '$405.53, with $4,331.67 of interest.'],
        ['question' => 'What does $100 a month extra do?', 'answer' => 'Paid off in 3 years 11 months (1 year 1 month sooner), saving $1,036.37.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="amount" label="Loan amount" value="20000" step="0.01" suffix="$" />
        <x-calc.field name="rate" label="Interest rate" value="8" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="years" label="Term" value="5" min="0" step="any" suffix="years" />
        <x-calc.field name="extra" label="Extra each month" value="0" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Monthly payment" />

    <x-calc.options :decimals="false" :examples="[
        'Personal loan' => ['amount' => 20000, 'rate' => 8, 'years' => 5, 'extra' => 0],
        'With extra' => ['amount' => 20000, 'rate' => 8, 'years' => 5, 'extra' => 100],
        'Big loan' => ['amount' => 100000, 'rate' => 6, 'years' => 10, 'extra' => 0],
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
