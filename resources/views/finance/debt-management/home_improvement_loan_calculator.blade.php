<x-calc.page
    title="Home Improvement Loan Calculator - SolveKit"
    description="Free home improvement loan calculator: payment and total cost of a loan for renovations."
    lede="Estimate the payment on a renovation loan."
    about="Home improvement loans are usually unsecured personal loans (2–7 years) or secured by home equity (HELOC or home equity loan) at lower rates. Origination fees raise the APR. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-loans', 'tool' => 'loan', 'fields' => ['amount', 'rate', 'years', 'fee']]"
    :how-to="[
        ['name' => 'Enter the loan', 'text' => 'Amount, rate and term.'],
        ['name' => 'Read the payment', 'text' => 'With the schedule and chart.'],
    ]"
    :faqs="[
        ['question' => 'What is the payment on $25,000 at 9.5% for 5 years?', 'answer' => '$525.05; APR with a 2% fee 10.37% with $500.00 of fees.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="amount" label="Loan amount" value="25000" step="0.01" suffix="$" />
        <x-calc.field name="rate" label="Interest rate" value="9.5" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="years" label="Term" value="5" min="0" step="any" suffix="years" />
        <x-calc.field name="fee" label="Fees (% of the loan)" value="2" step="any" suffix="%" />
    </div>

    <x-calc.result label="Monthly payment" />

    <x-calc.options :decimals="false" :examples="[
        'Personal loan' => ['amount' => 25000, 'rate' => 9.5, 'years' => 5, 'fee' => 2],
        'Home equity loan' => ['amount' => 25000, 'rate' => 8, 'years' => 10, 'fee' => 0],
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
