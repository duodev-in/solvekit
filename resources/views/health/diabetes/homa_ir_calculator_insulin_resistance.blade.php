<x-calc.page
    title="HOMA-IR Calculator — Insulin Resistance - SolveKit"
    description="Free HOMA-IR calculator: insulin resistance (HOMA-IR) and beta-cell function (HOMA-%B) from fasting glucose and insulin."
    lede="Estimate insulin resistance."
    about="Homeostatic model assessment (Matthews et al. 1985): HOMA-IR = fasting glucose (mmol/L) × fasting insulin (µU/mL) ÷ 22.5; HOMA-%B = 20 × insulin ÷ (glucose − 3.5). Values around 1 are typical of insulin-sensitive adults; thresholds for resistance (often 2–2.9) differ between studies and insulin assays. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-diet', 'tool' => 'homa', 'fields' => ['glucose', 'glucose_unit', 'insulin', 'insulin_unit']]"
    :how-to="[
        ['name' => 'Enter fasting glucose and insulin', 'text' => 'From the same blood sample.'],
    ]"
    :faqs="[
        ['question' => 'What is the HOMA-IR for glucose 95 mg/dL and insulin 10 µU/mL?', 'answer' => '2.34.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="glucose" label="Fasting glucose" value="95" min="0" step="any" />
        <x-calc.select name="glucose_unit" label="Fasting glucose unit" :options="['mg/dL' => 'mg/dL', 'mmol/L' => 'mmol/L']" selected="mg/dL" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="insulin" label="Fasting insulin" value="10" min="0" step="any" />
        <x-calc.select name="insulin_unit" label="Fasting insulin unit" :options="['µU/mL' => 'µU/mL', 'pmol/L' => 'pmol/L']" selected="µU/mL" />
    </div>

    <x-calc.result label="HOMA-IR" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['glucose' => 95, 'glucose_unit' => 'mg/dL', 'insulin' => 10, 'insulin_unit' => 'µU/mL'],
        'Resistant' => ['glucose' => 6.1, 'glucose_unit' => 'mmol/L', 'insulin' => 120, 'insulin_unit' => 'pmol/L'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'beta' => ['label' => 'HOMA-%B'],
            'formula' => ['label' => 'Formula'],
            'note' => ['label' => 'Note'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>HOMA-IR = G × I ÷ 22.5</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
