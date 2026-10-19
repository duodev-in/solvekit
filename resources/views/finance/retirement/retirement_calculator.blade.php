<x-calc.page
    title="Retirement Calculator - SolveKit"
    description="Free retirement calculator: savings at retirement, the nest egg your income goal needs, whether savings last to your life expectancy and the extra monthly saving to close a gap."
    lede="Check whether your savings will last through retirement."
    about="Savings grow until retirement with monthly contributions. The nest egg needed is the present value at retirement of withdrawals rising with inflation, net of other income such as Social Security, until your life expectancy. A cautious plan uses a lower return after retirement. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-invest', 'tool' => 'retirement', 'fields' => ['age', 'retire', 'life', 'savings', 'monthly', 'increase', 'rate', 'after', 'inflation', 'income', 'other']]"
    :how-to="[
        ['name' => 'Enter ages and savings', 'text' => ''],
        ['name' => 'Enter returns, inflation and income', 'text' => 'Income in today\'s money.'],
    ]"
    :faqs="[
        ['question' => 'Will $100,000 plus $1,000 a month from 40 be enough for $60,000 a year with $25,000 of Social Security?', 'answer' => '$1,487,639.04 at 67; Lasts past age 92.'],
        ['question' => 'What if I save $2,000 a month?', 'answer' => '$2,472,004.63; Lasts past age 92.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="age" label="Your age" value="40" min="0" step="1" />
        <x-calc.field name="retire" label="Retirement age" value="67" min="0" step="1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="life" label="Plan to age" value="92" min="0" step="1" />
        <x-calc.field name="savings" label="Savings now" value="100000" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="monthly" label="Monthly saving" value="1000" step="0.01" suffix="$" />
        <x-calc.field name="increase" label="Saving increase a year" value="2" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="rate" label="Return before retirement" value="6" step="any" suffix="%" />
        <x-calc.field name="after" label="Return in retirement" value="4.5" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="inflation" label="Inflation" value="2.5" step="any" suffix="%" />
        <x-calc.field name="income" label="Yearly income wanted (today's money)" value="60000" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="other" label="Other income a year (Social Security, pension)" value="25000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Savings at retirement" />

    <x-calc.options :decimals="false" :examples="[
        'Typical' => ['age' => 40, 'retire' => 67, 'life' => 92, 'savings' => 100000, 'monthly' => 1000, 'increase' => 2, 'rate' => 6, 'after' => 4.5, 'inflation' => 2.5, 'income' => 60000, 'other' => 25000],
        'Saving more' => ['age' => 40, 'retire' => 67, 'life' => 92, 'savings' => 100000, 'monthly' => 2000, 'increase' => 2, 'rate' => 6, 'after' => 4.5, 'inflation' => 2.5, 'income' => 60000, 'other' => 25000],
        'Retire early' => ['age' => 35, 'retire' => 55, 'life' => 95, 'savings' => 250000, 'monthly' => 3000, 'increase' => 0, 'rate' => 7, 'after' => 4, 'inflation' => 2.5, 'income' => 70000, 'other' => 0],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Balance over time" name="chart" />
        <x-calc.rows heading="Details" :rows="[
            'needed' => ['label' => 'Nest egg needed'],
            'income' => ['label' => 'Withdrawal needed'],
            'lasts' => ['label' => 'Savings last'],
            'extra' => ['label' => 'Extra saving needed'],
        ]" />
        <x-calc.grid heading="Balance by age" name="schedule" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>nest egg = W(1 − gⁿ) ÷ (1 − g), g = (1 + π) ÷ (1 + r)</li>
            <li>savings = growth of balance and deposits</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
