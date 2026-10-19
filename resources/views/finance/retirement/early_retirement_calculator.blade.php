<x-calc.page
    title="Early Retirement Calculator - SolveKit"
    description="Free early retirement calculator: savings needed to retire at a chosen age from your spending and a safe withdrawal rate, projected savings and the gap."
    lede="Find what you need to retire early."
    about="Target = yearly spending at retirement ÷ withdrawal rate; a 4% rate (from the Trinity study of 30-year retirements) means 25 times spending. Longer early retirements suggest a lower rate such as 3.25–3.5%. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-invest', 'tool' => 'early_retirement', 'fields' => ['age', 'retire', 'expenses', 'wr', 'savings', 'monthly', 'rate', 'inflation']]"
    :how-to="[
        ['name' => 'Enter spending and withdrawal rate', 'text' => ''],
        ['name' => 'Enter savings and return', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How much does a 32-year-old spending $50,000 need to retire at 50?', 'answer' => '$1,949,573.40 at a 4% withdrawal rate with 2.5% inflation.'],
        ['question' => 'Will $150,000 plus $2,500 a month get there?', 'answer' => '$1,603,683.46 projected: $345,889.93 short.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="age" label="Your age" value="32" min="0" step="1" />
        <x-calc.field name="retire" label="Target retirement age" value="50" min="0" step="1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="expenses" label="Yearly spending (today)" value="50000" step="0.01" suffix="$" />
        <x-calc.field name="wr" label="Withdrawal rate" value="4" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="savings" label="Savings now" value="150000" step="0.01" suffix="$" />
        <x-calc.field name="monthly" label="Monthly saving" value="2500" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="rate" label="Annual return" value="7" step="any" suffix="%" />
        <x-calc.field name="inflation" label="Inflation" value="2.5" step="any" suffix="%" />
    </div>

    <x-calc.result label="Savings needed" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['age' => 32, 'retire' => 50, 'expenses' => 50000, 'wr' => 4, 'savings' => 150000, 'monthly' => 2500, 'rate' => 7, 'inflation' => 2.5],
        'Lean FIRE' => ['age' => 30, 'retire' => 45, 'expenses' => 30000, 'wr' => 3.5, 'savings' => 100000, 'monthly' => 2000, 'rate' => 7, 'inflation' => 2.5],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'projected' => ['label' => 'Projected savings'],
            'gap' => ['label' => 'Gap'],
            'extra' => ['label' => 'Extra monthly saving'],
            'reach' => ['label' => 'Reach the target'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>target = spending × (1 + π)^t ÷ WR</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
