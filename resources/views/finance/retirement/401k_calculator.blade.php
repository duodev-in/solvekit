<x-calc.page
    title="401k Calculator - SolveKit"
    description="Free 401(k) calculator: retirement balance from salary deferrals, employer match, salary raises and returns, with the 2026 IRS limit of $24,500 and catch-up contributions."
    lede="Project your 401(k) balance at retirement."
    about="Each year you defer a share of salary, capped at the 2026 limit of $24,500 plus an $8,000 catch-up from age 50 ($11,250 at ages 60–63 under SECURE 2.0). The employer matches a share of your deferral up to a percentage of salary. Contributions are spread through the year, so they earn half a year's return on average. Limits rise with inflation in later years; this keeps them at 2026 values, which is cautious. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-invest', 'tool' => 'workplace', 'fields' => ['salary', 'percent', 'balance', 'match', 'matchLimit', 'raises', 'age', 'retire', 'rate'], 'data' => ['limits' => config('finance_data.limits')], 'sym' => 'USD', 'currency' => 'USD', 'currencyFixed' => true]"
    :how-to="[
        ['name' => 'Enter salary and contribution', 'text' => 'And your employer\'s match formula.'],
        ['name' => 'Enter ages and return', 'text' => 'A cautious long-run return is 5–7%.'],
    ]"
    :faqs="[
        ['question' => 'What will a 35-year-old earning $75,000 and saving 8% with a 50% match up to 6% have at 65?', 'answer' => '$1,296,507.22 at 7%.'],
        ['question' => 'What is the 2026 401(k) limit?', 'answer' => '$24,500, plus $8,000 from age 50 or $11,250 at ages 60–63.'],
        ['question' => 'What if I contribute 15%?', 'answer' => '$2,000,453.21.'],
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
        'Typical' => ['salary' => 75000, 'percent' => 8, 'balance' => 25000, 'match' => 50, 'matchLimit' => 6, 'raises' => 3, 'age' => 35, 'retire' => 65, 'rate' => 7],
        'Saving 15%' => ['salary' => 75000, 'percent' => 15, 'balance' => 25000, 'match' => 50, 'matchLimit' => 6, 'raises' => 3, 'age' => 35, 'retire' => 65, 'rate' => 7],
        'Late starter' => ['salary' => 120000, 'percent' => 20, 'balance' => 150000, 'match' => 100, 'matchLimit' => 4, 'raises' => 2, 'age' => 52, 'retire' => 67, 'rate' => 6],
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
            <li>deferral = min(salary × %, 2026 limit + catch-up)</li>
            <li>match = min(deferral, salary × cap) × match %</li>
            <li>Bₜ₊₁ = Bₜ(1 + r) + C(1 + r)^0.5</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
