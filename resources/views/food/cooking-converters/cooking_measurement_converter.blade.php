<x-calc.page
    title="Cooking Measurement Converter - SolveKit"
    description="Free cooking measurement converter: cups, tablespoons, teaspoons, millilitres, fluid ounces, grams, ounces and pounds for 200+ ingredients, with US, metric and Australian cups and spoons."
    lede="Convert any kitchen measure, by ingredient."
    about="Volume units convert exactly (1 US cup = 16 tbsp = 48 tsp = 236.6 ml; a metric cup is 250 ml; an Australian tablespoon is 20 ml). Converting volume to weight needs the ingredient's density. Cups measure volume, grams measure weight, so the conversion depends on the ingredient: a cup of flour weighs about 125 g, a cup of sugar 200 g and a cup of honey 339 g. Densities come from USDA FoodData Central household measures (SR Legacy) for 200+ ingredients. Flour varies most: spooned and levelled it is about 125 g a cup, scooped straight from the bag up to 150 g, so weigh it when the recipe matters."
    :calc="['engine' => 'fd-convert', 'tool' => 'measure', 'fields' => ['amount', 'ingredient', 'from', 'to'], 'data' => ['ingredients' => config('food_data.ingredients')]]"
    :how-to="[
        ['name' => 'Enter the amount and ingredient', 'text' => ''],
        ['name' => 'Choose the units', 'text' => 'Any volume or weight unit.'],
    ]"
    :faqs="[
        ['question' => 'How many grams is 1 cup of flour?', 'answer' => '1 cup of all-purpose flour = 125 g.'],
        ['question' => 'How many tablespoons is 50 g of sugar?', 'answer' => '50 g of granulated sugar = 4 tbsp.'],
        ['question' => 'How many ml in 1 cup of milk?', 'answer' => '1 cup of whole milk = 237 ml (a US cup is 236.6 ml).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="amount" label="Amount" value="1" min="0" step="any" />
        <x-calc.select name="ingredient" label="Ingredient" :options="collect(config('food_data.ingredients'))->filter(fn ($i) => isset($i['cup']))->groupBy('group', true)->mapWithKeys(fn ($items, $group) => [config('food_data.groups')[$group] => $items->map(fn ($i) => $i['name'])->all()])->all()" selected="flour_ap" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="from" label="From" :options="['Volume' => ['cup_us' => 'US cups', 'cup_label' => 'US nutrition-label cups (240 ml)', 'cup_metric' => 'Metric cups (250 ml)', 'cup_uk' => 'Imperial cups (284 ml)', 'tbsp_us' => 'Tablespoons (US, 14.8 ml)', 'tbsp_metric' => 'Tablespoons (15 ml)', 'tbsp_au' => 'Tablespoons (Australia, 20 ml)', 'tsp_us' => 'Teaspoons (US, 4.9 ml)', 'tsp_metric' => 'Teaspoons (5 ml)', 'floz_us' => 'US fluid ounces', 'floz_uk' => 'Imperial fluid ounces', 'ml' => 'Millilitres', 'l' => 'Litres', 'pint_us' => 'US pints', 'quart_us' => 'US quarts'], 'Weight' => ['g' => 'Grams', 'kg' => 'Kilograms', 'oz' => 'Ounces', 'lb' => 'Pounds']]" selected="cup_us" />
        <x-calc.select name="to" label="To" :options="['Volume' => ['cup_us' => 'US cups', 'cup_label' => 'US nutrition-label cups (240 ml)', 'cup_metric' => 'Metric cups (250 ml)', 'cup_uk' => 'Imperial cups (284 ml)', 'tbsp_us' => 'Tablespoons (US, 14.8 ml)', 'tbsp_metric' => 'Tablespoons (15 ml)', 'tbsp_au' => 'Tablespoons (Australia, 20 ml)', 'tsp_us' => 'Teaspoons (US, 4.9 ml)', 'tsp_metric' => 'Teaspoons (5 ml)', 'floz_us' => 'US fluid ounces', 'floz_uk' => 'Imperial fluid ounces', 'ml' => 'Millilitres', 'l' => 'Litres', 'pint_us' => 'US pints', 'quart_us' => 'US quarts'], 'Weight' => ['g' => 'Grams', 'kg' => 'Kilograms', 'oz' => 'Ounces', 'lb' => 'Pounds']]" selected="g" />
    </div>

    <x-calc.result label="Converted amount" />

    <x-calc.options :decimals="false" :examples="[
        'Flour' => ['amount' => 1, 'ingredient' => 'flour_ap', 'from' => 'cup_us', 'to' => 'g'],
        'Sugar' => ['amount' => 50, 'ingredient' => 'sugar', 'from' => 'g', 'to' => 'tbsp_us'],
        'Milk' => ['amount' => 1, 'ingredient' => 'milk', 'from' => 'cup_us', 'to' => 'ml'],
        'Rice, metric cups' => ['amount' => 2, 'ingredient' => 'rice_white', 'from' => 'cup_metric', 'to' => 'g'],
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
            <li>grams = ml × density</li>
            <li>1 US cup = 236.6 ml = 16 tbsp = 48 tsp</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
