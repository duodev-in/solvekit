<x-calc.page
    title="Prostate Volume Calculator - SolveKit"
    description="Free prostate volume calculator: prostate volume from TRUS or MRI length, width and height (ellipsoid formula), with PSA density."
    lede="Calculate prostate volume."
    about="Prostate volume = length × width × height × π ÷ 6 (about 0.52), in cm³ (mL). A normal adult prostate is about 20–30 mL; over 30 mL is generally called enlarged. Dividing PSA by the volume gives PSA density. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-labs', 'tool' => 'prostate', 'fields' => ['length', 'width', 'height', 'psa']]"
    :how-to="[
        ['name' => 'Enter the three dimensions', 'text' => ''],
        ['name' => 'Add PSA', 'text' => 'Optional.'],
    ]"
    :faqs="[
        ['question' => 'What is the volume of a 4.5 × 5 × 4 cm prostate?', 'answer' => '47 mL (PSA density 0.13 ng/mL/mL).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="length" label="Length" value="4.5" min="0" step="any" suffix="cm" />
        <x-calc.field name="width" label="Width" value="5" min="0" step="any" suffix="cm" />
        <x-calc.field name="height" label="Height" value="4" min="0" step="any" suffix="cm" />
    </div>

    <x-calc.field name="psa" label="PSA (optional)" value="6" min="0" step="any" suffix="ng/mL" />

    <x-calc.result label="Prostate volume" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['length' => 4.5, 'width' => 5, 'height' => 4, 'psa' => 6],
        'Normal' => ['length' => 3.5, 'width' => 4, 'height' => 3, 'psa' => 1.2],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'formula' => ['label' => 'Formula'],
            'psad' => ['label' => 'PSA density'],
            'note' => ['label' => 'Note'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>V = L × W × H × π ÷ 6</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
