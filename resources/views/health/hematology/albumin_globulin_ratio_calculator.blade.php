<x-calc.page
    title="Albumin Globulin Ratio Calculator - SolveKit"
    description="Free albumin globulin ratio calculator: globulin and the A/G ratio from total protein and albumin."
    lede="Calculate the albumin-to-globulin ratio."
    about="Globulin = total protein − albumin; the A/G ratio = albumin ÷ globulin, normally about 1.0–2.5. A low ratio can come from raised globulins (chronic inflammation, infection, myeloma) or low albumin (liver or kidney disease, malnutrition); a high ratio from low globulins. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-labs', 'tool' => 'ag_ratio', 'fields' => ['protein', 'protein_unit', 'albumin', 'albumin_unit']]"
    :how-to="[
        ['name' => 'Enter total protein', 'text' => ''],
        ['name' => 'Enter albumin', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the A/G ratio for protein 7.5 and albumin 3.2 g/dL?', 'answer' => '0.74: Low (under 1): high globulins (inflammation, myeloma) or low albumin.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="protein" label="Total protein" value="7.5" min="0" step="any" />
        <x-calc.select name="protein_unit" label="Total protein unit" :options="['g/dL' => 'g/dL', 'g/L' => 'g/L']" selected="g/dL" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="albumin" label="Albumin" value="3.2" min="0" step="any" />
        <x-calc.select name="albumin_unit" label="Albumin unit" :options="['g/dL' => 'g/dL', 'g/L' => 'g/L']" selected="g/dL" />
    </div>

    <x-calc.result label="Albumin-to-globulin ratio" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['protein' => 7.5, 'protein_unit' => 'g/dL', 'albumin' => 3.2, 'albumin_unit' => 'g/dL'],
        'Normal' => ['protein' => 72, 'protein_unit' => 'g/L', 'albumin' => 45, 'albumin_unit' => 'g/L'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'globulin' => ['label' => 'Globulin'],
            'formula' => ['label' => 'Formula'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>A/G = albumin ÷ (total − albumin)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
