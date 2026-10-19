<x-calc.page
    title="Gross Margin Calculator - SolveKit"
    description="Free Gross Margin Calculator: gross margin = (revenue − COGS) ÷ revenue. Gross margin is the share of revenue left after the direct cost of goods."
    lede="Work out the gross margin from revenue and cost of goods sold."
    about="Gross margin is the share of revenue left after the direct cost of goods. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'gross_margin', 'fields' => ['revenue', 'cogs']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Revenue, Cost of goods sold.'],
        ['name' => 'Read the result', 'text' => 'The gross margin appears as you type, with gross profit below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the gross margin?', 'answer' => 'Gross margin = (revenue − COGS) ÷ revenue.'],
        ['question' => 'What is the gross margin for revenue $500,000, cost of goods sold $300,000?', 'answer' => '40%. Gross profit: $200,000.00.'],
        ['question' => 'And for revenue $80, cost of goods sold $52?', 'answer' => '35%. Gross profit: $28.00.'],
        ['question' => 'What does the result tell me?', 'answer' => 'It must cover all other expenses and profit.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="revenue" label="Revenue" value="500000" step="0.01" suffix="$" />
        <x-calc.field name="cogs" label="Cost of goods sold" value="300000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Gross margin" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['revenue' => 500000, 'cogs' => 300000],
        'Example B' => ['revenue' => 80, 'cogs' => 52],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Gross profit'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>gross margin = (revenue − COGS) ÷ revenue</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
