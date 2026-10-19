<x-calc.page
    title="Bi-Weekly Mortgage Payment Calculator - SolveKit"
    description="Free bi-weekly mortgage payment calculator: the payment every two weeks and how much it saves against monthly payments."
    lede="Find your bi-weekly mortgage payment."
    about="The bi-weekly payment is half the monthly payment. 26 payments a year equal 13 monthly payments, which shortens the loan. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-loans', 'tool' => 'biweekly', 'fields' => ['amount', 'rate', 'years']]"
    :how-to="[
        ['name' => 'Enter the loan', 'text' => ''],
        ['name' => 'Read the payment', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the bi-weekly payment on $250,000 at 6.75%?', 'answer' => '$810.75.'],
        ['question' => 'How much interest is saved?', 'answer' => '$79,627.50.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="amount" label="Loan amount" value="250000" step="0.01" suffix="$" />
        <x-calc.field name="rate" label="Interest rate" value="6.75" step="any" suffix="%" />
        <x-calc.field name="years" label="Term" value="30" min="0" step="any" suffix="years" />
    </div>

    <x-calc.result label="Biweekly payment" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['amount' => 250000, 'rate' => 6.75, 'years' => 30],
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
            <li>biweekly = monthly ÷ 2</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
