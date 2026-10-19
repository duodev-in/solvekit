<x-calc.page
    title="Retirement Withdrawal Calculator - SolveKit"
    description="Free retirement withdrawal calculator: how long savings last with monthly withdrawals that rise with inflation, and the withdrawal that keeps the balance level."
    lede="See how long your retirement savings will last."
    about="Each month the balance earns its return (an annual rate converted to monthly) and the withdrawal is taken; withdrawals rise once a year by your inflation figure. Markets vary, so treat a long result as an estimate, not a promise. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-invest', 'tool' => 'withdrawal', 'fields' => ['balance', 'withdrawal', 'rate', 'increase']]"
    :how-to="[
        ['name' => 'Enter savings and withdrawal', 'text' => ''],
        ['name' => 'Enter return and inflation', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How long do $800,000 last at $4,000 a month rising 2.5% a year, earning 5%?', 'answer' => '21 years 9 months.'],
        ['question' => 'And at $3,000 a month?', 'answer' => '32 years 7 months.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="balance" label="Savings" value="800000" step="0.01" suffix="$" />
        <x-calc.field name="withdrawal" label="Monthly withdrawal" value="4000" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="rate" label="Annual return" value="5" step="any" suffix="%" />
        <x-calc.field name="increase" label="Yearly increase (inflation)" value="2.5" step="any" suffix="%" />
    </div>

    <x-calc.result label="Savings last" />

    <x-calc.options :decimals="false" :examples="[
        'Typical' => ['balance' => 800000, 'withdrawal' => 4000, 'rate' => 5, 'increase' => 2.5],
        'Lower' => ['balance' => 800000, 'withdrawal' => 3000, 'rate' => 5, 'increase' => 2.5],
        'No growth' => ['balance' => 300000, 'withdrawal' => 2500, 'rate' => 0, 'increase' => 0],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Balance" name="chart" />
        <x-calc.rows heading="Details" :rows="[
            'total' => ['label' => 'Total withdrawn'],
            'sustainable' => ['label' => 'Sustainable withdrawal'],
            'rate' => ['label' => 'Withdrawal rate'],
            'end' => ['label' => 'Balance left'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>Bₘ₊₁ = Bₘ(1 + r) − W</li>
            <li>W rises by inflation each year</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
