<x-calc.page
    title="Added Sugar Intake Calculator - SolveKit"
    description="Free added sugar calculator: your daily added sugar from foods and drinks against the AHA limits (25 g women, 36 g men) and the WHO 10% guideline."
    lede="Track your added sugar."
    about="Added sugars are sugars put into foods and drinks, listed separately on US Nutrition Facts labels. The American Heart Association suggests no more than 25 g (6 teaspoons) a day for women and 36 g (9 teaspoons) for men; WHO and the Dietary Guidelines say less than 10% of calories, and WHO notes extra benefit below 5%. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-diet', 'tool' => 'added_sugar', 'fields' => ['items', 'sex', 'calories']]"
    :how-to="[
        ['name' => 'List what you ate and drank', 'text' => 'Grams from the label.'],
        ['name' => 'Choose sex and calories', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'Is a soda, a yogurt and two granola bars too much added sugar?', 'answer' => '67 g (Above the AHA limit of 25 g (women)).'],
    ]"
>
    <x-calc.rows-editor name="items" label="Foods and drinks (name, grams of added sugar, how many)" :columns="['name' => 'Item', 'grams' => 'Added sugar (g)', 'count' => 'How many']" :rows="[['Soda, 12 oz can', '39', '1'], ['Flavoured yogurt', '12', '1'], ['Granola bar', '8', '2']]" add-label="Add item" :text="['name', 'grams', 'count']" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.segmented name="sex" legend="Sex" :options="['male' => 'Male', 'female' => 'Female']" selected="female" />
        <x-calc.field name="calories" label="Daily calories" value="2000" min="0" step="50" suffix="kcal" />
    </div>

    <x-calc.result label="Added sugar today" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['items' => 'Soda, 12 oz can	39	1
Flavoured yogurt	12	1
Granola bar	8	2', 'sex' => 'female', 'calories' => 2000],
        'Lighter day' => ['items' => 'Coffee with sugar	8	2
Cookie	10	1', 'sex' => 'male', 'calories' => 2400],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'aha' => ['label' => 'AHA limit'],
            'who' => ['label' => 'WHO guideline'],
            'dga' => ['label' => 'Dietary Guidelines'],
        ]" />
        <x-calc.grid heading="Items" name="items" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>% energy = grams × 4 ÷ calories</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
