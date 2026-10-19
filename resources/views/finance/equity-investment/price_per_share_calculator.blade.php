<x-calc.page
    title="Price Per Share Calculator - SolveKit"
    description="Free Price Per Share Calculator: price = market cap ÷ shares outstanding. Price per share from the market value and the share count."
    lede="Work out the price per share from market capitalization and shares outstanding."
    about="Price per share from the market value and the share count. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'price_per_share', 'fields' => ['cap', 'shares']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Market capitalization, Shares outstanding.'],
        ['name' => 'Read the result', 'text' => 'The price per share appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the price per share?', 'answer' => 'Price = market cap ÷ shares outstanding.'],
        ['question' => 'What is the price per share for market capitalization $500,000,000, shares outstanding 20,000,000?', 'answer' => '$25.00.'],
        ['question' => 'And for market capitalization $75,000,000, shares outstanding 2,500,000?', 'answer' => '$30.00.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Useful for checking quotes and private valuations.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="cap" label="Market capitalization" value="500000000" step="0.01" suffix="$" />
        <x-calc.field name="shares" label="Shares outstanding" value="20000000" step="any" />
    </div>

    <x-calc.result label="Price per share" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['cap' => 500000000, 'shares' => 20000000],
        'Example B' => ['cap' => 75000000, 'shares' => 2500000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>price = market cap ÷ shares outstanding</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
