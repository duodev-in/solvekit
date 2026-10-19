<x-calc.page
    title="Meal Calorie Calculator - SolveKit"
    description="Free meal calorie calculator: calories, protein, fat and carbs in a meal from its foods and amounts, using USDA FoodData Central."
    lede="Count the calories in a meal."
    about="Each food's amount is converted to grams with USDA household measures and multiplied by its USDA nutrients per 100 g; % Daily Values use the FDA reference amounts for 2,000 kcal. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'fd-nutrition', 'tool' => 'nutrition', 'fields' => ['items', 'servings', 'weight'], 'data' => ['ingredients' => config('food_data.ingredients')], 'label' => 'Meal calories']"
    :how-to="[
        ['name' => 'List the foods', 'text' => 'Pick names from the list.'],
        ['name' => 'Read the totals', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How many calories are in 2 eggs, 2 slices of toast with butter and a glass of milk?', 'answer' => '555 kcal.'],
    ]"
>
    <x-calc.rows-editor name="items" label="Foods (amount, unit, food)" :columns="['amount' => 'Amount', 'unit' => 'Unit', 'name' => 'Food']" :rows="[['2', 'large', 'Egg (whole, raw)'], ['2', 'slice', 'Whole-wheat bread'], ['1', 'tbsp', 'Butter (salted)'], ['1', 'cup', 'Whole milk']]" add-label="Add food" :text="['amount', 'unit', 'name']" :lists="['unit' => ['cup', 'tbsp', 'tsp', 'g', 'oz', 'large', 'slice'], 'name' => collect(config('food_data.ingredients'))->pluck('name')->values()->all()]" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="servings" label="People sharing" value="1" min="0" step="1" />
        <x-calc.field name="weight" label="Your weight (for walking)" value="70" min="0" step="any" suffix="kg" />
    </div>

    <x-calc.result label="Meal calories" />

    <x-calc.options :decimals="false" :examples="[
        'Breakfast' => ['items' => '2	large	Egg (whole, raw)
2	slice	Whole-wheat bread
1	tbsp	Butter (salted)
1	cup	Whole milk', 'servings' => 1, 'weight' => 70],
        'Lunch' => ['items' => '1	cup	White rice, long-grain (cooked)
4	oz	Chicken breast (roasted)
1	cup	Broccoli (chopped)', 'servings' => 1, 'weight' => 70],
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
            <li>kcal = Σ grams × kcal per 100 g ÷ 100</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
