<x-calc.page
    title="Sell-Through Rate Calculator - SolveKit"
    description="Free Sell-Through Rate Calculator: sell-through = units sold ÷ units received. Sell-through rate shows how much of the stock received was sold in a period."
    lede="Work out the sell-through rate from units sold and units received."
    about="Sell-through rate shows how much of the stock received was sold in a period. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'sell_through_rate', 'fields' => ['sold', 'received']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Units sold, Units received.'],
        ['name' => 'Read the result', 'text' => 'The sell-through rate appears as you type, with units left below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the sell-through rate?', 'answer' => 'Sell-through = units sold ÷ units received.'],
        ['question' => 'What is the sell-through rate for units sold 380, units received 500?', 'answer' => '76%. Units left: 120.'],
        ['question' => 'And for units sold 140, units received 400?', 'answer' => '35%. Units left: 260.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Low sell-through ties up money in stock; very high may mean you under-ordered.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="sold" label="Units sold" value="380" min="0" step="1" />
        <x-calc.field name="received" label="Units received" value="500" min="0" step="1" />
    </div>

    <x-calc.result label="Sell-through rate" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['sold' => 380, 'received' => 500],
        'Example B' => ['sold' => 140, 'received' => 400],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Units left'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>sell-through = units sold ÷ units received</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
