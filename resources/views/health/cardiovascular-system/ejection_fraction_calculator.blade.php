<x-calc.page
    title="Ejection Fraction Calculator - SolveKit"
    description="Free ejection fraction calculator: left ventricular EF from end-diastolic and end-systolic volumes, with the heart failure category (HFrEF, HFmrEF, HFpEF)."
    lede="Calculate ejection fraction."
    about="Ejection fraction = (EDV − ESV) ÷ EDV × 100, the share of blood the ventricle pumps out each beat. The 2022 AHA/ACC/HFSA guideline: 50% or more is normal (HF with preserved EF when symptoms are present), 41–49% mildly reduced and 40% or less reduced. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-clinical', 'tool' => 'ef', 'fields' => ['edv', 'esv']]"
    :how-to="[
        ['name' => 'Enter both volumes', 'text' => 'From echo or MRI.'],
    ]"
    :faqs="[
        ['question' => 'What is the EF with EDV 120 and ESV 50?', 'answer' => '58%: Normal (50% or more).'],
        ['question' => 'And EDV 180, ESV 120?', 'answer' => '33%.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="edv" label="End-diastolic volume" value="120" min="0" step="any" suffix="mL" />
        <x-calc.field name="esv" label="End-systolic volume" value="50" min="0" step="any" suffix="mL" />
    </div>

    <x-calc.result label="Ejection fraction" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['edv' => 120, 'esv' => 50],
        'Reduced' => ['edv' => 180, 'esv' => 120],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'sv' => ['label' => 'Stroke volume'],
            'hf' => ['label' => 'Heart failure category'],
            'source' => ['label' => 'Source'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>EF = (EDV − ESV) ÷ EDV</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
