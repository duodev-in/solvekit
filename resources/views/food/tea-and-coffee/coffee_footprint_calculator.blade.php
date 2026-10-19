<x-calc.page
    title="Coffee Footprint Calculator - SolveKit"
    description="Free coffee footprint calculator: the greenhouse gas emissions of your coffee a year and a cup, from the coffee, milk and sugar, using Poore & Nemecek (2018) food footprints."
    lede="Estimate the carbon footprint of your coffee."
    about="Coffee is one of the higher-footprint foods per kilogram: about 28.5 kg CO₂e per kg of coffee (Poore & Nemecek 2018, via Our World in Data, farm to retail), mostly from farming and land use. A cup uses 10–20 g, so the coffee itself is a few hundred grams of CO₂e a cup, and dairy milk can add as much again (3.15 kg CO₂e per litre; soy milk 0.98). Brewing energy and cups are not included."
    :calc="['engine' => 'fd-drinks', 'tool' => 'coffee_footprint', 'fields' => ['cups', 'grams', 'milk', 'milk_ml', 'sugar'], 'data' => ['eco' => config('ecology_data.food')]]"
    :how-to="[
        ['name' => 'Enter cups and coffee per cup', 'text' => ''],
        ['name' => 'Choose milk and sugar', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the footprint of 2 cups a day with milk?', 'answer' => '398 kg CO₂e a year a year: 545 g CO₂e a cup (Poore & Nemecek 2018, farm to retail).'],
        ['question' => 'How much does switching to soy milk save?', 'answer' => '303 kg CO₂e a year a year instead.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="cups" label="Cups a day" value="2" min="0" step="any" />
        <x-calc.field name="grams" label="Coffee per cup" value="12" min="0" step="any" suffix="g" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.select name="milk" label="Milk" :options="['none' => 'None (black)', 'dairy' => 'Dairy milk', 'soy' => 'Soy milk']" selected="dairy" />
        <x-calc.field name="milk_ml" label="Milk per cup" value="60" min="0" step="any" suffix="ml" />
        <x-calc.field name="sugar" label="Sugar per cup" value="1" min="0" step="any" suffix="tsp" />
    </div>

    <x-calc.result label="Footprint of your coffee" />

    <x-calc.options :decimals="false" :examples="[
        'With milk' => ['cups' => 2, 'grams' => 12, 'milk' => 'dairy', 'milk_ml' => 60, 'sugar' => 1],
        'Black' => ['cups' => 2, 'grams' => 12, 'milk' => 'none', 'milk_ml' => 0, 'sugar' => 0],
        'Soy milk' => ['cups' => 2, 'grams' => 12, 'milk' => 'soy', 'milk_ml' => 60, 'sugar' => 1],
        'Latte a day' => ['cups' => 1, 'grams' => 18, 'milk' => 'dairy', 'milk_ml' => 250, 'sugar' => 0],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'coffee' => ['label' => 'From coffee'],
            'milk' => ['label' => 'From milk'],
            'sugar' => ['label' => 'From sugar'],
            'share' => ['label' => 'Shares'],
            'driving' => ['label' => 'Comparison'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>CO₂e = coffee kg × 28.53 + milk L × factor + sugar kg × 3.2</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
