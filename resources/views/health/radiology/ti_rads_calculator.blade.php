<x-calc.page
    title="TI-RADS Calculator - SolveKit"
    description="Free TI-RADS calculator: ACR TI-RADS points and level (TR1–TR5) for a thyroid nodule on ultrasound, with the size thresholds for FNA and follow-up."
    lede="Score a thyroid nodule with ACR TI-RADS."
    about="ACR TI-RADS (Tessler et al. 2017) adds points for composition, echogenicity, shape, margin and echogenic foci: 0–1 TR1 (benign), 2 TR2, 3 TR3, 4–6 TR4 and 7 or more TR5. Fine-needle aspiration is advised from 2.5 cm for TR3, 1.5 cm for TR4 and 1 cm for TR5, with follow-up scans for smaller nodules above 1.5, 1.0 and 0.5 cm. For radiologists and clinicians. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-misc', 'tool' => 'tirads', 'fields' => ['composition', 'echogenicity', 'shape', 'margin', 'macro', 'rim', 'punctate', 'size']]"
    :how-to="[
        ['name' => 'Choose each feature', 'text' => ''],
        ['name' => 'Enter the nodule size', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What level is a solid, hypoechoic, smooth 1.8 cm nodule?', 'answer' => 'TR4: 4 points. FNA advised (1.8 cm ≥ 1.5 cm).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="composition" label="Composition" :options="['0' => 'Cystic or almost completely cystic (0)', 'spongiform' => 'Spongiform (0)', '1' => 'Mixed cystic and solid (1)', '2' => 'Solid or almost completely solid (2)']" selected="2" />
        <x-calc.select name="echogenicity" label="Echogenicity" :options="['0' => 'Anechoic (0)', '1' => 'Hyperechoic or isoechoic (1)', '2' => 'Hypoechoic (2)', '3' => 'Very hypoechoic (3)']" selected="2" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="shape" label="Shape" :options="['0' => 'Wider than tall (0)', '3' => 'Taller than wide (3)']" selected="0" />
        <x-calc.select name="margin" label="Margin" :options="['0' => 'Smooth or ill-defined (0)', '2' => 'Lobulated or irregular (2)', '3' => 'Extrathyroidal extension (3)']" selected="0" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.checkbox name="macro" label="Macrocalcifications (1)" :checked="false" />
        <x-calc.checkbox name="rim" label="Peripheral (rim) calcifications (2)" :checked="false" />
        <x-calc.checkbox name="punctate" label="Punctate echogenic foci (3)" :checked="false" />
    </div>

    <x-calc.field name="size" label="Maximum diameter" value="1.8" min="0" step="any" suffix="cm" />

    <x-calc.result label="ACR TI-RADS level" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['composition' => '2', 'echogenicity' => '2', 'shape' => '0', 'margin' => '0', 'macro' => false, 'rim' => false, 'punctate' => false, 'size' => 1.8],
        'Suspicious' => ['composition' => '2', 'echogenicity' => '3', 'shape' => '3', 'margin' => '2', 'macro' => false, 'rim' => false, 'punctate' => true, 'size' => 0.8],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'points' => ['label' => 'Points'],
            'action' => ['label' => 'Recommendation'],
            'thresholds' => ['label' => 'Size thresholds'],
            'source' => ['label' => 'Source'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>TR level from total points</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
