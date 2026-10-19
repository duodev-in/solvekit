<x-calc.page
    title="Fiber Calculator - SolveKit"
    description="Free fiber calculator: your daily fibre target (Adequate Intake) by age and sex, and 14 g per 1,000 kcal."
    lede="Find how much fibre you need."
    about="The National Academies set the fibre Adequate Intake at 14 g per 1,000 kcal, about 38 g for men and 25 g for women aged 19–50. Most people eat about half that. Beans, lentils, whole grains, vegetables and fruit are the main sources. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-diet', 'tool' => 'fiber', 'fields' => ['age', 'sex', 'state', 'calories'], 'data' => ['dri' => config('health_data.dri')]]"
    :how-to="[
        ['name' => 'Enter age and sex', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How much fibre does a 35-year-old man need?', 'answer' => '38 g.'],
        ['question' => 'And a woman over 50?', 'answer' => '21 g.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="age" label="Age" value="35" min="0" step="1" suffix="years" />
        <x-calc.segmented name="sex" legend="Sex" :options="['male' => 'Male', 'female' => 'Female']" selected="male" />
        <x-calc.select name="state" label="Life stage" :options="['none' => 'Not pregnant or breastfeeding', 'pregnancy' => 'Pregnant', 'lactation' => 'Breastfeeding']" selected="none" />
    </div>

    <x-calc.field name="calories" label="Daily calories (optional)" value="2200" min="0" step="50" suffix="kcal" />

    <x-calc.result label="Fibre a day (Adequate Intake)" />

    <x-calc.options :decimals="false" :examples="[
        'Man' => ['age' => 35, 'sex' => 'male', 'state' => 'none', 'calories' => 2600],
        'Woman 55' => ['age' => 55, 'sex' => 'female', 'state' => 'none', 'calories' => 1800],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'perCalories' => ['label' => 'For your calories'],
            'sources' => ['label' => 'Sources'],
            'tip' => ['label' => 'Tip'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>AI = 14 g per 1,000 kcal</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
