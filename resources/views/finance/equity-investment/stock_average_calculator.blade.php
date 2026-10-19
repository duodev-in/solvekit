<x-calc.page
    title="Stock Average Calculator - SolveKit"
    description="Free stock average calculator: average cost per share across several purchases (dollar-cost averaging) and the gain at today's price."
    lede="Find your average cost per share."
    about="Average price = total cost ÷ total shares, weighting each purchase by its shares. Averaging down lowers the break-even price. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-markets', 'tool' => 'stock_average', 'fields' => ['buys', 'price']]"
    :how-to="[
        ['name' => 'List each purchase', 'text' => ''],
        ['name' => 'Add today\'s price', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the average of 100 at $42, 50 at $36.50 and 80 at $39.20?', 'answer' => '$39.83.'],
    ]"
>
    <x-calc.rows-editor name="buys" label="Purchases" :columns="['shares' => 'Shares', 'price' => 'Price']" :rows="[[100, 42], [50, 36.5], [80, 39.2]]" />

    <x-calc.field name="price" label="Current price (optional)" value="41" step="0.01" suffix="$" />

    <x-calc.result label="Average price per share" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['buys' => '100 42
50 36.5
80 39.2', 'price' => 41],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'shares' => ['label' => 'Total shares'],
            'cost' => ['label' => 'Total cost'],
            'value' => ['label' => 'Value now'],
            'pl' => ['label' => 'Gain or loss'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>average = Σ nᵢ pᵢ ÷ Σ nᵢ</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
