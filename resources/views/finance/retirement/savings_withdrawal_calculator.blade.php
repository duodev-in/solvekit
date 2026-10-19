<x-calc.page
    title="Savings Withdrawal Calculator - SolveKit"
    description="Free savings withdrawal calculator: how long a savings balance lasts with regular monthly withdrawals and interest."
    lede="See how long savings last if you draw on them each month."
    about="The balance earns interest monthly and a fixed withdrawal is taken each month (optionally rising each year). The sustainable withdrawal is the interest alone, which leaves the balance unchanged. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-invest', 'tool' => 'withdrawal', 'fields' => ['balance', 'withdrawal', 'rate', 'increase']]"
    :how-to="[
        ['name' => 'Enter savings and withdrawal', 'text' => ''],
        ['name' => 'Enter the interest rate', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How long do $100,000 last at $1,000 a month and 4%?', 'answer' => '10 years 2 months.'],
        ['question' => 'What withdrawal keeps $100,000 intact at 4%?', 'answer' => '$327.37 a month keeps the balance level (no increases).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="balance" label="Savings" value="100000" step="0.01" suffix="$" />
        <x-calc.field name="withdrawal" label="Monthly withdrawal" value="1000" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="rate" label="Interest rate" value="4" step="any" suffix="%" />
        <x-calc.field name="increase" label="Yearly increase" value="0" step="any" suffix="%" />
    </div>

    <x-calc.result label="Savings last" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['balance' => 100000, 'withdrawal' => 1000, 'rate' => 4, 'increase' => 0],
        'Bigger draw' => ['balance' => 100000, 'withdrawal' => 2000, 'rate' => 4, 'increase' => 0],
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
        </ul>
    </x-slot:formula>
</x-calc.page>
