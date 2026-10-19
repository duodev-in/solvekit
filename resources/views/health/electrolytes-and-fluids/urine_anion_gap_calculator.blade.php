<x-calc.page
    title="Urine Anion Gap Calculator - SolveKit"
    description="Free urine anion gap calculator: urine Na + K − Cl, to tell gut bicarbonate loss from renal tubular acidosis in a normal anion gap acidosis."
    lede="Calculate the urine anion gap."
    about="Urine anion gap = urine Na + urine K − urine Cl. In a normal anion gap metabolic acidosis, a negative gap means the kidneys are excreting ammonium (as with diarrhoea), and a positive gap suggests impaired ammonium excretion, as in distal renal tubular acidosis (Batlle et al. 1988). For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-labs', 'tool' => 'uag', 'fields' => ['na', 'k', 'cl']]"
    :how-to="[
        ['name' => 'Enter urine sodium, potassium and chloride', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the urine anion gap for Na 40, K 30, Cl 95?', 'answer' => '-25 mmol/L: Negative: kidneys are excreting ammonium normally; suggests gut bicarbonate loss (such as diarrhoea).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="na" label="Urine sodium" value="40" min="0" step="any" suffix="mmol/L" />
        <x-calc.field name="k" label="Urine potassium" value="30" min="0" step="any" suffix="mmol/L" />
        <x-calc.field name="cl" label="Urine chloride" value="95" min="0" step="any" suffix="mmol/L" />
    </div>

    <x-calc.result label="Urine anion gap" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['na' => 40, 'k' => 30, 'cl' => 95],
        'RTA' => ['na' => 50, 'k' => 30, 'cl' => 60],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'formula' => ['label' => 'Formula'],
            'note' => ['label' => 'Note'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>UAG = Na + K − Cl</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
