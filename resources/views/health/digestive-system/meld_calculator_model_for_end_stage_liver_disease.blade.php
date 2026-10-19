<x-calc.page
    title="MELD Calculator (Model for End-Stage Liver Disease) - SolveKit"
    description="Free MELD calculator: MELD 3.0 (the current US liver transplant score) with MELD and MELD-Na, from bilirubin, INR, creatinine, sodium, albumin and sex."
    lede="Calculate the MELD 3.0 score."
    about="MELD 3.0 (Kim et al. 2021), used by the OPTN since 2023, adds sex and albumin to the MELD-Na variables: 1.33 (female) + 4.56 ln(bilirubin) + 0.82 (137 − Na) − 0.24 (137 − Na) ln(bilirubin) + 9.09 ln(INR) + 11.14 ln(creatinine) + 1.85 (3.5 − albumin) − 1.83 (3.5 − albumin) ln(creatinine) + 6. Values range 6–40; higher scores mean higher 90-day mortality without a transplant. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-misc', 'tool' => 'meld', 'fields' => ['bilirubin', 'bilirubin_unit', 'cr', 'cr_unit', 'albumin', 'albumin_unit', 'inr', 'na', 'sex', 'dialysis']]"
    :how-to="[
        ['name' => 'Enter the lab values', 'text' => ''],
        ['name' => 'Choose sex and tick dialysis', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is MELD 3.0 for bilirubin 2.5, INR 1.6, creatinine 1.4, Na 132 and albumin 3.0 (man)?', 'answer' => '22 (About 93% 90-day survival without a transplant).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="bilirubin" label="Bilirubin" value="2.5" min="0" step="any" />
        <x-calc.select name="bilirubin_unit" label="Bilirubin unit" :options="['mg/dL' => 'mg/dL', 'µmol/L' => 'µmol/L']" selected="mg/dL" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="cr" label="Creatinine" value="1.4" min="0" step="any" />
        <x-calc.select name="cr_unit" label="Creatinine unit" :options="['mg/dL' => 'mg/dL', 'µmol/L' => 'µmol/L']" selected="mg/dL" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="albumin" label="Albumin" value="3.0" min="0" step="any" />
        <x-calc.select name="albumin_unit" label="Albumin unit" :options="['g/dL' => 'g/dL', 'g/L' => 'g/L']" selected="g/dL" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="inr" label="INR" value="1.6" min="0" step="0.1" />
        <x-calc.field name="na" label="Sodium" value="132" min="0" step="any" suffix="mmol/L" />
        <x-calc.segmented name="sex" legend="Sex" :options="['male' => 'Male', 'female' => 'Female']" selected="male" />
    </div>

    <x-calc.checkbox name="dialysis" label="Dialysis twice or more (or CVVHD 24 h) in the last week" :checked="false" />

    <x-calc.result label="MELD 3.0" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['bilirubin' => 2.5, 'bilirubin_unit' => 'mg/dL', 'cr' => 1.4, 'cr_unit' => 'mg/dL', 'albumin' => 3.0, 'albumin_unit' => 'g/dL', 'inr' => 1.6, 'na' => 132, 'sex' => 'male', 'dialysis' => false],
        'Severe' => ['bilirubin' => 12, 'bilirubin_unit' => 'mg/dL', 'cr' => 2.6, 'cr_unit' => 'mg/dL', 'albumin' => 2.4, 'albumin_unit' => 'g/dL', 'inr' => 2.4, 'na' => 126, 'sex' => 'female', 'dialysis' => false],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'meld' => ['label' => 'MELD'],
            'meldNa' => ['label' => 'MELD-Na'],
            'bounds' => ['label' => 'Bounds'],
            'source' => ['label' => 'Source'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>MELD 3.0 (Kim 2021)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
