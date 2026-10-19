<x-calc.page
    title="Scrap Gold Calculator - SolveKit"
    description="Free scrap gold calculator: melt value of gold jewelry by weight and karat at today's spot price, and what a buyer might pay."
    lede="Value your scrap gold."
    about="Pure gold = grams × karat ÷ 24 (14K = 58.3%, 18K = 75%). Melt value = pure grams ÷ 31.1035 × spot price per troy ounce. Enter today's spot price; buyers usually pay 70–90% of melt value. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-life', 'tool' => 'scrap_gold', 'fields' => ['items', 'spot', 'payout']]"
    :how-to="[
        ['name' => 'List pieces by weight and karat', 'text' => ''],
        ['name' => 'Enter the spot price', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is 12.5 g of 14K, 6 g of 18K and 3.2 g of 10K worth at $4,000 an ounce?', 'answer' => '$1,687.91 melt value.'],
    ]"
>
    <x-calc.rows-editor name="items" label="Pieces" :columns="['grams' => 'Grams', 'purity' => 'Karat']" :rows="[[12.5, 14], [6, 18], [3.2, 10]]" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="spot" label="Gold spot price per troy ounce" value="4000" step="0.01" suffix="$" />
        <x-calc.field name="payout" label="Buyer payout" value="80" step="any" suffix="%" />
    </div>

    <x-calc.result label="Melt value" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['items' => '12.5 14
6 18
3.2 10', 'spot' => 4000, 'payout' => 80],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'offer' => ['label' => 'Likely offer'],
            'pure' => ['label' => 'Pure gold'],
            'total' => ['label' => 'Total weight'],
            'ounces' => ['label' => 'Troy ounces'],
        ]" />
        <x-calc.quick-ref heading="Pieces" name="pieces" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>melt = Σ grams × karat ÷ 24 ÷ 31.1035 × spot</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
