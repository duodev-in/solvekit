<x-calc.page
    title="Margin Calculator Classic - SolveKit"
    description="Free Margin Calculator Classic: price = cost ÷ (1 − margin). The price that gives a target gross margin."
    lede="Work out the selling price from cost and target margin."
    about="The price that gives a target gross margin. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'margin_calculator_classic', 'fields' => ['cost', 'margin']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Cost, Target margin.'],
        ['name' => 'Read the result', 'text' => 'The selling price appears as you type, with profit, markup below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the selling price?', 'answer' => 'Price = cost ÷ (1 − margin).'],
        ['question' => 'What is the selling price for cost $60, target margin 40%?', 'answer' => '$100.00. Profit: $40.00.'],
        ['question' => 'And for cost $8.40, target margin 55%?', 'answer' => '$18.67. Profit: $10.27.'],
        ['question' => 'What does the result tell me?', 'answer' => 'A 40% margin needs a 66.7% markup.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="cost" label="Cost" value="60" step="0.01" suffix="$" />
        <x-calc.field name="margin" label="Target margin" value="40" step="any" suffix="%" />
    </div>

    <x-calc.result label="Selling price" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['cost' => 60, 'margin' => 40],
        'Example B' => ['cost' => 8.4, 'margin' => 55],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Profit'],
            'r2' => ['label' => 'Markup'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>price = cost ÷ (1 − margin)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
