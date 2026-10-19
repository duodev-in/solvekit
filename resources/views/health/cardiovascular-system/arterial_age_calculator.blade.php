<x-calc.page
    title="Arterial Age Calculator - SolveKit"
    description="Free arterial age calculator: your heart (vascular) age from the Framingham risk factors, compared with your real age."
    lede="Find your heart age."
    about="Heart or vascular age (D'Agostino et al. 2008) is the age at which a person with normal risk factors (total cholesterol 180 mg/dL, HDL 45, systolic 125, no smoking or diabetes) would have your Framingham 10-year risk. A heart age above your real age shows how much risk factors add. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-clinical', 'tool' => 'heart_age', 'fields' => ['age', 'sex', 'race', 'tc', 'tc_unit', 'hdl', 'hdl_unit', 'sbp', 'treated', 'smoker', 'diabetes']]"
    :how-to="[
        ['name' => 'Enter your risk factors', 'text' => ''],
        ['name' => 'Compare heart age with your age', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the heart age of a 55-year-old man who smokes, systolic 140 on treatment?', 'answer' => '84 years (29 years older than your age of 55).'],
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

    <x-calc.result label="Heart age" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['age' => 55, 'sex' => 'female', 'race' => 'white', 'tc' => 213, 'tc_unit' => 'mg/dL', 'hdl' => 50, 'hdl_unit' => 'mg/dL', 'sbp' => 120, 'treated' => false, 'smoker' => false, 'diabetes' => false],
        'Smoker' => ['age' => 55, 'sex' => 'male', 'race' => 'white', 'tc' => 213, 'tc_unit' => 'mg/dL', 'hdl' => 50, 'hdl_unit' => 'mg/dL', 'sbp' => 140, 'treated' => true, 'smoker' => true, 'diabetes' => false],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'risk' => ['label' => '10-year risk'],
            'normal' => ['label' => 'Compared with'],
            'source' => ['label' => 'Method'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>heart age: Framingham risk solved for age</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
