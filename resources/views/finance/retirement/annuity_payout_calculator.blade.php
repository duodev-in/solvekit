<x-calc.page
    title="Annuity Payout Calculator - SolveKit"
    description="Free annuity payout calculator: the regular payment a lump sum supports for a number of years at an interest rate."
    lede="Find the income a lump sum can pay."
    about="payment = balance × i ÷ [1 − (1 + i)^−n], with i the rate per period and n the number of payments. The balance reaches zero with the last payment. Insurers' life annuity rates also depend on age and mortality. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-invest', 'tool' => 'annuity_payout', 'fields' => ['balance', 'rate', 'years', 'per', 'timing']]"
    :how-to="[
        ['name' => 'Enter the lump sum', 'text' => ''],
        ['name' => 'Enter rate and term', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What monthly payment does $500,000 support for 25 years at 5%?', 'answer' => '$2,922.95.'],
        ['question' => 'And for 30 years at 4%?', 'answer' => '$2,387.08.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="balance" label="Lump sum" value="500000" step="0.01" suffix="$" />
        <x-calc.field name="rate" label="Annual rate" value="5" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="years" label="Years of payments" value="25" min="0" step="any" suffix="years" />
        <x-calc.select name="per" label="Paid" :options="['12' => 'Monthly', '4' => 'Quarterly', '2' => 'Semi-annually', '1' => 'Yearly']" selected="12" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="timing" label="Paid at" :options="['end' => 'End of each period', 'start' => 'Start of each period']" selected="end" />
    </div>

    <x-calc.result label="Payout" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['balance' => 500000, 'rate' => 5, 'years' => 25, 'per' => '12', 'timing' => 'end'],
        'Longer' => ['balance' => 500000, 'rate' => 4, 'years' => 30, 'per' => '12', 'timing' => 'end'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'total' => ['label' => 'Total paid out'],
            'interest' => ['label' => 'Interest'],
            'yearly' => ['label' => 'A year'],
            'payments' => ['label' => 'Payments'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>PMT = B × i ÷ [1 − (1 + i)^−n]</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
