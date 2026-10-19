<x-calc.page
    title="DRI Calculator - SolveKit"
    description="Free DRI calculator: Dietary Reference Intakes for every vitamin, mineral, water, fibre and protein by age, sex, pregnancy and breastfeeding, with upper limits, from the National Academies tables."
    lede="Look up your Dietary Reference Intakes."
    about="The National Academies set Recommended Dietary Allowances (RDA) that meet the needs of 97–98% of healthy people, Adequate Intakes (AI) where evidence is weaker, and Tolerable Upper Intake Levels (UL). Values come from the NASEM DRI summary tables. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-diet', 'tool' => 'dri', 'fields' => ['age', 'sex', 'state'], 'data' => ['dri' => config('health_data.dri')]]"
    :how-to="[
        ['name' => 'Enter age and sex', 'text' => ''],
        ['name' => 'Choose pregnancy or breastfeeding if it applies', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What are the DRIs for a 35-year-old woman?', 'answer' => 'See the table for Females 31-50 y.'],
        ['question' => 'How much iron in pregnancy?', 'answer' => 'The table for Pregnancy 19-30 y lists 27 mg.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="age" label="Age" value="35" min="0" step="1" suffix="years" />
        <x-calc.segmented name="sex" legend="Sex" :options="['male' => 'Male', 'female' => 'Female']" selected="male" />
        <x-calc.select name="state" label="Life stage" :options="['none' => 'Not pregnant or breastfeeding', 'pregnancy' => 'Pregnant', 'lactation' => 'Breastfeeding']" selected="none" />
    </div>

    <x-calc.result label="Life-stage group" />

    <x-calc.options :decimals="false" :examples="[
        'Man' => ['age' => 35, 'sex' => 'male', 'state' => 'none'],
        'Woman' => ['age' => 35, 'sex' => 'female', 'state' => 'none'],
        'Pregnant' => ['age' => 30, 'sex' => 'female', 'state' => 'pregnancy'],
        'Child 6' => ['age' => 6, 'sex' => 'male', 'state' => 'none'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'group' => ['label' => 'Group'],
            'ai' => ['label' => 'AI'],
            'ul' => ['label' => 'Upper limit'],
        ]" />
        <x-calc.grid heading="Reference intakes" name="table" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>NASEM DRI tables</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
