<x-calc.page
    title="Salad Calories Calculator - SolveKit"
    description="Free salad calories calculator: calories, protein, fat, carbohydrate and fibre of your salad from its greens, vegetables, toppings and dressing, using USDA data."
    lede="Count the calories in your salad."
    about="Salads are often low in calories until the toppings and dressing: 2 tablespoons of Caesar dressing can add more energy than the greens. Each ingredient's amount is turned into grams with USDA household measures (a cup of shredded romaine is 47 g) and multiplied by its USDA nutrients per 100 g. General information, not medical advice."
    :calc="['engine' => 'fd-nutrition', 'tool' => 'nutrition', 'fields' => ['items', 'servings', 'weight'], 'data' => ['ingredients' => config('food_data.ingredients')], 'label' => 'Salad calories']"
    :how-to="[
        ['name' => 'List the foods', 'text' => 'Amount, unit and food; pick names from the list.'],
        ['name' => 'Enter the servings', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How many calories in a Caesar-style salad with feta and croutons?', 'answer' => '389 kcal.'],
        ['question' => 'How much of that is the dressing?', 'answer' => 'Compare with 230 kcal without it.'],
    ]"
>
    <x-calc.rows-editor name="items" label="Ingredients (amount, unit, food)" :columns="['amount' => 'Amount', 'unit' => 'Unit', 'name' => 'Food']" :rows="[['2', 'cup', 'Romaine lettuce (shredded)'], ['1/2', 'cup', 'Cherry tomatoes'], ['1/2', 'cup', 'Cucumber (sliced)'], ['1/4', 'cup', 'Feta (crumbled)'], ['1/2', 'cup', 'Croutons (seasoned)'], ['2', 'tbsp', 'Caesar dressing']]" add-label="Add food" :text="['amount', 'unit', 'name']" :lists="['unit' => ['cup', 'tbsp', 'tsp', 'g', 'kg', 'oz', 'lb', 'ml', 'l', 'fl oz', 'stick', 'pinch', 'large', 'clove', 'slice'], 'name' => collect(config('food_data.ingredients'))->pluck('name')->values()->all()]" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="servings" label="Servings" value="1" min="0" step="1" />
        <x-calc.field name="weight" label="Your weight (for walking)" value="70" min="0" step="any" suffix="kg" />
    </div>

    <x-calc.result label="Salad calories" />

    <x-calc.options :decimals="false" :examples="[
        'Caesar style' => ['items' => '2	cup	Romaine lettuce (shredded)
1/2	cup	Cherry tomatoes
1/2	cup	Cucumber (sliced)
1/4	cup	Feta (crumbled)
1/2	cup	Croutons (seasoned)
2	tbsp	Caesar dressing', 'servings' => 1, 'weight' => 70],
        'No dressing' => ['items' => '2	cup	Romaine lettuce (shredded)
1/2	cup	Cherry tomatoes
1/2	cup	Cucumber (sliced)
1/4	cup	Feta (crumbled)
1/2	cup	Croutons (seasoned)', 'servings' => 1, 'weight' => 70],
        'Chicken salad bowl' => ['items' => '3	cup	Spinach (raw)
4	oz	Chicken breast (roasted)
1/2	cup	Avocado (cubed)
1/4	cup	Corn
2	tbsp	Italian dressing', 'servings' => 1, 'weight' => 70],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'protein' => ['label' => 'Protein'],
            'fat' => ['label' => 'Fat'],
            'carbs' => ['label' => 'Carbohydrate'],
            'fiber' => ['label' => 'Fibre'],
            'sugar' => ['label' => 'Sugars'],
            'sodium' => ['label' => 'Sodium'],
            'walk' => ['label' => 'Walking'],
            'missing' => ['label' => 'Not counted'],
        ]" />
        <x-calc.grid heading="Foods" name="foods" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>nutrient = Σ grams × value per 100 g ÷ 100</li>
            <li>% DV against FDA Daily Values (2,000 kcal)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
