<x-calc.page
    title="Earnings per Share Calculator - SolveKit"
    description="Free Earnings per Share Calculator: EPS = (net income − preferred dividends) ÷ weighted shares. Earnings per share is the profit belonging to each common share."
    lede="Work out the EPS from net income, preferred dividends and weighted average shares."
    about="Earnings per share is the profit belonging to each common share. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'earnings_per_share', 'fields' => ['income', 'preferred', 'shares']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Net income, Preferred dividends, Weighted average shares.'],
        ['name' => 'Read the result', 'text' => 'The EPS appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the EPS?', 'answer' => 'EPS = (net income − preferred dividends) ÷ weighted shares.'],
        ['question' => 'What is the EPS for net income $10,000,000, preferred dividends $500,000, weighted average shares 4,000,000?', 'answer' => '$2.38.'],
        ['question' => 'And for net income $2,500,000, preferred dividends $0, weighted average shares 1,250,000?', 'answer' => '$2.00.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Diluted EPS also counts options and convertibles.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="income" label="Net income" value="10000000" step="0.01" suffix="$" />
        <x-calc.field name="preferred" label="Preferred dividends" value="500000" step="0.01" suffix="$" />
        <x-calc.field name="shares" label="Weighted average shares" value="4000000" step="any" />
    </div>

    <x-calc.result label="EPS" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['income' => 10000000, 'preferred' => 500000, 'shares' => 4000000],
        'Example B' => ['income' => 2500000, 'preferred' => 0, 'shares' => 1250000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>EPS = (net income − preferred dividends) ÷ weighted shares</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
