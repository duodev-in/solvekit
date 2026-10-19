<x-calc.page
    title="Anion Gap Calculator - SolveKit"
    description="Free anion gap calculator: serum anion gap from sodium, chloride and bicarbonate, corrected for albumin, with the delta ratio."
    lede="Calculate the anion gap."
    about="Anion gap = Na − (Cl + HCO₃), normally about 3–12 mmol/L with modern analysers (labs vary). Each 1 g/dL fall in albumin lowers the gap by about 2.5, so the corrected gap = AG + 2.5 × (4 − albumin). A raised gap points to ketoacidosis, lactic acidosis, kidney failure or toxins (methanol, ethylene glycol, salicylate). For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-labs', 'tool' => 'anion_gap', 'fields' => ['na', 'cl', 'hco3', 'k', 'albumin', 'albumin_unit']]"
    :how-to="[
        ['name' => 'Enter sodium, chloride and bicarbonate', 'text' => ''],
        ['name' => 'Add albumin', 'text' => 'For the corrected gap.'],
    ]"
    :faqs="[
        ['question' => 'What is the anion gap with Na 140, Cl 100, HCO₃ 14 and albumin 3?', 'answer' => '26 mmol/L (corrected 29 mmol/L (+ 2.5 × (4 − albumin g/dL))).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="na" label="Sodium" value="140" min="0" step="any" suffix="mmol/L" />
        <x-calc.field name="cl" label="Chloride" value="100" min="0" step="any" suffix="mmol/L" />
        <x-calc.field name="hco3" label="Bicarbonate" value="14" min="0" step="any" suffix="mmol/L" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="k" label="Potassium (optional)" value="" min="0" step="any" suffix="mmol/L" placeholder="Optional" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="albumin" label="Albumin (optional)" value="3" min="0" step="any" />
        <x-calc.select name="albumin_unit" label="Albumin (optional) unit" :options="['g/dL' => 'g/dL', 'g/L' => 'g/L']" selected="g/dL" />
    </div>

    <x-calc.result label="Anion gap" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['na' => 140, 'cl' => 100, 'hco3' => 14, 'k' => '', 'albumin' => 3, 'albumin_unit' => 'g/dL'],
        'Normal' => ['na' => 139, 'cl' => 104, 'hco3' => 25, 'k' => 4, 'albumin' => 40, 'albumin_unit' => 'g/L'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'corrected' => ['label' => 'Albumin-corrected'],
            'withK' => ['label' => 'Including potassium'],
            'delta' => ['label' => 'Delta ratio'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>AG = Na − (Cl + HCO₃)</li>
            <li>corrected = AG + 2.5 (4 − albumin)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
