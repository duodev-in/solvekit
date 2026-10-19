<x-calc.page
    title="Markup Calculator - SolveKit"
    description="Free Markup Calculator: price = cost × (1 + markup). Markup is profit as a percentage of cost."
    lede="Work out the selling price from cost and markup."
    about="Markup is profit as a percentage of cost. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'markup', 'fields' => ['cost', 'markup']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Cost, Markup.'],
        ['name' => 'Read the result', 'text' => 'The selling price appears as you type, with profit, margin below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the selling price?', 'answer' => 'Price = cost × (1 + markup).'],
        ['question' => 'What is the selling price for cost $60, markup 50%?', 'answer' => '$90.00. Profit: $30.00.'],
        ['question' => 'And for cost $12.50, markup 120%?', 'answer' => '$27.50. Profit: $15.00.'],
        ['question' => 'What does the result tell me?', 'answer' => '50% markup is a 33.3% margin.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="cost" label="Cost" value="60" step="0.01" suffix="$" />
        <x-calc.field name="markup" label="Markup" value="50" step="any" suffix="%" />
    </div>

    <x-calc.result label="Selling price" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['cost' => 60, 'markup' => 50],
        'Example B' => ['cost' => 12.5, 'markup' => 120],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Profit'],
            'r2' => ['label' => 'Margin'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>price = cost × (1 + markup)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
