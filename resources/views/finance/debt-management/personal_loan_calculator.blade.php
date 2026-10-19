<x-calc.page
    title="Personal Loan Calculator - SolveKit"
    description="Free personal loan calculator: payment, total interest and APR including an origination fee."
    lede="Find a personal loan payment and its true APR."
    about="Lenders often take an origination fee (1–10%) from the loan, so you receive less than you repay on. The APR counts that fee: it is the rate at which the payments equal the amount you actually receive (Regulation Z). Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-loans', 'tool' => 'loan', 'fields' => ['amount', 'rate', 'years', 'fee']]"
    :how-to="[
        ['name' => 'Enter the loan', 'text' => 'Amount, rate and term.'],
        ['name' => 'Read the payment', 'text' => 'With the schedule and chart.'],
    ]"
    :faqs="[
        ['question' => 'What is the payment on $15,000 at 11% for 3 years?', 'answer' => '$491.08.'],
        ['question' => 'What APR does a 5% fee make?', 'answer' => '14.58% with $750.00 of fees.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="amount" label="Loan amount" value="15000" step="0.01" suffix="$" />
        <x-calc.field name="rate" label="Interest rate" value="11" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="years" label="Term" value="3" min="0" step="any" suffix="years" />
        <x-calc.field name="fee" label="Fees (% of the loan)" value="5" step="any" suffix="%" />
    </div>

    <x-calc.result label="Monthly payment" />

    <x-calc.options :decimals="false" :examples="[
        'With fee' => ['amount' => 15000, 'rate' => 11, 'years' => 3, 'fee' => 5],
        'No fee' => ['amount' => 15000, 'rate' => 11, 'years' => 3, 'fee' => 0],
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
