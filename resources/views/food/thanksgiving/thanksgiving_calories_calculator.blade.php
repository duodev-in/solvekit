<x-calc.page
    title="Thanksgiving Calories Calculator - SolveKit"
    description="Free Thanksgiving calories calculator: calories, protein, fat and carbohydrate in your holiday plate, dish by dish, from USDA data, and how long a walk it takes to use them."
    lede="Count the calories in your Thanksgiving plate."
    about="Each dish's portion is turned into grams with USDA household measures (a cup of mashed potatoes is 210 g, a slice of pumpkin pie 155 g) and multiplied by its nutrients per 100 g from USDA FoodData Central. Walking minutes use 3.5 METs for walking at about 3 mph (Compendium of Physical Activities): kcal a minute = METs × 3.5 × body weight in kg ÷ 200. Recipes differ, so treat totals as estimates. General information, not medical advice."
    :calc="['engine' => 'fd-nutrition', 'tool' => 'nutrition', 'fields' => ['items', 'servings', 'weight'], 'data' => ['ingredients' => config('food_data.ingredients')], 'label' => 'Calories']"
    :how-to="[
        ['name' => 'List what is on your plate', 'text' => 'Amount, unit and dish.'],
        ['name' => 'Enter your weight', 'text' => 'For the walking time.'],
    ]"
    :faqs="[
        ['question' => 'How many calories in a typical Thanksgiving plate?', 'answer' => '1,303 kcal for turkey, potatoes, stuffing, gravy, cranberry, green beans, a roll and pie.'],
        ['question' => 'How long a walk is that?', 'answer' => '304 minutes of walking at 3 mph for 70 kg.'],
    ]"
>
    <x-calc.rows-editor name="items" label="Your plate (amount, unit, dish)" :columns="['amount' => 'Amount', 'unit' => 'Unit', 'name' => 'Dish or food']" :rows="[['6', 'oz', 'Turkey, meat and skin (roasted)'], ['1', 'cup', 'Mashed potatoes (milk and butter)'], ['1/2', 'cup', 'Stuffing (prepared)'], ['1/4', 'cup', 'Turkey gravy'], ['1/4', 'cup', 'Cranberry sauce (canned)'], ['1/2', 'cup', 'Green beans (cooked)'], ['1', 'roll', 'Dinner roll'], ['1', 'slice', 'Pumpkin pie']]" add-label="Add dish" :text="['amount', 'unit', 'name']" :lists="['unit' => ['cup', 'tbsp', 'tsp', 'g', 'kg', 'oz', 'lb', 'ml', 'l', 'fl oz', 'stick', 'pinch', 'large', 'clove', 'slice', 'roll', 'piece'], 'name' => collect(config('food_data.ingredients'))->pluck('name')->values()->all()]" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="servings" label="Plates (to divide by)" value="1" min="0" step="1" />
        <x-calc.field name="weight" label="Your weight" value="70" min="0" step="any" suffix="kg" />
    </div>

    <x-calc.result label="Calories" />

    <x-calc.options :decimals="false" :examples="[
        'Classic plate' => ['items' => '6	oz	Turkey, meat and skin (roasted)
1	cup	Mashed potatoes (milk and butter)
1/2	cup	Stuffing (prepared)
1/4	cup	Turkey gravy
1/4	cup	Cranberry sauce (canned)
1/2	cup	Green beans (cooked)
1	roll	Dinner roll
1	slice	Pumpkin pie', 'servings' => 1, 'weight' => 70],
        'Seconds and pecan pie' => ['items' => '10	oz	Turkey, meat and skin (roasted)
1	cup	Mashed potatoes (milk and butter)
1/2	cup	Stuffing (prepared)
1/4	cup	Turkey gravy
1/4	cup	Cranberry sauce (canned)
1/2	cup	Green beans (cooked)
1	roll	Dinner roll
1	slice	Pecan pie', 'servings' => 1, 'weight' => 80],
        'Lighter plate' => ['items' => '5	oz	Turkey, meat only (roasted)
1	cup	Green beans (cooked)
1/2	cup	Sweet potato (baked)
2	tbsp	Cranberry sauce (canned)', 'servings' => 1, 'weight' => 65],
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
        <x-calc.grid heading="Dishes" name="foods" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>kcal = Σ grams × kcal per 100 g ÷ 100</li>
            <li>walking kcal/min = 3.5 × 3.5 × kg ÷ 200</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
