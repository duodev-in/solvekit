<x-calc.page
    title="Price to Earnings Ratio Calculator - SolveKit"
    description="Free Price to Earnings Ratio Calculator: P/E = price ÷ EPS. The price-to-earnings ratio is what investors pay for each dollar of earnings."
    lede="Work out the P/E ratio from share price and earnings per share."
    about="The price-to-earnings ratio is what investors pay for each dollar of earnings. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'pe_ratio', 'fields' => ['price', 'eps']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Share price, Earnings per share.'],
        ['name' => 'Read the result', 'text' => 'The P/E ratio appears as you type, with earnings yield below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the P/E ratio?', 'answer' => 'P/E = price ÷ EPS.'],
        ['question' => 'What is the P/E ratio for share price $120, earnings per share $6?', 'answer' => '20×. Earnings yield: 5%.'],
        ['question' => 'And for share price $45, earnings per share $1.80?', 'answer' => '25×. Earnings yield: 4%.'],
        ['question' => 'What does the result tell me?', 'answer' => 'The inverse, EPS ÷ price, is the earnings yield.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="price" label="Share price" value="120" step="0.01" suffix="$" />
        <x-calc.field name="eps" label="Earnings per share" value="6" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="P/E ratio" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['price' => 120, 'eps' => 6],
        'Example B' => ['price' => 45, 'eps' => 1.8],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Earnings yield'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>P/E = price ÷ EPS</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
