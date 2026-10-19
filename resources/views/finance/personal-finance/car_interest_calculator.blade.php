<x-calc.page
    title="Car Interest Calculator - SolveKit"
    description="Free car loan interest calculator: total interest on an auto loan and interest by year."
    lede="Find how much interest a car loan costs."
    about="Total interest = monthly payment × months − amount financed. Longer terms lower the payment but add interest. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-loans', 'tool' => 'loan', 'fields' => ['amount', 'rate', 'months']]"
    :how-to="[
        ['name' => 'Enter the loan', 'text' => 'Amount, rate and term.'],
        ['name' => 'Read the payment', 'text' => 'With the schedule and chart.'],
    ]"
    :faqs="[
        ['question' => 'How much interest is paid on $30,000 at 7% for 60 months?', 'answer' => '$5,642.16.'],
        ['question' => 'And 72 months at 7.5%?', 'answer' => '$7,346.64.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="amount" label="Loan amount" value="30000" step="0.01" suffix="$" />
        <x-calc.field name="rate" label="Interest rate" value="7" step="any" suffix="%" />
        <x-calc.field name="months" label="Term" value="60" min="0" step="1" suffix="months" />
    </div>

    <x-calc.result label="Monthly payment" />

    <x-calc.options :decimals="false" :examples="[
        '60 months' => ['amount' => 30000, 'rate' => 7, 'months' => 60],
        '72 months' => ['amount' => 30000, 'rate' => 7.5, 'months' => 72],
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
