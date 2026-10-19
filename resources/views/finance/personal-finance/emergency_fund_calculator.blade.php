<x-calc.page
    title="Emergency Fund Calculator - SolveKit"
    description="Free Emergency Fund Calculator: target = monthly essentials × months. Many planners suggest 3–6 months of essential expenses in an easy-access account; more if income is irregular."
    lede="Work out the emergency fund target from your figures."
    about="Many planners suggest 3–6 months of essential expenses in an easy-access account; more if income is irregular. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'emergency_fund', 'fields' => ['expenses', 'months', 'saved', 'monthly']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Essential monthly expenses, Months to cover, Already saved, You can save a month.'],
        ['name' => 'Read the result', 'text' => 'The emergency fund target appears as you type, with still to save, months to reach it below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the emergency fund target?', 'answer' => 'Target = monthly essentials × months.'],
        ['question' => 'What is the emergency fund target for essential monthly expenses $3,500, months to cover 6, already saved $5,000, you can save a month $400?', 'answer' => '$21,000.00. Still to save: $16,000.00.'],
        ['question' => 'And for essential monthly expenses $2,200, months to cover 3, already saved $1,500, you can save a month $250?', 'answer' => '$6,600.00. Still to save: $5,100.00.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Count rent, food, utilities, insurance and minimum debt payments.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="expenses" label="Essential monthly expenses" value="3500" step="0.01" suffix="$" />
        <x-calc.field name="months" label="Months to cover" value="6" min="0" step="any" suffix="months" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="saved" label="Already saved" value="5000" step="0.01" suffix="$" />
        <x-calc.field name="monthly" label="You can save a month" value="400" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Emergency fund target" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['expenses' => 3500, 'months' => 6, 'saved' => 5000, 'monthly' => 400],
        'Example B' => ['expenses' => 2200, 'months' => 3, 'saved' => 1500, 'monthly' => 250],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Still to save'],
            'r2' => ['label' => 'Months to reach it'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>target = monthly essentials × months</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
