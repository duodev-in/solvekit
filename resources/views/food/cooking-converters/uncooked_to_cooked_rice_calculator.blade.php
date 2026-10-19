<x-calc.page
    title="Uncooked to Cooked Rice Calculator - SolveKit"
    description="Free uncooked to cooked rice calculator: cooked cups and grams from dry rice by type (long-grain, basmati, jasmine, brown, parboiled, wild), the water to use and servings."
    lede="Find how much cooked rice dry rice makes."
    about="Rice absorbs water as it cooks. The yield here comes from USDA FoodData Central: the energy per 100 g of raw and cooked rice gives the weight gain (white long-grain about 2.8 ×, so 1 cup dry ≈ 3¼ cups cooked), and USDA cup weights turn it into cups. Water amounts are typical stovetop ratios from the USA Rice Federation and package directions; rice cookers and Instant Pots need less. Basmati and jasmine use white long-grain yields."
    :calc="['engine' => 'fd-convert', 'tool' => 'rice_cooked', 'fields' => ['amount', 'unit', 'type'], 'data' => ['ingredients' => config('food_data.ingredients')]]"
    :how-to="[
        ['name' => 'Enter the dry rice', 'text' => ''],
        ['name' => 'Choose the type', 'text' => 'Yields and water differ.'],
    ]"
    :faqs="[
        ['question' => 'How much cooked rice does 1 cup of dry rice make?', 'answer' => '3¼ cups (519 g (18.3 oz)).'],
        ['question' => 'How much does 1 cup of brown rice make?', 'answer' => '2¾ cups.'],
        ['question' => 'How much dry rice for 6 cups cooked?', 'answer' => 'About 2 cups (370 g) uncooked basmati (white long-grain values) → 1,039 g cooked.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="amount" label="Uncooked rice" value="1" min="0" step="any" />
        <x-calc.select name="unit" label="Unit" :options="['cup_us' => 'US cups', 'cup_metric' => 'Metric cups', 'g' => 'Grams', 'kg' => 'Kilograms', 'oz' => 'Ounces', 'lb' => 'Pounds']" selected="cup_us" />
        <x-calc.select name="type" label="Rice" :options="['long' => 'White long-grain', 'basmati' => 'Basmati', 'jasmine' => 'Jasmine', 'medium' => 'White medium-grain', 'short' => 'Short-grain (sushi)', 'brown' => 'Brown long-grain', 'parboiled' => 'Parboiled (converted)', 'wild' => 'Wild rice']" selected="long" />
    </div>

    <x-calc.result label="Cooked rice" />

    <x-calc.options :decimals="false" :examples="[
        '1 cup white' => ['amount' => 1, 'unit' => 'cup_us', 'type' => 'long'],
        '1 cup brown' => ['amount' => 1, 'unit' => 'cup_us', 'type' => 'brown'],
        '2 cups basmati' => ['amount' => 2, 'unit' => 'cup_us', 'type' => 'basmati'],
        '500 g wild' => ['amount' => 500, 'unit' => 'g', 'type' => 'wild'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'grams' => ['label' => 'Cooked weight'],
            'water' => ['label' => 'Water'],
            'ratio' => ['label' => 'Rice to water'],
            'servings' => ['label' => 'Servings'],
            'yield' => ['label' => 'Yield'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>cooked g = dry g × kcal(raw) ÷ kcal(cooked)</li>
            <li>cooked cups = cooked g ÷ USDA g per cup</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
