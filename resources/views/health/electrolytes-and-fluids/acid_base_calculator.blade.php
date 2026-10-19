<x-calc.page
    title="Acid Base Calculator - SolveKit"
    description="Free acid-base calculator: the primary disorder from a blood gas (pH, PaCO₂, HCO₃), with compensation checks, anion gap and delta ratio."
    lede="Interpret a blood gas."
    about="A stepwise approach: acidaemia under pH 7.35 or alkalaemia over 7.45; the primary process from PaCO₂ and HCO₃; then expected compensation (Winters' formula 1.5 × HCO₃ + 8 ± 2 for metabolic acidosis, 0.7 × HCO₃ + 21 for metabolic alkalosis, and the acute and chronic rules for respiratory disorders). The anion gap, corrected for albumin, and the delta ratio uncover mixed disorders. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-labs', 'tool' => 'acid_base', 'fields' => ['ph', 'pco2', 'hco3', 'na', 'cl', 'albumin', 'albumin_unit']]"
    :how-to="[
        ['name' => 'Enter the blood gas', 'text' => ''],
        ['name' => 'Add sodium, chloride and albumin', 'text' => 'For the anion gap.'],
    ]"
    :faqs="[
        ['question' => 'What does pH 7.28, PaCO₂ 28, HCO₃ 13 show?', 'answer' => 'Metabolic acidosis with appropriate respiratory compensation.'],
        ['question' => 'And pH 7.50, PaCO₂ 48, HCO₃ 36?', 'answer' => 'Metabolic alkalosis with appropriate respiratory compensation.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="ph" label="pH" value="7.28" min="0" step="0.01" />
        <x-calc.field name="pco2" label="PaCO₂" value="28" min="0" step="1" suffix="mmHg" />
        <x-calc.field name="hco3" label="HCO₃" value="13" min="0" step="any" suffix="mmol/L" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="na" label="Sodium" value="140" min="0" step="any" suffix="mmol/L" />
        <x-calc.field name="cl" label="Chloride" value="104" min="0" step="any" suffix="mmol/L" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="albumin" label="Albumin (optional)" value="4" min="0" step="any" />
        <x-calc.select name="albumin_unit" label="Albumin (optional) unit" :options="['g/dL' => 'g/dL', 'g/L' => 'g/L']" selected="g/dL" />
    </div>

    <x-calc.result label="Primary disorder" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['ph' => 7.28, 'pco2' => 28, 'hco3' => 13, 'na' => 140, 'cl' => 104, 'albumin' => 4, 'albumin_unit' => 'g/dL'],
        'Alkalosis' => ['ph' => 7.5, 'pco2' => 48, 'hco3' => 36, 'na' => 140, 'cl' => 92, 'albumin' => 4, 'albumin_unit' => 'g/dL'],
        'Respiratory' => ['ph' => 7.3, 'pco2' => 60, 'hco3' => 29, 'na' => 140, 'cl' => 100, 'albumin' => 4, 'albumin_unit' => 'g/dL'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'ag' => ['label' => 'Anion gap'],
            'delta' => ['label' => 'Delta ratio'],
            'method' => ['label' => 'Method'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>Winters: PaCO₂ = 1.5 HCO₃ + 8 ± 2</li>
            <li>AG = Na − Cl − HCO₃</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
