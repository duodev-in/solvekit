<x-calc.page
    title="Light's Criteria Calculator for Pleural Effusion - SolveKit"
    description="Free Light's criteria calculator: whether a pleural effusion is an exudate or a transudate from pleural and serum protein and LDH."
    lede="Classify a pleural effusion."
    about="Light's criteria (Light et al. 1972): the fluid is an exudate if any one is met: pleural/serum protein over 0.5, pleural/serum LDH over 0.6, or pleural LDH over two-thirds of the upper limit of normal serum LDH. They are sensitive for exudates but can misclassify transudates in people on diuretics. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-clinical', 'tool' => 'lights', 'fields' => ['pleural_protein', 'serum_protein', 'pleural_ldh', 'serum_ldh', 'ldh_uln']]"
    :how-to="[
        ['name' => 'Enter pleural and serum protein', 'text' => 'Same units for both.'],
        ['name' => 'Enter pleural and serum LDH', 'text' => 'And the lab\'s upper limit.'],
    ]"
    :faqs="[
        ['question' => 'Is fluid with protein 3.5/6.5 and LDH 250/200 an exudate?', 'answer' => 'Exudate: 3 of 3 criteria met (any one means exudate).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="pleural_protein" label="Pleural protein" value="3.5" min="0" step="any" suffix="g/dL" />
        <x-calc.field name="serum_protein" label="Serum protein" value="6.5" min="0" step="any" suffix="g/dL" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="pleural_ldh" label="Pleural LDH" value="250" min="0" step="any" suffix="U/L" />
        <x-calc.field name="serum_ldh" label="Serum LDH" value="200" min="0" step="any" suffix="U/L" />
        <x-calc.field name="ldh_uln" label="Serum LDH upper limit" value="222" min="0" step="any" suffix="U/L" />
    </div>

    <x-calc.result label="Light's criteria" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['pleural_protein' => 3.5, 'serum_protein' => 6.5, 'pleural_ldh' => 250, 'serum_ldh' => 200, 'ldh_uln' => 222],
        'Transudate' => ['pleural_protein' => 1.8, 'serum_protein' => 6.8, 'pleural_ldh' => 90, 'serum_ldh' => 210, 'ldh_uln' => 222],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'note' => ['label' => 'What it means'],
            'source' => ['label' => 'Source'],
        ]" />
        <x-calc.grid heading="Criteria" name="criteria" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>exudate if any criterion is met</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
