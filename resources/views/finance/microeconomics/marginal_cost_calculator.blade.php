<x-calc.page
    title="Marginal Cost Calculator - SolveKit"
    description="Free Marginal Cost Calculator: MC = ΔTC ÷ ΔQ. Marginal cost is the extra cost of producing one more unit."
    lede="Work out the marginal cost from your figures."
    about="Marginal cost is the extra cost of producing one more unit. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'marginal_cost', 'fields' => ['cost1', 'cost2', 'q1', 'q2']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Total cost before, Total cost after, Quantity before, Quantity after.'],
        ['name' => 'Read the result', 'text' => 'The marginal cost appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the marginal cost?', 'answer' => 'MC = ΔTC ÷ ΔQ.'],
        ['question' => 'What is the marginal cost for total cost before $50,000, total cost after $56,000, quantity before 1,000, quantity after 1,200?', 'answer' => '$30.00.'],
        ['question' => 'And for total cost before $2,000, total cost after $2,600, quantity before 100, quantity after 150?', 'answer' => '$12.00.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Profit is maximized where marginal cost equals marginal revenue.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="cost1" label="Total cost before" value="50000" step="0.01" suffix="$" />
        <x-calc.field name="cost2" label="Total cost after" value="56000" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="q1" label="Quantity before" value="1000" step="any" />
        <x-calc.field name="q2" label="Quantity after" value="1200" step="any" />
    </div>

    <x-calc.result label="Marginal cost" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['cost1' => 50000, 'cost2' => 56000, 'q1' => 1000, 'q2' => 1200],
        'Example B' => ['cost1' => 2000, 'cost2' => 2600, 'q1' => 100, 'q2' => 150],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>MC = ΔTC ÷ ΔQ</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
