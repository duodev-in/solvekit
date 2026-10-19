<x-calc.page
    title="RSBI Calculator - Rapid Shallow Breathing Index - SolveKit"
    description="Free RSBI calculator: rapid shallow breathing index (respiratory rate ÷ tidal volume in litres) for ventilator weaning."
    lede="Calculate the RSBI."
    about="The rapid shallow breathing index (Yang & Tobin 1991) is breaths per minute ÷ tidal volume in litres, measured during a short spontaneous breathing trial. Under 105 predicts successful weaning more often; 105 or more predicts failure. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-clinical', 'tool' => 'rsbi', 'fields' => ['rr', 'vt']]"
    :how-to="[
        ['name' => 'Enter rate and tidal volume', 'text' => 'During a spontaneous breathing trial.'],
    ]"
    :faqs="[
        ['question' => 'What is the RSBI at 25 breaths a minute and 350 mL?', 'answer' => '71: Under 105: weaning more likely to succeed.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="rr" label="Respiratory rate" value="25" min="0" step="1" suffix="/min" />
        <x-calc.field name="vt" label="Tidal volume" value="350" min="0" step="1" suffix="mL" />
    </div>

    <x-calc.result label="RSBI" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['rr' => 25, 'vt' => 350],
        'Failing' => ['rr' => 35, 'vt' => 250],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'formula' => ['label' => 'Formula'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>RSBI = RR ÷ VT (L)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
