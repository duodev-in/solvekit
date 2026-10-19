<x-calc.page
    title="Grams to Teaspoons Converter - SolveKit"
    description="Free grams to teaspoons converter for salt, sugar, baking powder, yeast, spices and 200+ ingredients, using USDA densities."
    lede="Convert grams to teaspoons by ingredient."
    about="Cups measure volume, grams measure weight, so the conversion depends on the ingredient: a cup of flour weighs about 125 g, a cup of sugar 200 g and a cup of honey 339 g. Densities come from USDA FoodData Central household measures (SR Legacy) for 200+ ingredients. Flour varies most: spooned and levelled it is about 125 g a cup, scooped straight from the bag up to 150 g, so weigh it when the recipe matters."
    :calc="['engine' => 'fd-convert', 'tool' => 'convert', 'fields' => ['amount', 'ingredient', 'standard'], 'data' => ['ingredients' => config('food_data.ingredients')], 'from' => 'g', 'to' => 'tsp']"
    :how-to="[
        ['name' => 'Enter the amount', 'text' => ''],
        ['name' => 'Choose the ingredient', 'text' => 'Densities differ: flour is light, honey heavy.'],
        ['name' => 'Pick the cup or spoon size', 'text' => 'US, metric (250 ml) or Australian (20 ml tablespoon).'],
    ]"
    :faqs="[
        ['question' => 'How many teaspoons is 5 g of salt?', 'answer' => '5 g of table salt = 0.82 tsp.'],
        ['question' => 'How many teaspoons is 10 g of baking powder?', 'answer' => '10 g of baking powder = 2⅛ tsp (2.17).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="amount" label="Grams" value="5" min="0" step="any" />
        <x-calc.select name="ingredient" label="Ingredient" :options="collect(config('food_data.ingredients'))->filter(fn ($i) => isset($i['cup']))->groupBy('group', true)->mapWithKeys(fn ($items, $group) => [config('food_data.groups')[$group] => $items->map(fn ($i) => $i['name'])->all()])->all()" selected="salt" />
    </div>

    <x-calc.select name="standard" label="Spoon size" :options="['tsp_us' => 'US teaspoon (4.9 ml)', 'tsp_metric' => 'Metric teaspoon (5 ml)']" selected="tsp_us" />

    <x-calc.result label="Teaspoons" />

    <x-calc.options :decimals="false" :examples="[
        'Salt' => ['amount' => 5, 'ingredient' => 'salt', 'standard' => 'tsp_us'],
        'Baking powder' => ['amount' => 10, 'ingredient' => 'baking_powder', 'standard' => 'tsp_us'],
        'Sugar' => ['amount' => 10, 'ingredient' => 'sugar', 'standard' => 'tsp_us'],
        'Cinnamon' => ['amount' => 3, 'ingredient' => 'cinnamon', 'standard' => 'tsp_metric'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'grams' => ['label' => 'Grams'],
            'ounces' => ['label' => 'Ounces'],
            'cups' => ['label' => 'US cups'],
            'tbsp' => ['label' => 'Tablespoons'],
            'reverse' => ['label' => 'Reverse'],
            'density' => ['label' => 'Density used'],
        ]" />
        <x-calc.grid heading="Equivalents" name="equivalents" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>grams = volume (ml) × density (g/ml)</li>
            <li>density = USDA grams per cup ÷ 236.6 ml</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
