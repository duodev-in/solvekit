<x-calc.page
    title="403b Calculator - SolveKit"
    description="Free 403(b) calculator: retirement balance for teachers, nurses and non-profit staff from salary deferrals, employer contributions and returns, with the 2026 $24,500 limit and catch-ups."
    lede="Project your 403(b) balance at retirement."
    about="Each year you defer a share of salary, capped at the 2026 limit of $24,500 plus an $8,000 catch-up from age 50 ($11,250 at ages 60–63 under SECURE 2.0). The employer matches a share of your deferral up to a percentage of salary. Contributions are spread through the year, so they earn half a year's return on average. Limits rise with inflation in later years; this keeps them at 2026 values, which is cautious. 403(b) plans share the 401(k) deferral limit; some also allow a 15-year service catch-up, not included here. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-invest', 'tool' => 'workplace', 'fields' => ['salary', 'percent', 'balance', 'match', 'matchLimit', 'raises', 'age', 'retire', 'rate'], 'data' => ['limits' => config('finance_data.limits')], 'sym' => 'USD', 'currency' => 'USD', 'currencyFixed' => true]"
    :how-to="[
        ['name' => 'Enter salary and contribution', 'text' => 'And any employer contribution formula.'],
        ['name' => 'Enter ages and return', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What will a teacher earning $60,000 and saving 10% have after 30 years?', 'answer' => '$700,927.73.'],
        ['question' => 'Do 403(b) and 401(k) limits differ?', 'answer' => 'No: both are $24,500 in 2026 with the same catch-ups.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="salary" label="Annual salary" value="75000" step="0.01" suffix="$" />
        <x-calc.field name="percent" label="You contribute" value="8" step="any" suffix="%" />
        <x-calc.field name="balance" label="Current balance" value="25000" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="match" label="Employer match" value="50" step="any" suffix="%" />
        <x-calc.field name="matchLimit" label="Match up to (% of salary)" value="6" step="any" suffix="%" />
        <x-calc.field name="raises" label="Salary raise a year" value="3" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="age" label="Your age" value="35" min="0" step="1" />
        <x-calc.field name="retire" label="Retirement age" value="65" min="0" step="1" />
        <x-calc.field name="rate" label="Annual return" value="7" step="any" suffix="%" />
    </div>

    <x-calc.result label="Balance at retirement" />

    <x-calc.options :decimals="false" :examples="[
        'Teacher' => ['salary' => 60000, 'percent' => 10, 'balance' => 10000, 'match' => 0, 'matchLimit' => 0, 'raises' => 2.5, 'age' => 35, 'retire' => 65, 'rate' => 6],
        'Hospital' => ['salary' => 85000, 'percent' => 8, 'balance' => 40000, 'match' => 100, 'matchLimit' => 5, 'raises' => 3, 'age' => 40, 'retire' => 67, 'rate' => 6.5],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Balance over time" name="chart" />
        <x-calc.rows heading="Details" :rows="[
            'employee' => ['label' => 'Your contributions'],
            'employer' => ['label' => 'Employer match'],
            'growth' => ['label' => 'Investment growth'],
            'limit' => ['label' => 'Contribution limit'],
            'income' => ['label' => 'Income at 4%'],
        ]" />
        <x-calc.grid heading="Year by year" name="schedule" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>deferral = min(salary × %, limit + catch-up)</li>
            <li>Bₜ₊₁ = Bₜ(1 + r) + C(1 + r)^0.5</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
