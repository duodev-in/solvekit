<x-calc.page
    title="CVD Risk Calculator – Cardiovascular Disease 10-year Risk - SolveKit"
    description="Free CVD risk calculator: 10-year risk of heart attack or stroke from the ACC/AHA Pooled Cohort Equations (age, sex, cholesterol, HDL, blood pressure, smoking, diabetes), in mg/dL or mmol/L."
    lede="Estimate your 10-year heart attack and stroke risk."
    about="The Pooled Cohort Equations (Goff et al. 2013) estimate the 10-year risk of a first atherosclerotic cardiovascular event (heart attack, coronary death or stroke) for adults aged 40–79 without heart disease. ACC/AHA 2019 bands: under 5% low, 5–7.4% borderline, 7.5–19.9% intermediate, 20% or more high. The equations can over-estimate risk in some modern populations; the newer AHA PREVENT equations are not included here. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-clinical', 'tool' => 'pce', 'fields' => ['age', 'sex', 'race', 'tc', 'tc_unit', 'hdl', 'hdl_unit', 'sbp', 'treated', 'smoker', 'diabetes']]"
    :how-to="[
        ['name' => 'Enter age, sex and race', 'text' => 'Race selects the published coefficients.'],
        ['name' => 'Enter cholesterol and blood pressure', 'text' => 'Units can be mg/dL or mmol/L.'],
        ['name' => 'Tick what applies', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the 10-year risk for a 55-year-old white woman, cholesterol 213, HDL 50, systolic 120, non-smoker?', 'answer' => '2.1% (Low (under 5%)).'],
        ['question' => 'And a 55-year-old man who smokes, with systolic 140 on treatment?', 'answer' => '15.0%.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="age" label="Age" value="55" min="0" step="1" suffix="years" />
        <x-calc.segmented name="sex" legend="Sex" :options="['male' => 'Male', 'female' => 'Female']" selected="male" />
        <x-calc.select name="race" label="Race (PCE)" :options="['white' => 'White or other', 'black' => 'African American']" selected="white" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="tc" label="Total cholesterol" value="213" min="0" step="any" />
        <x-calc.select name="tc_unit" label="Total cholesterol unit" :options="['mg/dL' => 'mg/dL', 'mmol/L' => 'mmol/L']" selected="mg/dL" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="hdl" label="HDL cholesterol" value="50" min="0" step="any" />
        <x-calc.select name="hdl_unit" label="HDL cholesterol unit" :options="['mg/dL' => 'mg/dL', 'mmol/L' => 'mmol/L']" selected="mg/dL" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="sbp" label="Systolic BP" value="120" min="0" step="1" suffix="mmHg" />
        <x-calc.checkbox name="treated" label="On blood pressure medicine" :checked="false" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="smoker" label="Current smoker" :checked="false" />
        <x-calc.checkbox name="diabetes" label="Diabetes" :checked="false" />
    </div>

    <x-calc.result label="10-year ASCVD risk" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['age' => 55, 'sex' => 'female', 'race' => 'white', 'tc' => 213, 'tc_unit' => 'mg/dL', 'hdl' => 50, 'hdl_unit' => 'mg/dL', 'sbp' => 120, 'treated' => false, 'smoker' => false, 'diabetes' => false],
        'Smoker' => ['age' => 55, 'sex' => 'male', 'race' => 'white', 'tc' => 213, 'tc_unit' => 'mg/dL', 'hdl' => 50, 'hdl_unit' => 'mg/dL', 'sbp' => 140, 'treated' => true, 'smoker' => true, 'diabetes' => false],
        'mmol/L' => ['age' => 62, 'sex' => 'male', 'race' => 'white', 'tc' => 5.5, 'tc_unit' => 'mmol/L', 'hdl' => 1.1, 'hdl_unit' => 'mmol/L', 'sbp' => 135, 'treated' => false, 'smoker' => false, 'diabetes' => true],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'band' => ['label' => 'Risk band'],
            'optimal' => ['label' => 'With optimal risk factors'],
            'guideline' => ['label' => 'Guideline'],
            'source' => ['label' => 'Equations'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>risk = 1 − S₀^exp(Σβx − mean)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
