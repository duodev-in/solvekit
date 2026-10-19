<x-calc.page
    title="Framingham Risk Calculator - SolveKit"
    description="Free Framingham risk calculator: 10-year general cardiovascular disease risk and heart age from the 2008 Framingham equation (age, sex, cholesterol, HDL, blood pressure, smoking, diabetes)."
    lede="Estimate your Framingham 10-year CVD risk."
    about="The Framingham general cardiovascular risk equation (D'Agostino et al., Circulation 2008) predicts the 10-year risk of coronary heart disease, stroke, peripheral artery disease or heart failure for adults aged 30–74. Under 10% is low, 10–20% intermediate and 20% or more high. Heart age is the age of a person with the same risk but normal risk factors. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-clinical', 'tool' => 'framingham', 'fields' => ['age', 'sex', 'race', 'tc', 'tc_unit', 'hdl', 'hdl_unit', 'sbp', 'treated', 'smoker', 'diabetes']]"
    :how-to="[
        ['name' => 'Enter age and sex', 'text' => ''],
        ['name' => 'Enter cholesterol, HDL and blood pressure', 'text' => ''],
        ['name' => 'Tick what applies', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the Framingham risk for a 55-year-old woman, cholesterol 213, HDL 50, systolic 120?', 'answer' => '5.3%, heart age 55 years.'],
        ['question' => 'And a 55-year-old male smoker on BP treatment (systolic 140)?', 'answer' => '32.1%.'],
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

    <x-calc.result label="10-year cardiovascular risk" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['age' => 55, 'sex' => 'female', 'race' => 'white', 'tc' => 213, 'tc_unit' => 'mg/dL', 'hdl' => 50, 'hdl_unit' => 'mg/dL', 'sbp' => 120, 'treated' => false, 'smoker' => false, 'diabetes' => false],
        'Smoker' => ['age' => 55, 'sex' => 'male', 'race' => 'white', 'tc' => 213, 'tc_unit' => 'mg/dL', 'hdl' => 50, 'hdl_unit' => 'mg/dL', 'sbp' => 140, 'treated' => true, 'smoker' => true, 'diabetes' => false],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'heartAge' => ['label' => 'Heart age'],
            'includes' => ['label' => 'Events counted'],
            'source' => ['label' => 'Equation'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>risk = 1 − S₀^exp(Σβ ln x − mean)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
