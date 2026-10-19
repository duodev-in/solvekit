<x-calc.page
    title="Avalanche vs Snowball Comparison - SolveKit"
    description="Free avalanche vs snowball comparison: interest, payoff time and order for both debt payoff methods with the same budget."
    lede="Compare the avalanche and snowball methods."
    about="Both methods pay all minimums and put extra money on one debt at a time. Avalanche targets the highest APR; snowball the smallest balance. The difference in interest is often small, so the method you will stick to matters most. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-loans', 'tool' => 'snowball_vs_avalanche', 'fields' => ['debts', 'budget']]"
    :how-to="[
        ['name' => 'List your debts', 'text' => ''],
        ['name' => 'Set a budget', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How much does the avalanche save on these four debts?', 'answer' => '$375.19.'],
        ['question' => 'Which clears a debt first?', 'answer' => 'Snowball clears Store card in month 3; avalanche clears Store card in month 3.'],
    ]"
>
    <x-calc.rows-editor name="debts" label="Debts" :columns="['name' => 'Debt', 'balance' => 'Balance', 'rate' => 'APR %', 'minimum' => 'Minimum']" :rows="[['Credit card', 6500, 24.99, 160], ['Car loan', 14000, 7.5, 380], ['Store card', 1200, 29.99, 40], ['Personal loan', 4000, 11.5, 130]]" :text="['name']" />

    <x-calc.field name="budget" label="Monthly budget for debts" value="1200" step="0.01" suffix="$" />

    <x-calc.result label="Avalanche saves" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['debts' => 'Credit card	6500	24.99	160
Car loan	14000	7.5	380
Store card	1200	29.99	40
Personal loan	4000	11.5	130', 'budget' => 1200],
        'Tight budget' => ['debts' => 'Credit card	6500	24.99	160
Car loan	14000	7.5	380
Store card	1200	29.99	40
Personal loan	4000	11.5	130', 'budget' => 900],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'avalanche' => ['label' => 'Avalanche'],
            'snowball' => ['label' => 'Snowball'],
            'firstWin' => ['label' => 'First debt cleared'],
            'months' => ['label' => 'Time difference'],
        ]" />
        <x-calc.quick-ref heading="Avalanche order" name="avalanche" :generated="true" />
        <x-calc.quick-ref heading="Snowball order" name="snowball" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>avalanche: highest APR first</li>
            <li>snowball: smallest balance first</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
