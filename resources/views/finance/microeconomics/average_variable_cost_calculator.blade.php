<x-calc.page
    title="Average Variable Cost Calculator - SolveKit"
    description="Free Average Variable Cost Calculator: AVC = total variable cost ÷ quantity. Average variable cost is the variable cost per unit."
    lede="Work out the average variable cost from total variable cost and quantity."
    about="Average variable cost is the variable cost per unit. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'average_variable_cost', 'fields' => ['variable', 'quantity']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Total variable cost, Quantity.'],
        ['name' => 'Read the result', 'text' => 'The average variable cost appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the average variable cost?', 'answer' => 'AVC = total variable cost ÷ quantity.'],
        ['question' => 'What is the average variable cost for total variable cost $30,000, quantity 5,000?', 'answer' => '$6.00.'],
        ['question' => 'And for total variable cost $8,400, quantity 1,200?', 'answer' => '$7.00.'],
        ['question' => 'What does the result tell me?', 'answer' => 'A firm should shut down in the short run if price falls below minimum AVC.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="variable" label="Total variable cost" value="30000" step="0.01" suffix="$" />
        <x-calc.field name="quantity" label="Quantity" value="5000" step="any" />
    </div>

    <x-calc.result label="Average variable cost" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['variable' => 30000, 'quantity' => 5000],
        'Example B' => ['variable' => 8400, 'quantity' => 1200],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>AVC = total variable cost ÷ quantity</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
