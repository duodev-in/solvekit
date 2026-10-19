<x-calc.page
    title="Sabbatical Calculator - SolveKit"
    description="Free sabbatical calculator: cost of time off, savings by the start date and how many months you can afford, with the monthly saving needed."
    lede="Plan the money for a sabbatical."
    about="Cost = (monthly spending − any income during the break) × months + one-off costs. Savings at the start = savings now + monthly saving × months until the break. Keep an emergency fund separate. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-invest', 'tool' => 'sabbatical', 'fields' => ['expenses', 'months', 'oneoff', 'income', 'saved', 'monthly', 'until']]"
    :how-to="[
        ['name' => 'Enter the costs', 'text' => 'Monthly and one-off.'],
        ['name' => 'Enter your saving plan', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What does a 6-month break at $3,000 a month plus $4,000 cost?', 'answer' => '$22,000.00; affordable: 5.333 months.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="expenses" label="Monthly spending during the break" value="3000" step="0.01" suffix="$" />
        <x-calc.field name="months" label="Months off" value="6" min="0" step="1" suffix="months" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="oneoff" label="One-off costs (travel, insurance)" value="4000" step="0.01" suffix="$" />
        <x-calc.field name="income" label="Income during the break" value="0" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="saved" label="Saved now" value="8000" step="0.01" suffix="$" />
        <x-calc.field name="monthly" label="Monthly saving" value="1000" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="until" label="Months until it starts" value="12" min="0" step="1" suffix="months" />
    </div>

    <x-calc.result label="Sabbatical cost" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['expenses' => 3000, 'months' => 6, 'oneoff' => 4000, 'income' => 0, 'saved' => 8000, 'monthly' => 1000, 'until' => 12],
        'Part-time income' => ['expenses' => 3500, 'months' => 12, 'oneoff' => 2000, 'income' => 1000, 'saved' => 15000, 'monthly' => 800, 'until' => 18],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'fund' => ['label' => 'Saved by the start'],
            'affordable' => ['label' => 'Months you can afford'],
            'need' => ['label' => 'Monthly saving needed'],
            'gap' => ['label' => 'Gap'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>cost = (spending − income) × months + one-off</li>
            <li>fund = saved + monthly × months until</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
