<x-calc.page
    title="Cholesterol Ratio Calculator - SolveKit"
    description="Free cholesterol ratio calculator: total-to-HDL ratio, LDL-to-HDL, triglyceride-to-HDL and non-HDL cholesterol from a lipid panel."
    lede="Work out your cholesterol ratios."
    about="The total-to-HDL ratio combines “bad” and “good” cholesterol into one number: under 3.5 is ideal and 5 or more higher risk (common clinical rule). Non-HDL cholesterol (total − HDL) under 130 mg/dL is desirable (NCEP ATP III); a triglyceride-to-HDL ratio above 3 (mg/dL) suggests insulin resistance. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-diet', 'tool' => 'chol_ratio', 'fields' => ['tc', 'tc_unit', 'hdl', 'hdl_unit', 'ldl', 'ldl_unit', 'tg', 'tg_unit']]"
    :how-to="[
        ['name' => 'Enter the lipid panel', 'text' => 'Mixed units are fine.'],
    ]"
    :faqs="[
        ['question' => 'What is the ratio for total 200 and HDL 50?', 'answer' => '4.0 (3.5–5: acceptable).'],
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
        <x-calc.field name="ldl" label="LDL (optional)" value="" min="0" step="any" />
        <x-calc.select name="ldl_unit" label="LDL (optional) unit" :options="['mg/dL' => 'mg/dL', 'mmol/L' => 'mmol/L']" selected="mg/dL" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="tg" label="Triglycerides" value="150" min="0" step="any" />
        <x-calc.select name="tg_unit" label="Triglycerides unit" :options="['mg/dL' => 'mg/dL', 'mmol/L' => 'mmol/L']" selected="mg/dL" />
    </div>

    <x-calc.result label="Total / HDL cholesterol ratio" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['tc' => 200, 'tc_unit' => 'mg/dL', 'hdl' => 50, 'hdl_unit' => 'mg/dL', 'ldl' => '', 'ldl_unit' => 'mg/dL', 'tg' => 150, 'tg_unit' => 'mg/dL'],
        'mmol/L' => ['tc' => 6.2, 'tc_unit' => 'mmol/L', 'hdl' => 1.1, 'hdl_unit' => 'mmol/L', 'ldl' => 4.1, 'ldl_unit' => 'mmol/L', 'tg' => 2.2, 'tg_unit' => 'mmol/L'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'nonHdl' => ['label' => 'Non-HDL'],
            'ldlHdl' => ['label' => 'LDL / HDL'],
            'tgHdl' => ['label' => 'TG / HDL'],
            'note' => ['label' => 'Note'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>ratio = total ÷ HDL</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
