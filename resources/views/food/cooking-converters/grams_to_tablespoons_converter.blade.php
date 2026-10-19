<x-calc.page
    title="Grams to Tablespoons Converter - SolveKit"
    description="Free grams to tablespoons converter for butter, sugar, flour, oil, honey, cocoa and 200+ ingredients, with US (14.8 ml), metric (15 ml) and Australian (20 ml) tablespoons."
    lede="Convert grams to tablespoons by ingredient."
    about="Cups measure volume, grams measure weight, so the conversion depends on the ingredient: a cup of flour weighs about 125 g, a cup of sugar 200 g and a cup of honey 339 g. Densities come from USDA FoodData Central household measures (SR Legacy) for 200+ ingredients. Flour varies most: spooned and levelled it is about 125 g a cup, scooped straight from the bag up to 150 g, so weigh it when the recipe matters."
    :calc="['engine' => 'fd-convert', 'tool' => 'convert', 'fields' => ['amount', 'ingredient', 'standard'], 'data' => ['ingredients' => config('food_data.ingredients')], 'from' => 'g', 'to' => 'tbsp']"
    :how-to="[
        ['name' => 'Enter the amount', 'text' => ''],
        ['name' => 'Choose the ingredient', 'text' => 'Densities differ: flour is light, honey heavy.'],
        ['name' => 'Pick the cup or spoon size', 'text' => 'US, metric (250 ml) or Australian (20 ml tablespoon).'],
    ]"
    :faqs="[
        ['question' => 'How many tablespoons is 30 g of butter?', 'answer' => '30 g of butter (salted) = 2⅛ tbsp (2.11).'],
        ['question' => 'How many tablespoons is 25 g of sugar?', 'answer' => '25 g of granulated sugar = 2 tbsp.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="amount" label="Grams" value="30" min="0" step="any" />
        <x-calc.select name="ingredient" label="Ingredient" :options="collect(config('food_data.ingredients'))->filter(fn ($i) => isset($i['cup']))->groupBy('group', true)->mapWithKeys(fn ($items, $group) => [config('food_data.groups')[$group] => $items->map(fn ($i) => $i['name'])->all()])->all()" selected="butter" />
    </div>

    <x-calc.select name="standard" label="Spoon size" :options="['tbsp_us' => 'US tablespoon (14.8 ml)', 'tbsp_metric' => 'Metric tablespoon (15 ml)', 'tbsp_au' => 'Australian tablespoon (20 ml)']" selected="tbsp_us" />

    <x-calc.result label="Tablespoons" />

    <x-calc.options :decimals="false" :examples="[
        'Butter' => ['amount' => 30, 'ingredient' => 'butter', 'standard' => 'tbsp_us'],
        'Sugar' => ['amount' => 25, 'ingredient' => 'sugar', 'standard' => 'tbsp_us'],
        'Cocoa' => ['amount' => 20, 'ingredient' => 'cocoa', 'standard' => 'tbsp_us'],
        'Honey, Australian tbsp' => ['amount' => 42, 'ingredient' => 'honey', 'standard' => 'tbsp_au'],
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
