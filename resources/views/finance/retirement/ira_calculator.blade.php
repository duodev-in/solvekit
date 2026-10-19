<x-calc.page
    title="IRA calculator - SolveKit"
    description="Free traditional IRA calculator: balance at retirement from yearly contributions capped at the 2026 $7,500 limit ($8,600 at 50+), with the after-tax value at withdrawal."
    lede="Project a traditional IRA balance."
    about="Traditional IRA contributions may be tax-deductible and grow tax-deferred; withdrawals are taxed as income. The 2026 limit is $7,500, plus $1,100 from age 50. Contributions are made at the start of each year here. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-invest', 'tool' => 'ira', 'fields' => ['contribution', 'balance', 'age', 'retire', 'rate', 'tax'], 'data' => ['limits' => config('finance_data.limits')], 'sym' => 'USD', 'currency' => 'USD', 'currencyFixed' => true]"
    :how-to="[
        ['name' => 'Enter contributions', 'text' => 'Up to the limit.'],
        ['name' => 'Enter ages, return and tax rate', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What does $7,500 a year from 40 to 65 at 6% give, starting with $15,000?', 'answer' => '$500,550.93, about $390,429.73 after 22% tax.'],
        ['question' => 'What is the 2026 IRA limit?', 'answer' => '$7,500, or $8,600 from age 50.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="contribution" label="Yearly contribution" value="7500" step="0.01" suffix="$" />
        <x-calc.field name="balance" label="Current balance" value="15000" step="0.01" suffix="$" />
        <x-calc.field name="age" label="Your age" value="40" min="0" step="1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="retire" label="Retirement age" value="65" min="0" step="1" />
        <x-calc.field name="rate" label="Annual return" value="6" step="any" suffix="%" />
        <x-calc.field name="tax" label="Tax rate in retirement" value="22" step="any" suffix="%" />
    </div>

    <x-calc.result label="Balance at retirement" />

    <x-calc.options :decimals="false" :examples="[
        'Typical' => ['contribution' => 7500, 'balance' => 15000, 'age' => 40, 'retire' => 65, 'rate' => 6, 'tax' => 22],
        'Over 50' => ['contribution' => 9000, 'balance' => 80000, 'age' => 55, 'retire' => 67, 'rate' => 5, 'tax' => 22],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Balance over time" name="chart" />
        <x-calc.rows heading="Details" :rows="[
            'allowed' => ['label' => 'Contribution limit'],
            'contributed' => ['label' => 'Contributions'],
            'growth' => ['label' => 'Growth'],
            'after' => ['label' => 'After tax'],
            'saved' => ['label' => 'Tax deduction'],
        ]" />
        <x-calc.grid heading="Year by year" name="schedule" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>B = Σ C(1 + r)^(n − t) + B₀(1 + r)^n</li>
            <li>C ≤ 2026 limit</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
