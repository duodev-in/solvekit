<x-calc.page
    title="Expense Ratio Calculator - SolveKit"
    description="Free Expense Ratio Calculator: cost = P(1 + r)^n − P(1 + r − ER)^n. A fund's expense ratio is deducted from returns every year, so its cost compounds."
    lede="Work out the lost to fees from your figures."
    about="A fund's expense ratio is deducted from returns every year, so its cost compounds. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'expense_ratio', 'fields' => ['balance', 'ratio', 'ret', 'years']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Investment, Expense ratio, Annual return before fees, Years.'],
        ['name' => 'Read the result', 'text' => 'The lost to fees appears as you type, with balance without fees, balance after fees, first-year fee below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the lost to fees?', 'answer' => 'Cost = P(1 + r)^n − P(1 + r − ER)^n.'],
        ['question' => 'What is the lost to fees for investment $100,000, expense ratio 0.75%, annual return before fees 7%, years 25?', 'answer' => '$87,521.03. Balance without fees: $542,743.26.'],
        ['question' => 'And for investment $25,000, expense ratio 0.04%, annual return before fees 7%, years 30?', 'answer' => '$2,122.75. Balance without fees: $190,306.38.'],
        ['question' => 'What does the result tell me?', 'answer' => '0.75% a year over 25 years costs about 16% of the ending balance at 7%.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="balance" label="Investment" value="100000" step="0.01" suffix="$" />
        <x-calc.field name="ratio" label="Expense ratio" value="0.75" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="ret" label="Annual return before fees" value="7" step="any" suffix="%" />
        <x-calc.field name="years" label="Years" value="25" min="0" step="any" suffix="years" />
    </div>

    <x-calc.result label="Lost to fees" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['balance' => 100000, 'ratio' => 0.75, 'ret' => 7, 'years' => 25],
        'Example B' => ['balance' => 25000, 'ratio' => 0.04, 'ret' => 7, 'years' => 30],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Balance without fees'],
            'r2' => ['label' => 'Balance after fees'],
            'r3' => ['label' => 'First-year fee'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>cost = P(1 + r)^n − P(1 + r − ER)^n</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
