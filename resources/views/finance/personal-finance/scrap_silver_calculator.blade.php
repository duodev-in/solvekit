<x-calc.page
    title="Scrap Silver Calculator - SolveKit"
    description="Free scrap silver calculator: melt value of sterling, coin and fine silver by weight and fineness at today's spot price."
    lede="Value your scrap silver."
    about="Pure silver = grams × fineness (sterling 925 = 92.5%, US coins before 1965 900 = 90%, Britannia 958, fine 999). Melt value = pure grams ÷ 31.1035 × spot price. Enter today's spot price. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-life', 'tool' => 'scrap_silver', 'fields' => ['items', 'spot', 'payout']]"
    :how-to="[
        ['name' => 'List pieces by weight and fineness', 'text' => ''],
        ['name' => 'Enter the spot price', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What are 250 g of sterling and 62.5 g of coin silver worth at $45?', 'answer' => '$415.95.'],
    ]"
>
    <x-calc.rows-editor name="items" label="Pieces" :columns="['grams' => 'Grams', 'purity' => 'Fineness (‰ or %)']" :rows="[[250, 925], [62.5, 900]]" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="spot" label="Silver spot price per troy ounce" value="45" step="0.01" suffix="$" />
        <x-calc.field name="payout" label="Buyer payout" value="75" step="any" suffix="%" />
    </div>

    <x-calc.result label="Melt value" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['items' => '250 925
62.5 900', 'spot' => 45, 'payout' => 75],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'offer' => ['label' => 'Likely offer'],
            'pure' => ['label' => 'Pure silver'],
            'total' => ['label' => 'Total weight'],
            'ounces' => ['label' => 'Troy ounces'],
        ]" />
        <x-calc.quick-ref heading="Pieces" name="pieces" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>melt = Σ grams × fineness ÷ 31.1035 × spot</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
