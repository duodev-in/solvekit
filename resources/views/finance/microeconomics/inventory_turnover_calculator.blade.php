<x-calc.page
    title="Inventory Turnover Calculator - SolveKit"
    description="Free Inventory Turnover Calculator: turnover = COGS ÷ average inventory. Inventory turnover is how many times stock is sold and replaced in a period."
    lede="Work out the inventory turnover from cost of goods sold and average inventory."
    about="Inventory turnover is how many times stock is sold and replaced in a period. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'inventory_turnover', 'fields' => ['cogs', 'inventory']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Cost of goods sold, Average inventory.'],
        ['name' => 'Read the result', 'text' => 'The inventory turnover appears as you type, with days to sell below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the inventory turnover?', 'answer' => 'Turnover = COGS ÷ average inventory.'],
        ['question' => 'What is the inventory turnover for cost of goods sold $400,000, average inventory $80,000?', 'answer' => '5×. Days to sell: 73 days.'],
        ['question' => 'And for cost of goods sold $1,200,000, average inventory $100,000?', 'answer' => '12×. Days to sell: 30.42 days.'],
        ['question' => 'What does the result tell me?', 'answer' => '365 ÷ turnover is days inventory outstanding.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="cogs" label="Cost of goods sold" value="400000" step="0.01" suffix="$" />
        <x-calc.field name="inventory" label="Average inventory" value="80000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Inventory turnover" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['cogs' => 400000, 'inventory' => 80000],
        'Example B' => ['cogs' => 1200000, 'inventory' => 100000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Days to sell'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>turnover = COGS ÷ average inventory</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
