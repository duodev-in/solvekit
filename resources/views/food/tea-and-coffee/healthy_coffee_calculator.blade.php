<x-calc.page
    title="Healthy Coffee Calculator - SolveKit"
    description="Free healthy coffee calculator: caffeine, calories and added sugar from your daily coffee, tea and soft drinks with milk, sugar and syrups, against FDA and AHA guidance."
    lede="Check the caffeine, calories and sugar in your drinks."
    about="Each drink adds caffeine and calories from the drink itself (USDA FoodData Central), milk (tablespoons × USDA density), sugar (4.2 g a teaspoon) and syrup (about 20 kcal and 5 g sugar a pump). The FDA cites 400 mg of caffeine a day as generally safe for healthy adults; the American Heart Association suggests no more than 25 g (women) or 36 g (men) of added sugar a day. General information, not medical advice."
    :calc="['engine' => 'fd-drinks', 'tool' => 'healthy_coffee', 'fields' => ['drinks', 'sex'], 'data' => ['ingredients' => config('food_data.ingredients')]]"
    :how-to="[
        ['name' => 'List your drinks', 'text' => 'Size in fl oz; espresso size is the number of shots.'],
        ['name' => 'Add milk, sugar and syrup', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How much caffeine and sugar is in my day?', 'answer' => '315 kcal and 55 g added sugar from 3 drinks; caffeine 301 mg.'],
        ['question' => 'What if I skip the syrup?', 'answer' => '275 kcal and 45 g added sugar from 3 drinks.'],
    ]"
>
    <x-calc.rows-editor name="drinks" label="Drinks a day (drink, fl oz, milk, milk tbsp, sugar tsp, syrup pumps)" :columns="['drink' => 'Drink', 'size' => 'fl oz', 'milk' => 'Milk', 'milk_tbsp' => 'Milk tbsp', 'sugar' => 'Sugar tsp', 'pumps' => 'Syrup pumps']" :rows="[['Brewed coffee', '12', 'Whole milk', '2', '2', '0'], ['Espresso (single shot)', '2', 'Reduced-fat milk (2%)', '8', '0', '2'], ['Cola', '12', 'none', '0', '0', '0']]" add-label="Add drink" :text="['drink', 'size', 'milk', 'milk_tbsp', 'sugar', 'pumps']" :lists="['drink' => ['Brewed coffee', 'Espresso (single shot)', 'Instant coffee (1 tsp)', 'Black tea', 'Green tea', 'Cola', 'Energy drink (Red Bull)', 'Dark chocolate (1 oz)'], 'milk' => ['none', 'Whole milk', 'Reduced-fat milk (2%)', 'Skim milk', 'Half-and-half', 'Heavy cream', 'Soy milk', 'Almond milk (unsweetened)', 'Coffee creamer (liquid)']]" />

    <x-calc.segmented name="sex" legend="Added sugar limit for" :options="['female' => 'Women (25 g)', 'male' => 'Men (36 g)']" selected="female" />

    <x-calc.result label="Caffeine a day" />

    <x-calc.options :decimals="false" :examples="[
        'My day' => ['drinks' => 'Brewed coffee	12	Whole milk	2	2	0
Espresso (single shot)	2	Reduced-fat milk (2%)	8	0	2
Cola	12	none	0	0	0', 'sex' => 'female'],
        'No syrup' => ['drinks' => 'Brewed coffee	12	Whole milk	2	2	0
Espresso (single shot)	2	Reduced-fat milk (2%)	8	0	0
Cola	12	none	0	0	0', 'sex' => 'female'],
        'Energy drinks' => ['drinks' => 'Energy drink (Red Bull)	8.4	none	0	0	0
Energy drink (Red Bull)	8.4	none	0	0	0', 'sex' => 'male'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'caffeine' => ['label' => 'Caffeine'],
            'kcal' => ['label' => 'Calories'],
            'sugar' => ['label' => 'Added sugar'],
            'sugarKcal' => ['label' => 'From added sugar'],
        ]" />
        <x-calc.grid heading="Drinks" name="drinks" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>caffeine = Σ drink g × USDA mg/100 g</li>
            <li>added sugar = sugar + syrup + soft-drink sugar</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
