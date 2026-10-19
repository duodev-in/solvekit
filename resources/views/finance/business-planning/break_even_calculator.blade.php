<x-calc.page
    title="Break-even Calculator - SolveKit"
    description="Free break-even calculator: units and sales needed to cover fixed costs, contribution margin, margin of safety and units for a target profit, with a chart."
    lede="Find your break-even point."
    about="Break-even units = fixed costs ÷ (price − variable cost per unit). Add a target profit to the fixed costs to find the units for that profit. The margin of safety is how far expected sales exceed break-even. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-biz', 'tool' => 'break_even', 'fields' => ['fixed', 'price', 'variable', 'target', 'expected']]"
    :how-to="[
        ['name' => 'Enter fixed costs', 'text' => ''],
        ['name' => 'Enter price and variable cost', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How many units at $40 with $24 variable cost cover $50,000 of fixed costs?', 'answer' => '3,125 units.'],
        ['question' => 'And for a $20,000 profit?', 'answer' => '4,375 units.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="fixed" label="Fixed costs" value="50000" step="0.01" suffix="$" />
        <x-calc.field name="price" label="Price per unit" value="40" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="variable" label="Variable cost per unit" value="24" step="0.01" suffix="$" />
        <x-calc.field name="target" label="Target profit (optional)" value="0" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="expected" label="Expected units (optional)" value="4000" min="0" step="1" />
    </div>

    <x-calc.result label="Break-even units" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['fixed' => 50000, 'price' => 40, 'variable' => 24, 'target' => 0, 'expected' => 4000],
        'Target profit' => ['fixed' => 50000, 'price' => 40, 'variable' => 24, 'target' => 20000, 'expected' => 4000],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Revenue and costs" name="chart" />
        <x-calc.rows heading="Details" :rows="[
            'revenue' => ['label' => 'Break-even sales'],
            'margin' => ['label' => 'Contribution margin'],
            'safety' => ['label' => 'Margin of safety'],
            'profit' => ['label' => 'Profit at expected units'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>Q = (FC + target) ÷ (P − VC)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
