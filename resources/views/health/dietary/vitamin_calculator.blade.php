<x-calc.page
    title="Vitamin Calculator - SolveKit"
    description="Free vitamin calculator: the RDA or AI and upper limit of every vitamin for your age, sex, pregnancy or breastfeeding, from the National Academies tables."
    lede="Look up your vitamin needs."
    about="Recommended Dietary Allowances meet the needs of nearly all healthy people; Adequate Intakes are used where evidence is weaker; Tolerable Upper Intake Levels are the most per day unlikely to cause harm (for some vitamins only from supplements). Values come from the NASEM DRI tables. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-diet', 'tool' => 'dri', 'fields' => ['age', 'sex', 'state'], 'data' => ['dri' => config('health_data.dri')], 'only' => 'vitamins']"
    :how-to="[
        ['name' => 'Enter age and sex', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How much vitamin D does a 75-year-old need?', 'answer' => 'The table for Males >70 y lists 20 µg (800 IU).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="age" label="Age" value="35" min="0" step="1" suffix="years" />
        <x-calc.segmented name="sex" legend="Sex" :options="['male' => 'Male', 'female' => 'Female']" selected="female" />
        <x-calc.select name="state" label="Life stage" :options="['none' => 'Not pregnant or breastfeeding', 'pregnancy' => 'Pregnant', 'lactation' => 'Breastfeeding']" selected="none" />
    </div>

    <x-calc.result label="Life-stage group" />

    <x-calc.options :decimals="false" :examples="[
        'Woman' => ['age' => 35, 'sex' => 'female', 'state' => 'none'],
        'Over 70' => ['age' => 75, 'sex' => 'male', 'state' => 'none'],
        'Breastfeeding' => ['age' => 30, 'sex' => 'female', 'state' => 'lactation'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'group' => ['label' => 'Group'],
            'ai' => ['label' => 'AI'],
            'ul' => ['label' => 'Upper limit'],
        ]" />
        <x-calc.grid heading="Vitamins" name="table" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>NASEM DRI tables</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
