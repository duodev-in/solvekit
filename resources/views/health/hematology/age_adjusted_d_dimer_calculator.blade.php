<x-calc.page
    title="Age-Adjusted D-dimer Calculator - SolveKit"
    description="Free age-adjusted D-dimer calculator: the age × 10 cut-off for people over 50 (ADJUST-PE), and whether a result is below it."
    lede="Find the age-adjusted D-dimer cut-off."
    about="D-dimer rises with age, so a fixed 500 µg/L cut-off gives many false positives in older people. Righini et al. (JAMA 2014, ADJUST-PE) showed that age × 10 µg/L (FEU) for people over 50 safely excludes pulmonary embolism when the clinical probability is low or “unlikely”. Check whether your lab reports FEU or DDU units. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-labs', 'tool' => 'ddimer', 'fields' => ['age', 'ddimer', 'ddimer_unit']]"
    :how-to="[
        ['name' => 'Enter age', 'text' => ''],
        ['name' => 'Enter the D-dimer and its unit', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'Is a D-dimer of 650 µg/L negative for a 72-year-old?', 'answer' => '650 is below the cut-off: with a low or “unlikely” clinical probability, PE can be excluded.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="age" label="Age" value="72" min="0" step="1" suffix="years" />
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="ddimer" label="D-dimer" value="650" min="0" step="any" />
            <x-calc.select name="ddimer_unit" label="D-dimer unit" :options="['µg/L FEU' => 'µg/L FEU', 'ng/mL FEU' => 'ng/mL FEU', 'mg/L FEU' => 'mg/L FEU']" selected="µg/L FEU" />
        </div>
    </div>

    <x-calc.result label="Age-adjusted cut-off" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['age' => 72, 'ddimer' => 650, 'ddimer_unit' => 'µg/L FEU'],
        'mg/L' => ['age' => 58, 'ddimer' => 0.7, 'ddimer_unit' => 'mg/L FEU'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'standard' => ['label' => 'Standard cut-off'],
            'formula' => ['label' => 'Formula'],
            'source' => ['label' => 'Source'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>cut-off = age × 10 µg/L</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
