<x-calc.page
    title="Biweekly Mortgage Calculator - SolveKit"
    description="Free biweekly mortgage calculator: paying half the monthly payment every two weeks, the payoff time and interest saved."
    lede="See what paying every two weeks saves."
    about="Paying half the monthly payment every two weeks makes 26 half-payments a year, the same as 13 monthly payments. The extra payment goes to principal, so a 30-year loan is paid off years sooner. Check that your servicer applies the payments when received. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-loans', 'tool' => 'biweekly', 'fields' => ['amount', 'rate', 'years']]"
    :how-to="[
        ['name' => 'Enter the loan', 'text' => ''],
        ['name' => 'Compare', 'text' => 'Biweekly against monthly.'],
    ]"
    :faqs="[
        ['question' => 'How much sooner is a $300,000 30-year loan at 6.5% paid off biweekly?', 'answer' => '5 years 10 months sooner, saving $88,121.78.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="amount" label="Loan amount" value="300000" step="0.01" suffix="$" />
        <x-calc.field name="rate" label="Interest rate" value="6.5" step="any" suffix="%" />
        <x-calc.field name="years" label="Term" value="30" min="0" step="any" suffix="years" />
    </div>

    <x-calc.result label="Biweekly payment" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['amount' => 300000, 'rate' => 6.5, 'years' => 30],
        '15-year' => ['amount' => 300000, 'rate' => 5.75, 'years' => 15],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Balance: biweekly vs monthly" name="chart" />
        <x-calc.rows heading="Details" :rows="[
            'payoff' => ['label' => 'Paid off in'],
            'sooner' => ['label' => 'Sooner than monthly'],
            'saved' => ['label' => 'Interest saved'],
            'interest' => ['label' => 'Total interest'],
            'yearly' => ['label' => 'Paid a year'],
        ]" />
        <x-calc.grid heading="Amortization by year" name="schedule" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>biweekly = monthly ÷ 2, 26 payments a year</li>
            <li>interest each period = balance × rate ÷ 26</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
