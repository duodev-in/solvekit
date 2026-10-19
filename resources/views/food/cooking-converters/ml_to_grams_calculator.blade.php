<x-calc.page
    title="ml to Grams Calculator - SolveKit"
    description="Free ml to grams calculator: the weight of a volume of water, milk, oil, honey, flour, sugar and 200+ ingredients, using USDA densities."
    lede="Convert millilitres to grams by ingredient."
    about="Cups measure volume, grams measure weight, so the conversion depends on the ingredient: a cup of flour weighs about 125 g, a cup of sugar 200 g and a cup of honey 339 g. Densities come from USDA FoodData Central household measures (SR Legacy) for 200+ ingredients. Flour varies most: spooned and levelled it is about 125 g a cup, scooped straight from the bag up to 150 g, so weigh it when the recipe matters."
    :calc="['engine' => 'fd-convert', 'tool' => 'convert', 'fields' => ['amount', 'ingredient'], 'data' => ['ingredients' => config('food_data.ingredients')], 'from' => 'ml', 'to' => 'g']"
    :how-to="[
        ['name' => 'Enter the amount', 'text' => ''],
        ['name' => 'Choose the ingredient', 'text' => 'Densities differ: flour is light, honey heavy.'],
    ]"
    :faqs="[
        ['question' => 'How many grams is 100 ml of milk?', 'answer' => '100 ml of whole milk = 103 g.'],
        ['question' => 'And 100 ml of olive oil?', 'answer' => '100 ml of olive oil = 91.3 g.'],
        ['question' => 'Why is 1 ml of water 1 g?', 'answer' => 'Water\'s density is about 1 g per ml at room temperature; most other foods differ.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="amount" label="Millilitres" value="100" min="0" step="any" />
        <x-calc.select name="ingredient" label="Ingredient" :options="collect(config('food_data.ingredients'))->filter(fn ($i) => isset($i['cup']))->groupBy('group', true)->mapWithKeys(fn ($items, $group) => [config('food_data.groups')[$group] => $items->map(fn ($i) => $i['name'])->all()])->all()" selected="milk" />
    </div>

    <x-calc.result label="Grams" />

    <x-calc.options :decimals="false" :examples="[
        'Milk' => ['amount' => 100, 'ingredient' => 'milk'],
        'Olive oil' => ['amount' => 100, 'ingredient' => 'oil_olive'],
        'Honey' => ['amount' => 100, 'ingredient' => 'honey'],
        'Water' => ['amount' => 250, 'ingredient' => 'water'],
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
