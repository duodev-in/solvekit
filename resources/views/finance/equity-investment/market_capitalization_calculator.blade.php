<x-calc.page
    title="Market Capitalization Calculator - SolveKit"
    description="Free Market Capitalization Calculator: market cap = price × shares outstanding. Market capitalization is the market value of all of a company's shares."
    lede="Work out the market capitalization from share price and shares outstanding."
    about="Market capitalization is the market value of all of a company's shares. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'market_capitalization', 'fields' => ['price', 'shares']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Share price, Shares outstanding.'],
        ['name' => 'Read the result', 'text' => 'The market capitalization appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the market capitalization?', 'answer' => 'Market cap = price × shares outstanding.'],
        ['question' => 'What is the market capitalization for share price $150, shares outstanding 2,500,000,000?', 'answer' => '$375,000,000,000.00.'],
        ['question' => 'And for share price $12.40, shares outstanding 80,000,000?', 'answer' => '$992,000,000.00.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Large caps are commonly above $10 billion.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="price" label="Share price" value="150" step="0.01" suffix="$" />
        <x-calc.field name="shares" label="Shares outstanding" value="2500000000" step="any" />
    </div>

    <x-calc.result label="Market capitalization" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['price' => 150, 'shares' => 2500000000],
        'Example B' => ['price' => 12.4, 'shares' => 80000000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>market cap = price × shares outstanding</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
