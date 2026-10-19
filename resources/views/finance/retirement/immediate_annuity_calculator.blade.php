<x-calc.page
    title="Immediate Annuity Calculator - SolveKit"
    description="Free immediate annuity calculator: monthly income a premium buys for a period certain at an interest rate, with the payout rate and break-even time."
    lede="Estimate income from an immediate annuity."
    about="An immediate annuity turns a premium into income starting at once. For a period-certain annuity, payment = premium × i ÷ [1 − (1 + i)^−n]. Life annuities priced by insurers also depend on age, sex and mortality, so get quotes; this shows the interest-only part. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-invest', 'tool' => 'immediate_annuity', 'fields' => ['premium', 'rate', 'years']]"
    :how-to="[
        ['name' => 'Enter the premium', 'text' => ''],
        ['name' => 'Enter the rate and term', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What does $200,000 pay monthly for 20 years at 5%?', 'answer' => '$1,319.91.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="premium" label="Premium" value="200000" step="0.01" suffix="$" />
        <x-calc.field name="rate" label="Interest rate" value="5" step="any" suffix="%" />
        <x-calc.field name="years" label="Years of income" value="20" min="0" step="any" suffix="years" />
    </div>

    <x-calc.result label="Monthly income" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['premium' => 200000, 'rate' => 5, 'years' => 20],
        '10 years' => ['premium' => 100000, 'rate' => 4.5, 'years' => 10],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'yearly' => ['label' => 'Income a year'],
            'total' => ['label' => 'Total income'],
            'payout' => ['label' => 'Payout rate'],
            'breakeven' => ['label' => 'Break-even'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>PMT = P i ÷ [1 − (1 + i)^−n], i = r ÷ 12</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
