<x-calc.page
    title="Diabetic Ketoacidosis Calculator - SolveKit"
    description="Free DKA calculator: check glucose, pH, bicarbonate, ketones, anion gap and mental status against the ADA criteria for mild, moderate and severe diabetic ketoacidosis."
    lede="Classify diabetic ketoacidosis."
    about="ADA consensus criteria (Kitabchi et al. 2009): glucose above 250 mg/dL, arterial pH 7.30 or lower, bicarbonate 18 mEq/L or lower and positive ketones. Mild: pH 7.25–7.30 and bicarbonate 15–18; moderate: pH 7.00–7.24 or bicarbonate 10–14 or drowsy; severe: pH below 7.00 or bicarbonate below 10 or stupor. DKA is an emergency; this page is for education. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-diet', 'tool' => 'dka', 'fields' => ['glucose', 'glucose_unit', 'ph', 'hco3', 'ketones', 'na', 'cl', 'mental']]"
    :how-to="[
        ['name' => 'Enter the lab values', 'text' => ''],
        ['name' => 'Choose mental status', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is glucose 450, pH 7.2 and bicarbonate 12?', 'answer' => 'Moderate DKA.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="glucose" label="Glucose" value="450" min="0" step="any" />
        <x-calc.select name="glucose_unit" label="Glucose unit" :options="['mg/dL' => 'mg/dL', 'mmol/L' => 'mmol/L']" selected="mg/dL" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="ph" label="Arterial pH" value="7.2" min="6.5" max="7.8" step="0.01" />
        <x-calc.field name="hco3" label="Bicarbonate" value="12" min="0" step="any" suffix="mEq/L" />
        <x-calc.checkbox name="ketones" label="Ketones positive (urine or blood)" :checked="true" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="na" label="Sodium" value="135" min="100" step="any" suffix="mmol/L" />
        <x-calc.field name="cl" label="Chloride" value="100" min="60" step="any" suffix="mmol/L" />
        <x-calc.select name="mental" label="Mental status" :options="['alert' => 'Alert', 'drowsy' => 'Drowsy', 'stupor' => 'Stupor or coma']" selected="alert" />
    </div>

    <x-calc.result label="DKA classification" />

    <x-calc.options :decimals="false" :examples="[
        'Moderate' => ['glucose' => 450, 'glucose_unit' => 'mg/dL', 'ph' => 7.2, 'hco3' => 12, 'ketones' => true, 'na' => 135, 'cl' => 100, 'mental' => 'alert'],
        'Severe' => ['glucose' => 30, 'glucose_unit' => 'mmol/L', 'ph' => 6.95, 'hco3' => 6, 'ketones' => true, 'na' => 132, 'cl' => 98, 'mental' => 'stupor'],
        'Not DKA' => ['glucose' => 300, 'glucose_unit' => 'mg/dL', 'ph' => 7.38, 'hco3' => 24, 'ketones' => false, 'na' => 138, 'cl' => 101, 'mental' => 'alert'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'ag' => ['label' => 'Anion gap'],
            'criteria' => ['label' => 'Criteria'],
            'urgent' => ['label' => 'Urgent'],
            'source' => ['label' => 'Source'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>AG = Na − (Cl + HCO₃)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
