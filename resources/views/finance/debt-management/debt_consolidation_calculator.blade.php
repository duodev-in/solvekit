<x-calc.page
    title="Debt Consolidation Calculator - SolveKit"
    description="Free debt consolidation calculator: compare paying your current debts with one consolidation loan by payment and total interest."
    lede="See whether consolidating your debts saves money."
    about="A consolidation loan pays off several debts so you make one payment, ideally at a lower rate. Fees and a longer term can cancel the saving; compare total interest, not just the payment. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-loans', 'tool' => 'consolidation', 'fields' => ['debts', 'rate', 'years', 'fee']]"
    :how-to="[
        ['name' => 'List your debts', 'text' => ''],
        ['name' => 'Enter the loan offer', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'Does an 11% loan over 4 years beat paying these debts\' minimums?', 'answer' => 'Payment $684.16; saving $1,981.38.'],
    ]"
>
    <x-calc.rows-editor name="debts" label="Debts" :columns="['name' => 'Debt', 'balance' => 'Balance', 'rate' => 'APR %', 'minimum' => 'Minimum']" :rows="[['Credit card', 6500, 24.99, 160], ['Car loan', 14000, 7.5, 380], ['Store card', 1200, 29.99, 40], ['Personal loan', 4000, 11.5, 130]]" :text="['name']" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="rate" label="Consolidation loan rate" value="11" step="any" suffix="%" />
        <x-calc.field name="years" label="Loan term" value="4" min="0" step="any" suffix="years" />
        <x-calc.field name="fee" label="Origination fee" value="3" step="any" suffix="%" />
    </div>

    <x-calc.result label="Consolidation loan payment" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['debts' => 'Credit card	6500	24.99	160
Car loan	14000	7.5	380
Store card	1200	29.99	40
Personal loan	4000	11.5	130', 'rate' => 11, 'years' => 4, 'fee' => 3],
        'Long term' => ['debts' => 'Credit card	6500	24.99	160
Car loan	14000	7.5	380
Store card	1200	29.99	40
Personal loan	4000	11.5	130', 'rate' => 13, 'years' => 7, 'fee' => 5],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'total' => ['label' => 'Debt consolidated'],
            'interest' => ['label' => 'Interest with the loan'],
            'current' => ['label' => 'Interest now'],
            'saving' => ['label' => 'Saving'],
            'rate' => ['label' => 'Rates'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>loan = Σ balances × (1 + fee)</li>
            <li>compare total interest</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
