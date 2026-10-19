<x-calc.page
    title="Ending Inventory Calculator - SolveKit"
    description="Free Ending Inventory Calculator: ending = beginning + purchases − COGS. Ending inventory is what is left at the end of the period."
    lede="Work out the ending inventory from beginning inventory, purchases and cost of goods sold."
    about="Ending inventory is what is left at the end of the period. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'ending_inventory', 'fields' => ['begin', 'purchases', 'cogs']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Beginning inventory, Purchases, Cost of goods sold.'],
        ['name' => 'Read the result', 'text' => 'The ending inventory appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the ending inventory?', 'answer' => 'Ending = beginning + purchases − COGS.'],
        ['question' => 'What is the ending inventory for beginning inventory $50,000, purchases $120,000, cost of goods sold $130,000?', 'answer' => '$40,000.00.'],
        ['question' => 'And for beginning inventory $8,000, purchases $22,000, cost of goods sold $25,000?', 'answer' => '$5,000.00.'],
        ['question' => 'What does the result tell me?', 'answer' => 'It becomes next period\'s beginning inventory.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="begin" label="Beginning inventory" value="50000" step="0.01" suffix="$" />
        <x-calc.field name="purchases" label="Purchases" value="120000" step="0.01" suffix="$" />
        <x-calc.field name="cogs" label="Cost of goods sold" value="130000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Ending inventory" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['begin' => 50000, 'purchases' => 120000, 'cogs' => 130000],
        'Example B' => ['begin' => 8000, 'purchases' => 22000, 'cogs' => 25000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>ending = beginning + purchases − COGS</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
