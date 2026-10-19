<x-calc.page
    title="Recipe Nutrition Calculator - SolveKit"
    description="Free recipe nutrition calculator: calories, protein, fat, carbohydrate, fibre, sugars and sodium per serving of a recipe, with % Daily Values, from USDA FoodData Central."
    lede="Work out the nutrition of a recipe per serving."
    about="Each ingredient's amount is turned into grams with USDA household measures, multiplied by its nutrients per 100 g and added up, then divided by the servings. % Daily Values use the FDA reference amounts for a 2,000-calorie diet. Cooking changes water content but not calories much, so the per-serving totals hold for the cooked dish. General information, not medical advice."
    :calc="['engine' => 'fd-nutrition', 'tool' => 'nutrition', 'fields' => ['items', 'servings', 'weight'], 'data' => ['ingredients' => config('food_data.ingredients')], 'label' => 'Calories per serving']"
    :how-to="[
        ['name' => 'List the foods', 'text' => 'Amount, unit and food; pick names from the list.'],
        ['name' => 'Enter the servings', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How many calories per slice of a simple butter cake cut into 12?', 'answer' => '233 kcal.'],
        ['question' => 'How much protein?', 'answer' => '3.92 g (8% DV).'],
    ]"
>
    <x-calc.rows-editor name="items" label="Ingredients (amount, unit, food)" :columns="['amount' => 'Amount', 'unit' => 'Unit', 'name' => 'Food']" :rows="[['2', 'cup', 'All-purpose flour'], ['1', 'cup', 'Granulated sugar'], ['1/2', 'cup', 'Butter (salted)'], ['2', 'large', 'Egg (whole, raw)'], ['1', 'cup', 'Whole milk'], ['2', 'tsp', 'Baking powder']]" add-label="Add food" :text="['amount', 'unit', 'name']" :lists="['unit' => ['cup', 'tbsp', 'tsp', 'g', 'kg', 'oz', 'lb', 'ml', 'l', 'fl oz', 'stick', 'pinch', 'large', 'clove', 'slice'], 'name' => collect(config('food_data.ingredients'))->pluck('name')->values()->all()]" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="servings" label="Servings" value="12" min="0" step="1" />
        <x-calc.field name="weight" label="Your weight (for walking)" value="70" min="0" step="any" suffix="kg" />
    </div>

    <x-calc.result label="Calories per serving" />

    <x-calc.options :decimals="false" :examples="[
        'Butter cake' => ['items' => '2	cup	All-purpose flour
1	cup	Granulated sugar
1/2	cup	Butter (salted)
2	large	Egg (whole, raw)
1	cup	Whole milk
2	tsp	Baking powder', 'servings' => 12, 'weight' => 70],
        'Pasta dinner' => ['items' => '12	oz	Pasta, elbow macaroni (dry)
1	lb	Ground beef 80/20 (cooked)
3	cup	Marinara sauce
1/2	cup	Parmesan (grated)', 'servings' => 4, 'weight' => 70],
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
