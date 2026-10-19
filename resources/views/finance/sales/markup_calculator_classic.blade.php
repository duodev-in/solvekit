<x-calc.page
    title="Markup Calculator Classic - SolveKit"
    description="Free Markup Calculator Classic: markup = (price − cost) ÷ cost. The classic markup from cost and price."
    lede="Work out the markup from cost and selling price."
    about="The classic markup from cost and price. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'markup_calculator_classic', 'fields' => ['cost', 'price']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Cost, Selling price.'],
        ['name' => 'Read the result', 'text' => 'The markup appears as you type, with margin, profit below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the markup?', 'answer' => 'Markup = (price − cost) ÷ cost.'],
        ['question' => 'What is the markup for cost $40, selling price $65?', 'answer' => '62.5%. Margin: 38.46%.'],
        ['question' => 'And for cost $18, selling price $29.99?', 'answer' => '66.61%. Margin: 39.98%.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Markup is always higher than margin for the same item.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="cost" label="Cost" value="40" step="0.01" suffix="$" />
        <x-calc.field name="price" label="Selling price" value="65" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Markup" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['cost' => 40, 'price' => 65],
        'Example B' => ['cost' => 18, 'price' => 29.99],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Margin'],
            'r2' => ['label' => 'Profit'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>markup = (price − cost) ÷ cost</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
