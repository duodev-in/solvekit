<x-calc.page
    title="Glycemic Index Calculator - SolveKit"
    description="Free glycemic index calculator: the glycemic index and load of a whole meal from each food's GI and carbohydrate."
    lede="Work out the glycemic index of a meal."
    about="A meal's glycemic index is the carbohydrate-weighted average of its foods' GIs: Σ (GI × carbs) ÷ Σ carbs. Low GI is 55 or less and high 70 or more. GI values come from the International Tables of Glycemic Index (Atkinson et al. 2021) or product labels. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-diet', 'tool' => 'gl', 'fields' => ['items'], 'mode' => 'gi']"
    :how-to="[
        ['name' => 'List each food with its GI and carbs', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the GI of rice, lentils and an apple?', 'answer' => 'Meal glycemic index 51 (low) over 102 g carbohydrate.'],
    ]"
>
    <x-calc.rows-editor name="items" label="Foods (name, GI, carbs per serving, servings)" :columns="['name' => 'Food', 'gi' => 'GI', 'carbs' => 'Carbs (g)', 'servings' => 'Servings']" :rows="[['White rice, 1 cup', '73', '45', '1'], ['Lentils, 1 cup', '32', '35', '1'], ['Apple, medium', '36', '22', '1']]" add-label="Add food" :text="['name', 'gi', 'carbs', 'servings']" />

    <x-calc.result label="Glycemic load of the meal" />

    <x-calc.options :decimals="false" :examples="[
        'Meal' => ['items' => 'White rice, 1 cup	73	45	1
Lentils, 1 cup	32	35	1
Apple, medium	36	22	1'],
        'Breakfast' => ['items' => 'Cornflakes, 1 cup	81	24	1
Milk, 1 cup	37	12	1'],
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
            <li>GI = Σ(GI × carbs) ÷ Σ carbs</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
