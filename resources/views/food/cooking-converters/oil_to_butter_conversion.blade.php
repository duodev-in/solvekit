<x-calc.page
    title="Oil to Butter Conversion - SolveKit"
    description="Free oil to butter conversion: how much oil replaces butter in baking (¾ as much) and how much butter replaces oil, with the same-fat amount and the water to add back."
    lede="Swap butter for oil, or oil for butter."
    about="Butter is about 81% fat and 16% water (USDA); oil is all fat. The common kitchen rule is ¾ cup of oil for 1 cup of butter (and 1⅓ cups of butter for 1 cup of oil). Matching the fat exactly gives a little more oil; adding back the butter's water (about 2½ tablespoons per cup) keeps a batter's moisture. Oil makes cakes moister and denser; it cannot replace butter that must be creamed with sugar."
    :calc="['engine' => 'fd-convert', 'tool' => 'oil_butter', 'fields' => ['amount', 'unit', 'direction'], 'data' => ['ingredients' => config('food_data.ingredients')]]"
    :how-to="[
        ['name' => 'Enter the amount in the recipe', 'text' => ''],
        ['name' => 'Choose the direction', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How much oil replaces 1 cup of butter?', 'answer' => '¾ cup.'],
        ['question' => 'How much butter replaces ½ cup of oil?', 'answer' => '⅔ cup.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="amount" label="Amount" value="1" min="0" step="any" />
        <x-calc.select name="unit" label="Unit" :options="['cup_us' => 'US cups', 'tbsp_us' => 'Tablespoons', 'tsp_us' => 'Teaspoons', 'ml' => 'Millilitres', 'g' => 'Grams', 'oz' => 'Ounces']" selected="cup_us" />
        <x-calc.select name="direction" label="Convert" :options="['to_oil' => 'Butter to oil', 'to_butter' => 'Oil to butter']" selected="to_oil" />
    </div>

    <x-calc.result label="Oil to use" />

    <x-calc.options :decimals="false" :examples="[
        '1 cup butter' => ['amount' => 1, 'unit' => 'cup_us', 'direction' => 'to_oil'],
        '½ cup oil' => ['amount' => 0.5, 'unit' => 'cup_us', 'direction' => 'to_butter'],
        '200 g butter' => ['amount' => 200, 'unit' => 'g', 'direction' => 'to_oil'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'weight' => ['label' => 'Weight'],
            'sameFat' => ['label' => 'Same fat content'],
            'water' => ['label' => 'Water to add back'],
            'fat' => ['label' => 'Fat content'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>oil = butter × ¾ (kitchen rule)</li>
            <li>same fat: oil g = butter g × 0.81</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
