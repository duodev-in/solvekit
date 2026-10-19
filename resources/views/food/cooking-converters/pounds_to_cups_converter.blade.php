<x-calc.page
    title="Pounds to Cups Converter - SolveKit"
    description="Free pounds to cups converter: how many cups in a pound of flour, sugar, butter, rice and 200+ ingredients, using USDA densities."
    lede="Convert pounds to cups by ingredient."
    about="Cups measure volume, grams measure weight, so the conversion depends on the ingredient: a cup of flour weighs about 125 g, a cup of sugar 200 g and a cup of honey 339 g. Densities come from USDA FoodData Central household measures (SR Legacy) for 200+ ingredients. Flour varies most: spooned and levelled it is about 125 g a cup, scooped straight from the bag up to 150 g, so weigh it when the recipe matters."
    :calc="['engine' => 'fd-convert', 'tool' => 'convert', 'fields' => ['amount', 'ingredient', 'standard'], 'data' => ['ingredients' => config('food_data.ingredients')], 'from' => 'lb', 'to' => 'cup']"
    :how-to="[
        ['name' => 'Enter the amount', 'text' => ''],
        ['name' => 'Choose the ingredient', 'text' => 'Densities differ: flour is light, honey heavy.'],
        ['name' => 'Pick the cup or spoon size', 'text' => 'US, metric (250 ml) or Australian (20 ml tablespoon).'],
    ]"
    :faqs="[
        ['question' => 'How many cups in a pound of flour?', 'answer' => '1 lb of all-purpose flour = 3⅝ cups.'],
        ['question' => 'How many cups in a pound of sugar?', 'answer' => '1 lb of granulated sugar = 2¼ cups (2.27).'],
        ['question' => 'And a 5 lb bag of flour?', 'answer' => '5 lb of all-purpose flour = 18⅛ cups (18.1).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="amount" label="Pounds" value="1" min="0" step="any" />
        <x-calc.select name="ingredient" label="Ingredient" :options="collect(config('food_data.ingredients'))->filter(fn ($i) => isset($i['cup']))->groupBy('group', true)->mapWithKeys(fn ($items, $group) => [config('food_data.groups')[$group] => $items->map(fn ($i) => $i['name'])->all()])->all()" selected="flour_ap" />
    </div>

    <x-calc.select name="standard" label="Cup size" :options="['cup_us' => 'US cup (236.6 ml)', 'cup_label' => 'US nutrition-label cup (240 ml)', 'cup_metric' => 'Metric cup (250 ml)', 'cup_uk' => 'Imperial cup (284 ml)']" selected="cup_us" />

    <x-calc.result label="Cups" />

    <x-calc.options :decimals="false" :examples="[
        'Flour' => ['amount' => 1, 'ingredient' => 'flour_ap', 'standard' => 'cup_us'],
        'Sugar' => ['amount' => 1, 'ingredient' => 'sugar', 'standard' => 'cup_us'],
        '5 lb flour' => ['amount' => 5, 'ingredient' => 'flour_ap', 'standard' => 'cup_us'],
        'Brown sugar' => ['amount' => 1, 'ingredient' => 'sugar_brown_packed', 'standard' => 'cup_us'],
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
