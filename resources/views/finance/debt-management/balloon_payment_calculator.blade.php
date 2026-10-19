<x-calc.page
    title="Balloon Payment Calculator - SolveKit"
    description="Free balloon payment calculator: monthly payment on a loan with a lump sum due at the end, and the interest."
    lede="Work out payments on a loan with a balloon."
    about="With a balloon B due at the end, the level payment is [L − B ÷ (1 + r)^n] × r ÷ [1 − (1 + r)^−n]. Lower monthly payments now are paid for with a large final payment that must be refinanced or paid in cash. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-loans', 'tool' => 'loan', 'fields' => ['amount', 'rate', 'years', 'balloon']]"
    :how-to="[
        ['name' => 'Enter the loan', 'text' => 'Amount, rate and term.'],
        ['name' => 'Read the payment', 'text' => 'With the schedule and chart.'],
    ]"
    :faqs="[
        ['question' => 'What is the payment on $50,000 at 7% over 5 years with a $15,000 balloon?', 'answer' => '$780.54.'],
        ['question' => 'And without the balloon?', 'answer' => '$990.06.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="amount" label="Loan amount" value="50000" step="0.01" suffix="$" />
        <x-calc.field name="rate" label="Interest rate" value="7" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="years" label="Term" value="5" min="0" step="any" suffix="years" />
        <x-calc.field name="balloon" label="Balloon payment" value="15000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Monthly payment" />

    <x-calc.options :decimals="false" :examples="[
        'Car with balloon' => ['amount' => 50000, 'rate' => 7, 'years' => 5, 'balloon' => 15000],
        'No balloon' => ['amount' => 50000, 'rate' => 7, 'years' => 5, 'balloon' => 0],
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
