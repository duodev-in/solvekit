<x-calc.page
    title="Sodium Change Calculator in Hypertriglyceridemia - SolveKit"
    description="Free sodium correction for hypertriglyceridemia: the sodium value adjusted for very high triglycerides (pseudohyponatraemia)."
    lede="Adjust sodium for high triglycerides."
    about="Very high lipids take up plasma volume, so indirect ion-selective electrode methods report falsely low sodium (pseudohyponatraemia) while osmolality stays normal. A common estimate is corrected Na = measured Na + 0.002 × triglycerides (mg/dL). A direct ISE measurement, as on a blood gas analyser, avoids the problem. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-labs', 'tool' => 'na_htg', 'fields' => ['na', 'tg', 'tg_unit']]"
    :how-to="[
        ['name' => 'Enter measured sodium', 'text' => ''],
        ['name' => 'Enter triglycerides', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the sodium for Na 128 with triglycerides 3,000 mg/dL?', 'answer' => '134 mmol/L.'],
    ]"
>
    <x-calc.field name="na" label="Measured sodium" value="128" min="0" step="any" suffix="mmol/L" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="tg" label="Triglycerides" value="3000" min="0" step="any" />
        <x-calc.select name="tg_unit" label="Triglycerides unit" :options="['mg/dL' => 'mg/dL', 'mmol/L' => 'mmol/L']" selected="mg/dL" />
    </div>

    <x-calc.result label="Sodium corrected for triglycerides" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['na' => 128, 'tg' => 3000, 'tg_unit' => 'mg/dL'],
        'SI' => ['na' => 130, 'tg' => 40, 'tg_unit' => 'mmol/L'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'formula' => ['label' => 'Formula'],
            'note' => ['label' => 'Note'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>Na + 0.002 × TG</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
