<x-calc.page
    title="LIFO Calculator for Inventory - SolveKit"
    description="Free LIFO inventory calculator: cost of goods sold and ending inventory when the newest units are sold first."
    lede="Value inventory with LIFO."
    about="Last in, first out charges the newest purchase costs to COGS and leaves the oldest costs in ending inventory. LIFO is allowed under US GAAP (with the LIFO conformity rule for tax) but not under IFRS. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-biz', 'tool' => 'fifo', 'fields' => ['layers', 'sold', 'price'], 'method' => 'lifo']"
    :how-to="[
        ['name' => 'List purchases in order', 'text' => ''],
        ['name' => 'Enter units sold', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is LIFO COGS for 280 units from 100 at $10, 150 at $12, 200 at $13?', 'answer' => '$3,560.00.'],
    ]"
>
    <x-calc.rows-editor name="layers" label="Purchases, oldest first" :columns="['units' => 'Units', 'cost' => 'Cost per unit']" :rows="[[100, 10], [150, 12], [200, 13]]" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="sold" label="Units sold" value="280" min="0" step="1" />
        <x-calc.field name="price" label="Selling price (optional)" value="20" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Cost of goods sold (LIFO)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['layers' => '100 10
150 12
200 13', 'sold' => 280, 'price' => 20],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'ending' => ['label' => 'Ending inventory'],
            'units' => ['label' => 'Units left'],
            'average' => ['label' => 'Weighted average COGS'],
            'gross' => ['label' => 'Gross profit'],
        ]" />
        <x-calc.quick-ref heading="Layers sold" name="used" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>COGS = newest layers first</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
