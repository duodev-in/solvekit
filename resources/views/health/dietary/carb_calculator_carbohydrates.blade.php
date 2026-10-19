<x-calc.page
    title="Carb Calculator (Carbohydrates) - SolveKit"
    description="Free carb calculator: grams of carbohydrate a day from your calories and carb percentage, with the 45–65% AMDR range."
    lede="Work out your daily carbohydrate."
    about="Carbohydrate has 4 kcal per gram. The Institute of Medicine's Acceptable Macronutrient Distribution Range is 45–65% of calories for adults, with an RDA of 130 g a day (the brain's glucose need). For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-diet', 'tool' => 'carbs', 'fields' => ['calories', 'percent']]"
    :how-to="[
        ['name' => 'Enter calories and carb share', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How many grams of carbs is 50% of 2,000 kcal?', 'answer' => '250 g.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="calories" label="Daily calories" value="2000" min="0" step="50" suffix="kcal" />
        <x-calc.field name="percent" label="Carbohydrate" value="50" min="0" max="100" step="any" suffix="%" />
    </div>

    <x-calc.result label="Carbohydrate a day" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['calories' => 2000, 'percent' => 50],
        'Low carb' => ['calories' => 1800, 'percent' => 25],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'amdr' => ['label' => 'AMDR range'],
            'rda' => ['label' => 'RDA'],
            'meals' => ['label' => 'Per meal'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>g = kcal × % ÷ 4</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
