<x-calc.page
    title="Plasma Osmolality Calculator - SolveKit"
    description="Free plasma osmolality calculator: calculated osmolality from sodium, glucose and urea (with optional ethanol), and the osmolal gap."
    lede="Calculate plasma osmolality."
    about="Calculated osmolality = 2 × Na + glucose ÷ 18 + BUN ÷ 2.8 in US units (or 2 × Na + glucose + urea in mmol/L), plus ethanol ÷ 3.7 when present. The normal range is about 275–295 mOsm/kg. An osmolal gap (measured − calculated) over 10 suggests unmeasured osmoles such as methanol or ethylene glycol. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-labs', 'tool' => 'osm', 'fields' => ['na', 'measured', 'glucose', 'glucose_unit', 'bun', 'bun_unit', 'ethanol']]"
    :how-to="[
        ['name' => 'Enter sodium, glucose and urea', 'text' => ''],
        ['name' => 'Add the measured value', 'text' => 'For the gap.'],
    ]"
    :faqs="[
        ['question' => 'What is the osmolality for Na 140, glucose 100 and BUN 14?', 'answer' => '291 mOsm/kg.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="na" label="Sodium" value="140" min="0" step="any" suffix="mmol/L" />
        <x-calc.field name="measured" label="Measured osmolality (optional)" value="300" min="0" step="any" suffix="mOsm/kg" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="glucose" label="Glucose" value="100" min="0" step="any" />
        <x-calc.select name="glucose_unit" label="Glucose unit" :options="['mg/dL' => 'mg/dL', 'mmol/L' => 'mmol/L']" selected="mg/dL" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="bun" label="Urea (BUN)" value="14" min="0" step="any" />
        <x-calc.select name="bun_unit" label="Urea (BUN) unit" :options="['mg/dL BUN' => 'mg/dL BUN', 'mmol/L urea' => 'mmol/L urea']" selected="mg/dL BUN" />
    </div>

    <x-calc.field name="ethanol" label="Ethanol (optional)" value="" min="0" step="any" suffix="mg/dL" placeholder="Optional" />

    <x-calc.result label="Calculated osmolality" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['na' => 140, 'measured' => 300, 'glucose' => 100, 'glucose_unit' => 'mg/dL', 'bun' => 14, 'bun_unit' => 'mg/dL BUN', 'ethanol' => ''],
        'SI' => ['na' => 135, 'measured' => 320, 'glucose' => 20, 'glucose_unit' => 'mmol/L', 'bun' => 15, 'bun_unit' => 'mmol/L urea', 'ethanol' => ''],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'gap' => ['label' => 'Osmolal gap'],
            'formula' => ['label' => 'Formula'],
            'ethanol' => ['label' => 'Ethanol'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>2 Na + glucose ÷ 18 + BUN ÷ 2.8</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
