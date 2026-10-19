<x-calc.page
    title="LDL Calculator - SolveKit"
    description="Free LDL calculator: LDL cholesterol by the Friedewald and NIH (Sampson) equations from total cholesterol, HDL and triglycerides, with the NCEP category."
    lede="Calculate LDL cholesterol."
    about="Friedewald (1972): LDL = total − HDL − triglycerides ÷ 5 (mg/dL), not valid above 400 mg/dL triglycerides. The NIH equation (Sampson et al. 2020) is more accurate at high triglycerides and low LDL and works up to 800 mg/dL. Categories follow NCEP ATP III. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-diet', 'tool' => 'ldl', 'fields' => ['tc', 'tc_unit', 'hdl', 'hdl_unit', 'tg', 'tg_unit']]"
    :how-to="[
        ['name' => 'Enter the lipid panel', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is LDL with total 200, HDL 50 and triglycerides 150?', 'answer' => '120 mg/dL.'],
        ['question' => 'And with triglycerides of 500?', 'answer' => '115 mg/dL.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="tc" label="Total cholesterol" value="200" min="0" step="any" />
        <x-calc.select name="tc_unit" label="Total cholesterol unit" :options="['mg/dL' => 'mg/dL', 'mmol/L' => 'mmol/L']" selected="mg/dL" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="hdl" label="HDL" value="50" min="0" step="any" />
        <x-calc.select name="hdl_unit" label="HDL unit" :options="['mg/dL' => 'mg/dL', 'mmol/L' => 'mmol/L']" selected="mg/dL" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="tg" label="Triglycerides" value="150" min="0" step="any" />
        <x-calc.select name="tg_unit" label="Triglycerides unit" :options="['mg/dL' => 'mg/dL', 'mmol/L' => 'mmol/L']" selected="mg/dL" />
    </div>

    <x-calc.result label="LDL cholesterol" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['tc' => 200, 'tc_unit' => 'mg/dL', 'hdl' => 50, 'hdl_unit' => 'mg/dL', 'tg' => 150, 'tg_unit' => 'mg/dL'],
        'High TG' => ['tc' => 240, 'tc_unit' => 'mg/dL', 'hdl' => 38, 'hdl_unit' => 'mg/dL', 'tg' => 500, 'tg_unit' => 'mg/dL'],
        'mmol/L' => ['tc' => 5.2, 'tc_unit' => 'mmol/L', 'hdl' => 1.3, 'hdl_unit' => 'mmol/L', 'tg' => 1.7, 'tg_unit' => 'mmol/L'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'friedewald' => ['label' => 'Friedewald'],
            'sampson' => ['label' => 'NIH (Sampson)'],
            'nonHdl' => ['label' => 'Non-HDL'],
            'band' => ['label' => 'Category'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>LDL = TC − HDL − TG/5</li>
            <li>Sampson: TC/0.948 − HDL/0.971 − (TG/8.56 + TG × nonHDL/2140 − TG²/16100) − 9.44</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
