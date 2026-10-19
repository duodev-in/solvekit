<x-calc.page
    title="Glycemic Load Calculator - SolveKit"
    description="Free glycemic load calculator: GL of foods and meals from glycemic index and available carbohydrate, with low, medium and high bands."
    lede="Work out glycemic load."
    about="Glycemic load = GI × available carbohydrate (g) ÷ 100. A GL of 10 or less is low, 11–19 medium and 20 or more high for a serving; a daily total under 80 is low and over 120 high. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-diet', 'tool' => 'gl', 'fields' => ['items']]"
    :how-to="[
        ['name' => 'List foods with GI and carbs', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the glycemic load of a cup of white rice (GI 73, 45 g carbs)?', 'answer' => '33.'],
    ]"
>
    <x-calc.rows-editor name="items" label="Foods (name, GI, carbs per serving, servings)" :columns="['name' => 'Food', 'gi' => 'GI', 'carbs' => 'Carbs (g)', 'servings' => 'Servings']" :rows="[['White rice, 1 cup', '73', '45', '1'], ['Lentils, 1 cup', '32', '35', '1'], ['Apple, medium', '36', '22', '1']]" add-label="Add food" :text="['name', 'gi', 'carbs', 'servings']" />

    <x-calc.result label="Glycemic load" />

    <x-calc.options :decimals="false" :examples="[
        'Rice' => ['items' => 'White rice, 1 cup	73	45	1'],
        'Meal' => ['items' => 'White rice, 1 cup	73	45	1
Lentils, 1 cup	32	35	1
Apple, medium	36	22	1'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'gi' => ['label' => 'Meal GI'],
            'carbs' => ['label' => 'Carbohydrate'],
            'day' => ['label' => 'Daily load'],
        ]" />
        <x-calc.grid heading="Foods" name="foods" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>GL = GI × carbs ÷ 100</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
