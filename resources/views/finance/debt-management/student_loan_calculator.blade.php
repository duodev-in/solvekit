<x-calc.page
    title="Student Loan Calculator - SolveKit"
    description="Free student loan calculator: monthly payment, total interest and payoff date, with extra payments."
    lede="Plan your student loan repayment."
    about="Federal Direct Loans default to a 10-year standard plan. For 2026–27, undergraduate Direct Loans carry a fixed rate set each July from the 10-year Treasury auction. Extra payments go to interest first, then principal. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-loans', 'tool' => 'loan', 'fields' => ['amount', 'rate', 'years', 'extra']]"
    :how-to="[
        ['name' => 'Enter the loan', 'text' => 'Amount, rate and term.'],
        ['name' => 'Add extra payments', 'text' => 'Optional: see how much sooner it is paid off.'],
    ]"
    :faqs="[
        ['question' => 'What is the payment on $30,000 at 6.39% over 10 years?', 'answer' => '$338.97.'],
        ['question' => 'What does $100 a month extra do?', 'answer' => 'Paid off in 7 years 2 months (2 years 10 months sooner), saving $3,280.15.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="amount" label="Loan amount" value="30000" step="0.01" suffix="$" />
        <x-calc.field name="rate" label="Interest rate" value="6.39" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="years" label="Term" value="10" min="0" step="any" suffix="years" />
        <x-calc.field name="extra" label="Extra each month" value="0" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Monthly payment" />

    <x-calc.options :decimals="false" :examples="[
        'Undergraduate' => ['amount' => 30000, 'rate' => 6.39, 'years' => 10, 'extra' => 0],
        'Extra $100' => ['amount' => 30000, 'rate' => 6.39, 'years' => 10, 'extra' => 100],
        'Graduate' => ['amount' => 80000, 'rate' => 7.94, 'years' => 10, 'extra' => 0],
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
