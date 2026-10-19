<x-calc.page
    title="Profit Calculator - SolveKit"
    description="Free Profit Calculator: profit = revenue − costs. Profit is what remains after costs; margin is profit as a share of revenue."
    lede="Work out the profit from revenue and total costs."
    about="Profit is what remains after costs; margin is profit as a share of revenue. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'profit', 'fields' => ['revenue', 'costs']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Revenue, Total costs.'],
        ['name' => 'Read the result', 'text' => 'The profit appears as you type, with margin, markup below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the profit?', 'answer' => 'Profit = revenue − costs.'],
        ['question' => 'What is the profit for revenue $25,000, total costs $18,000?', 'answer' => '$7,000.00. Margin: 28%.'],
        ['question' => 'And for revenue $900, total costs $1,050?', 'answer' => '−$150.00. Margin: −16.67%.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Markup is profit as a share of cost.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="revenue" label="Revenue" value="25000" step="0.01" suffix="$" />
        <x-calc.field name="costs" label="Total costs" value="18000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Profit" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['revenue' => 25000, 'costs' => 18000],
        'Example B' => ['revenue' => 900, 'costs' => 1050],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Margin'],
            'r2' => ['label' => 'Markup'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>profit = revenue − costs</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
