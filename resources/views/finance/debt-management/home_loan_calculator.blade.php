<x-calc.page
    title="Home Loan Calculator - SolveKit"
    description="Free home loan calculator: monthly payment, interest and amortization schedule for a home loan."
    lede="Estimate a home loan payment."
    about="A home loan repays the amount borrowed with level monthly payments over 15–30 years. Add property tax and insurance for the full cost with the Mortgage Calculator. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-loans', 'tool' => 'loan', 'fields' => ['amount', 'rate', 'years', 'extra']]"
    :how-to="[
        ['name' => 'Enter the loan', 'text' => 'Amount, rate and term.'],
        ['name' => 'Add extra payments', 'text' => 'Optional: see how much sooner it is paid off.'],
    ]"
    :faqs="[
        ['question' => 'What is the payment on a $300,000 home loan at 6.5%?', 'answer' => '$1,896.20.'],
        ['question' => 'And over 20 years at 6.25%?', 'answer' => '$2,192.78.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="amount" label="Loan amount" value="300000" step="0.01" suffix="$" />
        <x-calc.field name="rate" label="Interest rate" value="6.5" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="years" label="Term" value="30" min="0" step="any" suffix="years" />
        <x-calc.field name="extra" label="Extra each month" value="0" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Monthly payment" />

    <x-calc.options :decimals="false" :examples="[
        '30-year' => ['amount' => 300000, 'rate' => 6.5, 'years' => 30, 'extra' => 0],
        '20-year' => ['amount' => 300000, 'rate' => 6.25, 'years' => 20, 'extra' => 0],
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
