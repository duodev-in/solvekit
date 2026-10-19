<x-calc.page
    title="FIRE Calculator – Financial Independence, Retire Early - SolveKit"
    description="Free FIRE calculator: your FIRE number from yearly spending and a safe withdrawal rate, and the years until you reach it at your saving rate."
    lede="Find your FIRE number and when you reach it."
    about="FIRE number = yearly spending ÷ withdrawal rate (25× spending at 4%). Savings grow at the real (after-inflation) return you enter, plus yearly saving, until they reach the number. Your saving rate, not your income, mostly decides how long it takes. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-invest', 'tool' => 'fire', 'fields' => ['expenses', 'wr', 'savings', 'yearly', 'rate', 'income', 'age']]"
    :how-to="[
        ['name' => 'Enter spending and withdrawal rate', 'text' => ''],
        ['name' => 'Enter savings and real return', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the FIRE number for $40,000 a year of spending?', 'answer' => '$1,000,000.00 at 4%.'],
        ['question' => 'How long with $50,000 invested and $30,000 saved a year at a 5% real return?', 'answer' => '19 years, at age 49.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="expenses" label="Yearly spending" value="40000" step="0.01" suffix="$" />
        <x-calc.field name="wr" label="Withdrawal rate" value="4" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="savings" label="Invested now" value="50000" step="0.01" suffix="$" />
        <x-calc.field name="yearly" label="Saved a year" value="30000" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="rate" label="Real return" value="5" step="any" suffix="%" />
        <x-calc.field name="income" label="After-tax income (optional)" value="80000" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="age" label="Your age (optional)" value="30" min="0" step="1" />
    </div>

    <x-calc.result label="FIRE number" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['expenses' => 40000, 'wr' => 4, 'savings' => 50000, 'yearly' => 30000, 'rate' => 5, 'income' => 80000, 'age' => 30],
        'Fat FIRE' => ['expenses' => 100000, 'wr' => 3.5, 'savings' => 400000, 'yearly' => 60000, 'rate' => 5, 'income' => 180000, 'age' => 38],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Path to FIRE" name="chart" />
        <x-calc.rows heading="Details" :rows="[
            'years' => ['label' => 'Years to FIRE'],
            'multiple' => ['label' => 'Multiple of spending'],
            'savingsRate' => ['label' => 'Saving rate'],
            'monthly' => ['label' => 'Monthly spending'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>FIRE = spending ÷ WR</li>
            <li>Bₜ₊₁ = Bₜ(1 + r) + S until B ≥ FIRE</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
