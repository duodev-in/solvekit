<x-calc.page
    title="Revised Trauma Score Calculator - SolveKit"
    description="Free Revised Trauma Score calculator: RTS from Glasgow Coma Scale, systolic blood pressure and respiratory rate, coded and weighted."
    lede="Calculate the Revised Trauma Score."
    about="The Revised Trauma Score (Champion et al. 1989) codes GCS, systolic BP and respiratory rate 0–4 each. The weighted RTS = 0.9368 × GCS code + 0.7326 × SBP code + 0.2908 × RR code (0–7.84), used with ISS for survival estimates. The triage version simply adds the codes (0–12); under 11 suggests a trauma centre. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-clinical', 'tool' => 'rts', 'fields' => ['gcs', 'sbp', 'rr']]"
    :how-to="[
        ['name' => 'Enter GCS, systolic BP and respiratory rate', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the RTS with GCS 13, systolic 85 and RR 32?', 'answer' => '6.82 (Triage RTS 10 of 12: trauma centre care advised).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="gcs" label="Glasgow Coma Scale" value="13" min="3" max="15" step="1" />
        <x-calc.field name="sbp" label="Systolic BP" value="85" min="0" step="1" suffix="mmHg" />
        <x-calc.field name="rr" label="Respiratory rate" value="32" min="0" step="1" suffix="/min" />
    </div>

    <x-calc.result label="Revised Trauma Score" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['gcs' => 13, 'sbp' => 85, 'rr' => 32],
        'Uninjured' => ['gcs' => 15, 'sbp' => 120, 'rr' => 16],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'codes' => ['label' => 'Codes'],
            'triage' => ['label' => 'Triage RTS'],
            'formula' => ['label' => 'Formula'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>RTS = 0.9368 G + 0.7326 S + 0.2908 R</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
