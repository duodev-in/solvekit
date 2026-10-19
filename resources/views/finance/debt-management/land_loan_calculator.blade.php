<x-calc.page
    title="Land Loan Calculator - SolveKit"
    description="Free land loan calculator: payment on a loan for a lot or raw land, which usually needs a bigger down payment and shorter term."
    lede="Estimate a land loan payment."
    about="Land loans carry more risk for lenders, so they often require 20–50% down, shorter terms (10–20 years) and higher rates, sometimes with a balloon. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-loans', 'tool' => 'loan', 'fields' => ['amount', 'rate', 'years', 'balloon']]"
    :how-to="[
        ['name' => 'Enter the loan', 'text' => 'Amount, rate and term.'],
        ['name' => 'Read the payment', 'text' => 'With the schedule and chart.'],
    ]"
    :faqs="[
        ['question' => 'What is the payment on an $80,000 land loan at 8.5% for 15 years?', 'answer' => '$787.79.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="amount" label="Loan amount" value="80000" step="0.01" suffix="$" />
        <x-calc.field name="rate" label="Interest rate" value="8.5" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="years" label="Term" value="15" min="0" step="any" suffix="years" />
        <x-calc.field name="balloon" label="Balloon payment" value="0" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Monthly payment" />

    <x-calc.options :decimals="false" :examples="[
        'Lot' => ['amount' => 80000, 'rate' => 8.5, 'years' => 15, 'balloon' => 0],
        'With balloon' => ['amount' => 80000, 'rate' => 8.5, 'years' => 5, 'balloon' => 50000],
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
