<x-calc.page
    title="Maddrey's Discriminant Function Calculator - SolveKit"
    description="Free Maddrey's discriminant function calculator: severity of alcohol-associated hepatitis from prothrombin time and bilirubin."
    lede="Calculate Maddrey's discriminant function."
    about="Maddrey's discriminant function = 4.6 × (patient PT − control PT, seconds) + bilirubin (mg/dL). A score of 32 or more defines severe alcohol-associated hepatitis with high short-term mortality, when specialists consider corticosteroids; the Lille score at day 7 then checks the response. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-misc', 'tool' => 'maddrey', 'fields' => ['pt', 'control', 'bilirubin', 'bilirubin_unit']]"
    :how-to="[
        ['name' => 'Enter PT and control PT', 'text' => ''],
        ['name' => 'Enter bilirubin', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the DF for PT 20 s (control 12) and bilirubin 8?', 'answer' => '44.8: 32 or more: severe alcohol-associated hepatitis; specialists consider corticosteroids.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="pt" label="Prothrombin time" value="20" min="0" step="any" suffix="s" />
        <x-calc.field name="control" label="Control PT" value="12" min="0" step="any" suffix="s" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="bilirubin" label="Bilirubin" value="8" min="0" step="any" />
        <x-calc.select name="bilirubin_unit" label="Bilirubin unit" :options="['mg/dL' => 'mg/dL', 'µmol/L' => 'µmol/L']" selected="mg/dL" />
    </div>

    <x-calc.result label="Maddrey discriminant function" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['pt' => 20, 'control' => 12, 'bilirubin' => 8, 'bilirubin_unit' => 'mg/dL'],
        'Mild' => ['pt' => 14, 'control' => 12, 'bilirubin' => 60, 'bilirubin_unit' => 'µmol/L'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'formula' => ['label' => 'Formula'],
            'source' => ['label' => 'Source'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>DF = 4.6 × (PT − control) + bilirubin</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
