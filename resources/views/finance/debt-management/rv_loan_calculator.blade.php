<x-calc.page
    title="RV Loan Calculator - SolveKit"
    description="Free RV loan calculator: monthly payment and interest on a recreational vehicle loan."
    lede="Estimate an RV loan payment."
    about="RV loans often run 10–20 years for larger amounts. Long terms lower the payment but raise the total interest, and RVs lose value quickly. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-loans', 'tool' => 'loan', 'fields' => ['amount', 'rate', 'years']]"
    :how-to="[
        ['name' => 'Enter the loan', 'text' => 'Amount, rate and term.'],
        ['name' => 'Read the payment', 'text' => 'With the schedule and chart.'],
    ]"
    :faqs="[
        ['question' => 'What is the payment on a $60,000 RV loan at 8% for 15 years?', 'answer' => '$573.39, with $43,210.43 of interest.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="amount" label="Loan amount" value="60000" step="0.01" suffix="$" />
        <x-calc.field name="rate" label="Interest rate" value="8" step="any" suffix="%" />
        <x-calc.field name="years" label="Term" value="15" min="0" step="any" suffix="years" />
    </div>

    <x-calc.result label="Monthly payment" />

    <x-calc.options :decimals="false" :examples="[
        'Motorhome' => ['amount' => 60000, 'rate' => 8, 'years' => 15],
        'Travel trailer' => ['amount' => 25000, 'rate' => 8.5, 'years' => 10],
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
