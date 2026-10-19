<x-calc.page
    title="Loan Interest Calculator - SolveKit"
    description="Free loan interest calculator: total interest over the life of a loan and interest paid each year."
    lede="Find the total interest on a loan."
    about="Total interest = payment × number of payments − amount borrowed. The schedule shows how much interest you pay each year. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-loans', 'tool' => 'loan', 'fields' => ['amount', 'rate', 'years']]"
    :how-to="[
        ['name' => 'Enter the loan', 'text' => 'Amount, rate and term.'],
        ['name' => 'Read the payment', 'text' => 'With the schedule and chart.'],
    ]"
    :faqs="[
        ['question' => 'How much interest is paid on $25,000 at 7.5% over 5 years?', 'answer' => '$5,056.92.'],
        ['question' => 'And over 7 years?', 'answer' => '$7,210.38.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="amount" label="Loan amount" value="25000" step="0.01" suffix="$" />
        <x-calc.field name="rate" label="Interest rate" value="7.5" step="any" suffix="%" />
        <x-calc.field name="years" label="Term" value="5" min="0" step="any" suffix="years" />
    </div>

    <x-calc.result label="Monthly payment" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['amount' => 25000, 'rate' => 7.5, 'years' => 5],
        'Longer' => ['amount' => 25000, 'rate' => 7.5, 'years' => 7],
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
