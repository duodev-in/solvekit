<x-calc.page
    title="Price to Sales Ratio Calculator - SolveKit"
    description="Free Price to Sales Ratio Calculator: P/S = market cap ÷ revenue. Price to sales values a company on its revenue."
    lede="Work out the P/S ratio from market capitalization and annual revenue."
    about="Price to sales values a company on its revenue. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'price_to_sales_ratio', 'fields' => ['cap', 'sales']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Market capitalization, Annual revenue.'],
        ['name' => 'Read the result', 'text' => 'The P/S ratio appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the P/S ratio?', 'answer' => 'P/S = market cap ÷ revenue.'],
        ['question' => 'What is the P/S ratio for market capitalization $30,000,000, annual revenue $15,000,000?', 'answer' => '2×.'],
        ['question' => 'And for market capitalization $2,400,000,000, annual revenue $600,000,000?', 'answer' => '4×.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Useful for young companies without profits.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="cap" label="Market capitalization" value="30000000" step="0.01" suffix="$" />
        <x-calc.field name="sales" label="Annual revenue" value="15000000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="P/S ratio" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['cap' => 30000000, 'sales' => 15000000],
        'Example B' => ['cap' => 2400000000, 'sales' => 600000000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>P/S = market cap ÷ revenue</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
