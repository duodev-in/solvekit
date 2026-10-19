<x-calc.page
    title="Boat Loan Calculator - SolveKit"
    description="Free boat loan calculator: monthly payment and total cost of a boat loan."
    lede="Estimate a boat loan payment."
    about="Boat loans usually need 10–20% down and run 5–20 years. The payment is the standard amortizing payment on the amount financed. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-loans', 'tool' => 'loan', 'fields' => ['amount', 'rate', 'years']]"
    :how-to="[
        ['name' => 'Enter the loan', 'text' => 'Amount, rate and term.'],
        ['name' => 'Read the payment', 'text' => 'With the schedule and chart.'],
    ]"
    :faqs="[
        ['question' => 'What is the payment on $40,000 at 8.25% for 12 years?', 'answer' => '$438.48.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="amount" label="Loan amount" value="40000" step="0.01" suffix="$" />
        <x-calc.field name="rate" label="Interest rate" value="8.25" step="any" suffix="%" />
        <x-calc.field name="years" label="Term" value="12" min="0" step="any" suffix="years" />
    </div>

    <x-calc.result label="Monthly payment" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['amount' => 40000, 'rate' => 8.25, 'years' => 12],
        'Smaller' => ['amount' => 15000, 'rate' => 9, 'years' => 7],
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
