<x-calc.page
    title="Perfect Pizza Calculator - SolveKit"
    description="Free pizza dough calculator: flour, water, salt, yeast and oil for any number and size of Neapolitan, New York, pan or thin-crust pizzas, from dough ball weight and baker's percentages."
    lede="Make pizza dough for any number and size of pizzas."
    about="Dough ball weight = pizza area × thickness factor (ounces of dough per square inch): about 0.078 for Neapolitan, 0.085 New York, 0.13 pan and 0.07 thin crust. The recipe then follows the style's baker's percentages, plus 2% for dough left in the bowl. Instant yeast is the reference; active dry needs about 25% more and fresh yeast three times as much."
    :calc="['engine' => 'fd-bake', 'tool' => 'pizza_dough', 'fields' => ['count', 'size', 'units', 'style', 'hydration', 'yeast']]"
    :how-to="[
        ['name' => 'Enter the number and size', 'text' => ''],
        ['name' => 'Choose the style', 'text' => 'It sets thickness and percentages.'],
    ]"
    :faqs="[
        ['question' => 'How much dough for four 12 in Neapolitan pizzas?', 'answer' => '250 g balls; 4 × 12 in Neapolitan: 1,020 g of dough in all.'],
        ['question' => 'What flour and water for two 16 in New York pizzas?', 'answer' => 'Flour 587 g, water 370 g (63%).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="count" label="Pizzas" value="4" min="0" step="1" />
        <x-calc.field name="size" label="Diameter" value="12" min="0" step="any" />
        <x-calc.segmented name="units" legend="In" :options="['in' => 'in', 'cm' => 'cm']" selected="in" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.select name="style" label="Style" :options="['neapolitan' => 'Neapolitan', 'newyork' => 'New York', 'pan' => 'Pan (Detroit, Sicilian)', 'thin' => 'Thin and crispy']" selected="neapolitan" />
        <x-calc.field name="hydration" label="Hydration (optional)" value="" min="40" max="90" step="any" suffix="%" placeholder="Style default" />
        <x-calc.select name="yeast" label="Yeast" :options="['instant' => 'Instant', 'active' => 'Active dry', 'fresh' => 'Fresh']" selected="instant" />
    </div>

    <x-calc.result label="Dough ball" />

    <x-calc.options :decimals="false" :examples="[
        '4 Neapolitan' => ['count' => 4, 'size' => 12, 'units' => 'in', 'style' => 'neapolitan', 'hydration' => '', 'yeast' => 'instant'],
        '2 New York' => ['count' => 2, 'size' => 16, 'units' => 'in', 'style' => 'newyork', 'hydration' => '', 'yeast' => 'instant'],
        'Pan, metric' => ['count' => 1, 'size' => 30, 'units' => 'cm', 'style' => 'pan', 'hydration' => '', 'yeast' => 'active'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'flour' => ['label' => 'Flour'],
            'water' => ['label' => 'Water'],
            'salt' => ['label' => 'Salt'],
            'yeast' => ['label' => 'Yeast'],
            'oil' => ['label' => 'Oil'],
            'sugar' => ['label' => 'Sugar'],
            'bake' => ['label' => 'Baking'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>ball = π/4 × d² × thickness factor</li>
            <li>flour = dough × 100 ÷ Σ percentages</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
