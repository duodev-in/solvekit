<x-calc.page
    title="Price to Cash Flow Ratio Calculator - SolveKit"
    description="Free Price to Cash Flow Ratio Calculator: P/CF = price ÷ cash flow per share. Price to cash flow is less affected by non-cash accounting charges than P/E."
    lede="Work out the P/CF ratio from share price and operating cash flow per share."
    about="Price to cash flow is less affected by non-cash accounting charges than P/E. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'price_to_cash_flow_ratio', 'fields' => ['price', 'cfps']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Share price, Operating cash flow per share.'],
        ['name' => 'Read the result', 'text' => 'The P/CF ratio appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the P/CF ratio?', 'answer' => 'P/CF = price ÷ cash flow per share.'],
        ['question' => 'What is the P/CF ratio for share price $40, operating cash flow per share $5?', 'answer' => '8×.'],
        ['question' => 'And for share price $95, operating cash flow per share $6.30?', 'answer' => '15.08×.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Compare within an industry.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="price" label="Share price" value="40" step="0.01" suffix="$" />
        <x-calc.field name="cfps" label="Operating cash flow per share" value="5" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="P/CF ratio" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['price' => 40, 'cfps' => 5],
        'Example B' => ['price' => 95, 'cfps' => 6.3],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>P/CF = price ÷ cash flow per share</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
