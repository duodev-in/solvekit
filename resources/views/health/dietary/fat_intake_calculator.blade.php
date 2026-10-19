<x-calc.page
    title="Fat Intake Calculator - SolveKit"
    description="Free fat intake calculator: grams of fat a day from your calories, with the 20–35% AMDR and the saturated fat limit."
    lede="Work out your daily fat intake."
    about="Fat has 9 kcal per gram. Adults are advised to get 20–35% of calories from fat (IOM AMDR) and less than 10% from saturated fat (Dietary Guidelines 2020–2025). For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-diet', 'tool' => 'fat', 'fields' => ['calories', 'percent']]"
    :how-to="[
        ['name' => 'Enter calories and fat share', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How much fat is 30% of 2,000 kcal?', 'answer' => '67 g.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="calories" label="Daily calories" value="2000" min="0" step="50" suffix="kcal" />
        <x-calc.field name="percent" label="Fat" value="30" min="0" max="100" step="any" suffix="%" />
    </div>

    <x-calc.result label="Fat a day" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['calories' => 2000, 'percent' => 30],
        'Low fat' => ['calories' => 1800, 'percent' => 20],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'amdr' => ['label' => 'AMDR range'],
            'saturated' => ['label' => 'Saturated fat'],
            'trans' => ['label' => 'Trans fat'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>g = kcal × % ÷ 9</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
