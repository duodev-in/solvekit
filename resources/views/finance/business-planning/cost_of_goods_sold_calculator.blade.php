<x-calc.page
    title="Cost of Goods Sold Calculator - SolveKit"
    description="Free Cost of Goods Sold Calculator: COGS = beginning inventory + purchases − ending inventory. Cost of goods sold is the cost of the inventory sold during the period, from the periodic inventory method."
    lede="Work out the cost of goods sold from beginning inventory, purchases and ending inventory."
    about="Cost of goods sold is the cost of the inventory sold during the period, from the periodic inventory method. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'cost_of_goods_sold', 'fields' => ['begin', 'purchases', 'end']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Beginning inventory, Purchases, Ending inventory.'],
        ['name' => 'Read the result', 'text' => 'The cost of goods sold appears as you type, with goods available for sale below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the cost of goods sold?', 'answer' => 'COGS = beginning inventory + purchases − ending inventory.'],
        ['question' => 'What is the cost of goods sold for beginning inventory $40,000, purchases $125,000, ending inventory $35,000?', 'answer' => '$130,000.00. Goods available for sale: $165,000.00.'],
        ['question' => 'And for beginning inventory $12,000, purchases $30,000, ending inventory $9,500?', 'answer' => '$32,500.00. Goods available for sale: $42,000.00.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Revenue − COGS is gross profit.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="begin" label="Beginning inventory" value="40000" step="0.01" suffix="$" />
        <x-calc.field name="purchases" label="Purchases" value="125000" step="0.01" suffix="$" />
        <x-calc.field name="end" label="Ending inventory" value="35000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Cost of goods sold" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['begin' => 40000, 'purchases' => 125000, 'end' => 35000],
        'Example B' => ['begin' => 12000, 'purchases' => 30000, 'end' => 9500],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Goods available for sale'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>COGS = beginning inventory + purchases − ending inventory</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
