<x-calc.page
    title="Mortgage Points Calculator - SolveKit"
    description="Free mortgage points calculator: cost of discount points against the lower payment, with the break-even month and net saving."
    lede="Decide whether buying points pays off."
    about="One discount point costs 1% of the loan and typically lowers the rate by about 0.25 percentage points (it varies by lender). Break-even = cost ÷ monthly saving. Points pay off only if you keep the loan past that point. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-loans', 'tool' => 'points', 'fields' => ['amount', 'rate', 'points_rate', 'points', 'years', 'stay']]"
    :how-to="[
        ['name' => 'Enter the loan and both rates', 'text' => 'From your loan estimates.'],
        ['name' => 'Enter points and how long you will stay', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'Do 2 points to drop 6.75% to 6.25% on $350,000 pay off?', 'answer' => 'Break-even after 61 months; $2,666.98 saved if you keep the loan 7 years.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="amount" label="Loan amount" value="350000" step="0.01" suffix="$" />
        <x-calc.field name="rate" label="Rate without points" value="6.75" step="any" suffix="%" />
        <x-calc.field name="points_rate" label="Rate with points" value="6.25" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="points" label="Points" value="2" min="0" step="0.125" />
        <x-calc.field name="years" label="Term" value="30" min="0" step="any" suffix="years" />
        <x-calc.field name="stay" label="Years you will keep the loan" value="7" min="0" step="any" suffix="years" />
    </div>

    <x-calc.result label="Break-even" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['amount' => 350000, 'rate' => 6.75, 'points_rate' => 6.25, 'points' => 2, 'years' => 30, 'stay' => 7],
        'Short stay' => ['amount' => 350000, 'rate' => 6.75, 'points_rate' => 6.5, 'points' => 1, 'years' => 30, 'stay' => 3],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'cost' => ['label' => 'Cost of points'],
            'saving' => ['label' => 'Monthly saving'],
            'payments' => ['label' => 'Payments'],
            'net' => ['label' => 'Net result'],
            'lifetime' => ['label' => 'Saving over the full term'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>cost = loan × points %</li>
            <li>break-even = cost ÷ (PMT₁ − PMT₂)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
