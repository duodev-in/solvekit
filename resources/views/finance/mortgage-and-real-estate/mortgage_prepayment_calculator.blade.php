<x-calc.page
    title="Mortgage Prepayment Calculator - SolveKit"
    description="Free mortgage prepayment calculator: effect of a lump-sum prepayment or regular extra payments on the payoff date and interest."
    lede="See what a prepayment does to your mortgage."
    about="A prepayment reduces principal at once, so the term shortens (with the same monthly payment) and less interest builds up. Check your loan for prepayment penalties first. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-loans', 'tool' => 'loan', 'fields' => ['amount', 'rate', 'years', 'extra', 'lump', 'lump_month']]"
    :how-to="[
        ['name' => 'Enter the loan', 'text' => 'Amount, rate and term.'],
        ['name' => 'Add extra payments', 'text' => 'Optional: see how much sooner it is paid off.'],
    ]"
    :faqs="[
        ['question' => 'What does a $20,000 prepayment after 5 years save on $320,000 at 6.5%?', 'answer' => '$69,730.80 of interest; paid off in 26 years 4 months (3 years 8 months sooner).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="amount" label="Loan amount" value="320000" step="0.01" suffix="$" />
        <x-calc.field name="rate" label="Interest rate" value="6.5" step="any" suffix="%" />
        <x-calc.field name="years" label="Term" value="30" min="0" step="any" suffix="years" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="extra" label="Extra each month" value="0" step="0.01" suffix="$" />
        <x-calc.field name="lump" label="One-off extra payment" value="20000" step="0.01" suffix="$" />
        <x-calc.field name="lump_month" label="In month" value="60" min="1" step="1" />
    </div>

    <x-calc.result label="Monthly payment" />

    <x-calc.options :decimals="false" :examples="[
        '$20,000 after 5 years' => ['amount' => 320000, 'rate' => 6.5, 'years' => 30, 'lump' => 20000, 'lump_month' => 60, 'extra' => 0],
        'Plus $100 a month' => ['amount' => 320000, 'rate' => 6.5, 'years' => 30, 'lump' => 20000, 'lump_month' => 60, 'extra' => 100],
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
