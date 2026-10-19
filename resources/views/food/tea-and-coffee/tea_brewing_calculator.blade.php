<x-calc.page
    title="Tea Brewing Calculator - SolveKit"
    description="Free tea brewing calculator: how much loose tea to use, water temperature and steeping time for black, green, white, oolong, herbal and rooibos tea, with caffeine."
    lede="Brew loose-leaf tea the right way."
    about="A typical cup uses about 2–3 g of leaves per 250 ml; delicate green and white teas want cooler water (75–85 °C) and shorter steeps, black and herbal teas boiling water. Leaf size changes how much fits in a teaspoon, so weigh for consistency. ISO 3103, the standard tasting brew, uses 2 g per 100 ml for 6 minutes (strong). Caffeine for black and green tea comes from USDA FoodData Central."
    :calc="['engine' => 'fd-drinks', 'tool' => 'tea', 'fields' => ['type', 'cups', 'cup_size'], 'data' => ['ingredients' => config('food_data.ingredients')]]"
    :how-to="[
        ['name' => 'Choose the tea', 'text' => ''],
        ['name' => 'Enter the cups and size', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How much black tea for 2 cups?', 'answer' => '4.73 g (1⅞ tsp (1.89), at about 2.5 g a teaspoon of this tea), 95–100 °C (203–212 °F), 3–5 minutes.'],
        ['question' => 'What temperature for green tea?', 'answer' => '75–80 °C (167–176 °F).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.select name="type" label="Tea" :options="['black' => 'Black', 'green' => 'Green', 'white' => 'White', 'oolong' => 'Oolong', 'herbal' => 'Herbal', 'rooibos' => 'Rooibos']" selected="black" />
        <x-calc.field name="cups" label="Cups" value="2" min="0" step="1" />
        <x-calc.select name="cup_size" label="Cup size" :options="['6' => '6 fl oz', '8' => '8 fl oz', '12' => '12 fl oz', '16' => '16 fl oz (pot)']" selected="8" />
    </div>

    <x-calc.result label="Leaves to use" />

    <x-calc.options :decimals="false" :examples="[
        'Black' => ['type' => 'black', 'cups' => 2, 'cup_size' => '8'],
        'Green' => ['type' => 'green', 'cups' => 1, 'cup_size' => '12'],
        'Oolong pot' => ['type' => 'oolong', 'cups' => 4, 'cup_size' => '6'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'tsp' => ['label' => 'Teaspoons'],
            'temp' => ['label' => 'Water temperature'],
            'time' => ['label' => 'Steeping time'],
            'caffeine' => ['label' => 'Caffeine'],
            'iso' => ['label' => 'ISO 3103'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>leaves = 2.5 g × water ÷ 250 ml</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
