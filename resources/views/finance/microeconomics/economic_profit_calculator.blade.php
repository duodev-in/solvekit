<x-calc.page
    title="Economic Profit Calculator - SolveKit"
    description="Free Economic Profit Calculator: economic profit = revenue − explicit costs − implicit costs. Economic profit also subtracts the value of the next-best use of your time and capital."
    lede="Work out the economic profit from total revenue, explicit costs and implicit (opportunity) costs."
    about="Economic profit also subtracts the value of the next-best use of your time and capital. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'economic_profit', 'fields' => ['revenue', 'explicit', 'implicit']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Total revenue, Explicit costs, Implicit (opportunity) costs.'],
        ['name' => 'Read the result', 'text' => 'The economic profit appears as you type, with accounting profit below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the economic profit?', 'answer' => 'Economic profit = revenue − explicit costs − implicit costs.'],
        ['question' => 'What is the economic profit for total revenue $500,000, explicit costs $380,000, implicit costs $90,000?', 'answer' => '$30,000.00. Accounting profit: $120,000.00.'],
        ['question' => 'And for total revenue $200,000, explicit costs $120,000, implicit costs $95,000?', 'answer' => '−$15,000.00. Accounting profit: $80,000.00.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Zero economic profit still means a normal return.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="revenue" label="Total revenue" value="500000" step="0.01" suffix="$" />
        <x-calc.field name="explicit" label="Explicit costs" value="380000" step="0.01" suffix="$" />
        <x-calc.field name="implicit" label="Implicit (opportunity) costs" value="90000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Economic profit" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['revenue' => 500000, 'explicit' => 380000, 'implicit' => 90000],
        'Example B' => ['revenue' => 200000, 'explicit' => 120000, 'implicit' => 95000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Accounting profit'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>economic profit = revenue − explicit costs − implicit costs</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
