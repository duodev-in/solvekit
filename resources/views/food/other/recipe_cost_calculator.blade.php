<x-calc.page
    title="Recipe Cost Calculator - SolveKit"
    description="Free recipe cost calculator: the cost of a recipe and per serving from what you paid for each ingredient and how much you use, in your currency, with a selling price at your margin."
    lede="Find what a recipe costs per serving."
    about="Each ingredient costs price paid × amount used ÷ package size (use the same unit for both, such as grams). Add a small allowance for oil, salt and spices, divide by the servings, and for selling divide by (1 − margin)."
    :calc="['engine' => 'fd-nutrition', 'tool' => 'recipe_cost', 'fields' => ['items', 'servings', 'extra', 'margin']]"
    :how-to="[
        ['name' => 'List each ingredient', 'text' => 'What you paid, the package size and the amount used.'],
        ['name' => 'Enter the servings', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What does a pasta bake for 4 cost per serving?', 'answer' => '$3.56 ($14.25 for 4 servings).'],
        ['question' => 'Which ingredient costs most?', 'answer' => 'Ground beef: $6.49 (47.8% of ingredients).'],
    ]"
>
    <x-calc.rows-editor name="items" label="Ingredients (name, price paid, package size, amount used)" :columns="['name' => 'Ingredient', 'price' => 'Price paid', 'pack' => 'Package size', 'used' => 'Amount used']" :rows="[['Pasta', '1.89', '454', '340'], ['Ground beef', '6.49', '454', '454'], ['Marinara sauce', '3.29', '680', '680'], ['Parmesan', '4.99', '170', '40'], ['Onion and garlic', '1.20', '1', '1']]" add-label="Add ingredient" help="Package size and amount used in the same unit (g, ml or pieces)." :text="['name', 'price', 'pack', 'used']" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="servings" label="Servings" value="4" min="0" step="1" />
        <x-calc.field name="extra" label="Pantry allowance" value="5" min="0" step="any" suffix="%" />
        <x-calc.field name="margin" label="Margin (to sell)" value="0" min="0" max="95" step="any" suffix="%" />
    </div>

    <x-calc.result label="Cost per serving" />

    <x-calc.options :decimals="false" :examples="[
        'Pasta bake' => ['items' => 'Pasta	1.89	454	340
Ground beef	6.49	454	454
Marinara sauce	3.29	680	680
Parmesan	4.99	170	40
Onion and garlic	1.20	1	1', 'servings' => 4, 'extra' => 5, 'margin' => 0],
        'To sell' => ['items' => 'Pasta	1.89	454	340
Ground beef	6.49	454	454
Marinara sauce	3.29	680	680
Parmesan	4.99	170	40
Onion and garlic	1.20	1	1', 'servings' => 4, 'extra' => 5, 'margin' => 60],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'total' => ['label' => 'Total'],
            'top' => ['label' => 'Most expensive'],
            'extra' => ['label' => 'Allowance'],
            'price' => ['label' => 'Selling price'],
        ]" />
        <x-calc.grid heading="Ingredients" name="costs" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>cost = price × used ÷ package</li>
            <li>per serving = Σ cost × (1 + allowance) ÷ servings</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
