@php
    $groups = config('foods');
    $foods = collect($groups)->flatMap(fn ($group) => $group['items'])->all();
    $weightUnits = collect(config('units.mass'))->only(['g', 'kg', 'oz', 'lb'])->all();
    $options = collect($groups)->mapWithKeys(fn ($group) => [$group['label'] => collect($group['items'])->map(fn ($food) => $food['name'])->all()])->all()
        + ['Other' => ['custom' => 'Custom (enter kcal per 100 g)']];
@endphp

<x-calc.page
    title="Grams to Calories Calculator - SolveKit"
    description="Professional grams to calories calculator for food weight to energy conversion. Calculate nutritional values, macronutrients, and energy content for diet planning and nutrition tracking."
    lede="Find the calories and macronutrients in a weight of food."
    about="Calories scale with weight: the food's energy per 100 g times your weight ÷ 100. Values are averages from USDA FoodData Central; brands and cooking methods vary, so use the label on your food when you have it, or pick Custom and enter its kcal per 100 g."
    :calc="['engine' => 'grams-calories', 'foods' => $foods, 'weightUnits' => $weightUnits, 'compare' => ['rice', 'chicken', 'egg', 'banana', 'cheddar', 'almonds', 'olive_oil', 'broccoli']]"
    :how-to="[
        ['name' => 'Pick the food', 'text' => 'Or choose Custom and enter the kcal per 100 g from the label.'],
        ['name' => 'Enter the weight', 'text' => 'In grams, kilograms, ounces or pounds.'],
    ]"
    :faqs="[
        ['question' => 'How many calories are in 100 g of cooked rice?', 'answer' => 'About 130 kcal for cooked white rice.'],
        ['question' => 'Are food Calories the same as kcal?', 'answer' => 'Yes. Food labels write Calories (capital C) for kilocalories. 1 kcal = 4.184 kJ.'],
        ['question' => 'How many calories per gram of fat, protein and carbohydrate?', 'answer' => 'About 9 kcal for fat and 4 kcal each for protein and carbohydrate.'],
    ]"
>
    <x-calc.select name="food" label="Food" :options="$options" selected="rice" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="weight" label="Weight" value="150" min="0" placeholder="Weight">
            <label for="calc-weight-unit" class="sr-only">Weight unit</label>
            <select id="calc-weight-unit" name="weight-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach($weightUnits as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'g')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <div data-show-when="food:custom" hidden><x-calc.field name="custom-kcal" label="kcal per 100 g" value="250" min="0" placeholder="From the label" /></div>
    </div>

    <x-calc.result label="Calories" />

    <x-calc.options :examples="[
        'Banana 120 g' => ['food' => 'banana', 'weight' => 120],
        'Chicken 6 oz' => ['food' => 'chicken', 'weight' => 6, 'weight-unit' => 'oz'],
        'Almonds 28 g' => ['food' => 'almonds', 'weight' => 28],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Nutrition" :rows="[
            'kj' => ['label' => 'Energy', 'unit' => 'kJ'],
            'per100' => ['label' => 'Per 100 g'],
            'carbs' => ['label' => 'Carbohydrate'],
            'protein' => ['label' => 'Protein'],
            'fat' => ['label' => 'Fat'],
            'daily' => ['label' => 'Share of 2,000 kcal day'],
        ]" />
        <x-calc.quick-ref heading="Same weight of other foods" name="compare" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>kcal = grams × kcal per 100 g ÷ 100</li>
            <li>kJ = kcal × 4.184</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
