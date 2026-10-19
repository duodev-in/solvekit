<x-calc.page
    title="Self-rising Flour Calculator - SolveKit"
    description="Free self-rising flour calculator: make self-rising flour from all-purpose flour, baking powder and salt for any amount, in cups and grams."
    lede="Make self-rising flour at home."
    about="Self-rising flour is all-purpose flour with leavening and salt mixed in. The standard substitute is 1 cup all-purpose flour + 1½ teaspoons baking powder + ¼ teaspoon salt. Weights use USDA densities (125 g a cup of flour). UK self-raising flour is similar; some bakers use 2 tsp baking powder per 150 g."
    :calc="['engine' => 'fd-bake', 'tool' => 'self_rising', 'fields' => ['amount', 'unit'], 'data' => ['ingredients' => config('food_data.ingredients')]]"
    :how-to="[
        ['name' => 'Enter the self-rising flour in the recipe', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How do I make 2 cups of self-rising flour?', 'answer' => '2 cups all-purpose flour + 3 tsp baking powder + ½ tsp salt.'],
        ['question' => 'And 500 g?', 'answer' => '4 cups (500 g) + 6 tsp baking powder + 1 tsp salt.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="amount" label="Self-rising flour needed" value="2" min="0" step="any" />
        <x-calc.select name="unit" label="Unit" :options="['cup_us' => 'US cups', 'g' => 'Grams', 'oz' => 'Ounces']" selected="cup_us" />
    </div>

    <x-calc.result label="All-purpose flour" />

    <x-calc.options :decimals="false" :examples="[
        '2 cups' => ['amount' => 2, 'unit' => 'cup_us'],
        '500 g' => ['amount' => 500, 'unit' => 'g'],
        '1 cup' => ['amount' => 1, 'unit' => 'cup_us'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'flour' => ['label' => 'Flour'],
            'bp' => ['label' => 'Baking powder'],
            'salt' => ['label' => 'Salt'],
            'note' => ['label' => 'Tip'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>per cup: 1 cup flour + 1½ tsp baking powder + ¼ tsp salt</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
