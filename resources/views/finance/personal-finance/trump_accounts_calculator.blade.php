<x-calc.page
    title="Trump Accounts Calculator - SolveKit"
    description="Free Trump account calculator: a child's account at 18 with the $1,000 Treasury pilot deposit (born 2025–2028), family and employer contributions up to $5,000 a year, and growth."
    lede="Project a child's Trump account at 18."
    about="Trump accounts (One Big Beautiful Bill Act, 2025) are IRA-style accounts for children invested in US stock index funds. Children who are US citizens born 2025–2028 can get a one-time $1,000 Treasury deposit. Others may contribute up to $5,000 a year in total from July 4, 2026 (indexed after 2027), including up to $2,500 tax-free from a parent's employer. Funds generally stay invested until 18. Rules follow Treasury Notice 2025-68 and may change with final regulations. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-invest', 'tool' => 'trump_account', 'fields' => ['born', 'family', 'employer', 'rate'], 'data' => ['trump' => config('finance_data.trump')], 'sym' => 'USD', 'currency' => 'USD', 'currencyFixed' => true]"
    :how-to="[
        ['name' => 'Enter the birth year', 'text' => 'For the $1,000 pilot.'],
        ['name' => 'Enter contributions and return', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What could a child born in 2026 have at 18 with $2,000 a year at 7%?', 'answer' => '$71,378.00.'],
        ['question' => 'Only the $1,000 deposit?', 'answer' => '$3,379.93 at 7%.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="born" label="Child's birth year" value="2026" min="2008" step="1" />
        <x-calc.field name="family" label="Family contributions a year" value="2000" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="employer" label="Employer contribution a year" value="0" step="0.01" suffix="$" />
        <x-calc.field name="rate" label="Annual return" value="7" step="any" suffix="%" />
    </div>

    <x-calc.result label="Balance at 18" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['born' => 2026, 'family' => 2000, 'employer' => 0, 'rate' => 7],
        'Pilot only' => ['born' => 2026, 'family' => 0, 'employer' => 0, 'rate' => 7],
        'Maximum' => ['born' => 2025, 'family' => 2500, 'employer' => 2500, 'rate' => 7],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'seed' => ['label' => 'Treasury pilot deposit'],
            'yearly' => ['label' => 'Yearly contributions'],
            'deposits' => ['label' => 'Total deposits'],
            'growth' => ['label' => 'Growth'],
        ]" />
        <x-calc.grid heading="Year by year" name="schedule" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>B = 1,000(1 + r)^n + C[(1 + r)^n − 1] ÷ r</li>
            <li>C ≤ $5,000, employer ≤ $2,500</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
