<x-calc.page
    title="VLDL Calculator - SolveKit"
    description="Free VLDL calculator: estimate VLDL cholesterol from triglycerides (Friedewald: TG ÷ 5 in mg/dL)."
    lede="Estimate VLDL cholesterol."
    about="VLDL cholesterol is usually estimated, not measured: VLDL = triglycerides ÷ 5 (mg/dL) or ÷ 2.2 (mmol/L), the Friedewald assumption. It is not reliable when triglycerides exceed 400 mg/dL. A usual VLDL is 2–30 mg/dL. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-diet', 'tool' => 'vldl', 'fields' => ['tg', 'tg_unit']]"
    :how-to="[
        ['name' => 'Enter triglycerides', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What VLDL does a triglyceride level of 150 mg/dL give?', 'answer' => '30 mg/dL.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="tg" label="Triglycerides" value="150" min="0" step="any" />
        <x-calc.select name="tg_unit" label="Triglycerides unit" :options="['mg/dL' => 'mg/dL', 'mmol/L' => 'mmol/L']" selected="mg/dL" />
    </div>

    <x-calc.result label="VLDL cholesterol (estimate)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['tg' => 150, 'tg_unit' => 'mg/dL'],
        'mmol/L' => ['tg' => 2.5, 'tg_unit' => 'mmol/L'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'formula' => ['label' => 'Formula'],
            'limit' => ['label' => 'Validity'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>VLDL = TG ÷ 5</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
