<x-calc.page
    title="PSA Density Calculator - SolveKit"
    description="Free PSA density calculator: PSA divided by prostate volume, with the 0.15 ng/mL/mL threshold used alongside MRI."
    lede="Calculate PSA density."
    about="PSA density (PSAD) = PSA (ng/mL) ÷ prostate volume (mL). Large prostates make more PSA without cancer, so density helps interpret a raised PSA. A PSAD of 0.15 or more is linked with a higher chance of clinically significant cancer; guidelines (EAU 2024) use 0.10–0.20 together with MRI findings. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-labs', 'tool' => 'psa_density', 'fields' => ['psa', 'volume']]"
    :how-to="[
        ['name' => 'Enter PSA', 'text' => ''],
        ['name' => 'Enter prostate volume', 'text' => 'From ultrasound or MRI.'],
    ]"
    :faqs="[
        ['question' => 'What is the PSA density for PSA 6 and a 45 mL prostate?', 'answer' => '0.13 ng/mL/mL ng/mL/mL: Under 0.15: lower chance of clinically significant cancer.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="psa" label="PSA" value="6" min="0" step="any" suffix="ng/mL" />
        <x-calc.field name="volume" label="Prostate volume" value="45" min="0" step="any" suffix="mL" />
    </div>

    <x-calc.result label="PSA density" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['psa' => 6, 'volume' => 45],
        'High' => ['psa' => 8, 'volume' => 30],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'formula' => ['label' => 'Formula'],
            'note' => ['label' => 'Note'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>PSAD = PSA ÷ volume</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
