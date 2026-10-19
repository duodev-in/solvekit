<x-calc.page
    title="Average Fixed Cost Calculator - SolveKit"
    description="Free Average Fixed Cost Calculator: AFC = total fixed cost ÷ quantity. Average fixed cost falls as output rises, because the same fixed costs are spread over more units."
    lede="Work out the average fixed cost from total fixed costs and units produced."
    about="Average fixed cost falls as output rises, because the same fixed costs are spread over more units. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'average_fixed_cost', 'fields' => ['fixed', 'quantity']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Total fixed costs, Units produced.'],
        ['name' => 'Read the result', 'text' => 'The average fixed cost appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the average fixed cost?', 'answer' => 'AFC = total fixed cost ÷ quantity.'],
        ['question' => 'What is the average fixed cost for total fixed costs $50,000, units produced 10,000?', 'answer' => '$5.00.'],
        ['question' => 'And for total fixed costs $120,000, units produced 4,000?', 'answer' => '$30.00.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Doubling output halves average fixed cost.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="fixed" label="Total fixed costs" value="50000" step="0.01" suffix="$" />
        <x-calc.field name="quantity" label="Units produced" value="10000" min="0" step="1" />
    </div>

    <x-calc.result label="Average fixed cost" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['fixed' => 50000, 'quantity' => 10000],
        'Example B' => ['fixed' => 120000, 'quantity' => 4000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>AFC = total fixed cost ÷ quantity</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
