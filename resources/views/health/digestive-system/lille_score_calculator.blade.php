<x-calc.page
    title="Lille Score Calculator - SolveKit"
    description="Free Lille score calculator: response to corticosteroids at day 7 in severe alcohol-associated hepatitis."
    lede="Calculate the Lille score."
    about="The Lille model (Louvet et al. 2007) uses age, albumin, bilirubin on day 0 and day 7, kidney function and prothrombin time. A score of 0.45 or more after 7 days of corticosteroids means no response, with about 25% 6-month survival, and specialists usually stop the steroids; under 0.45 means response (about 85%). For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-misc', 'tool' => 'lille', 'fields' => ['age', 'albumin', 'albumin_unit', 'bili0', 'bili0_unit', 'bili7', 'bili7_unit', 'pt', 'renal']]"
    :how-to="[
        ['name' => 'Enter age and albumin', 'text' => ''],
        ['name' => 'Enter bilirubin on days 0 and 7', 'text' => ''],
        ['name' => 'Enter PT and kidney function', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the Lille score when bilirubin falls from 15 to 10 mg/dL?', 'answer' => '0.14: Under 0.45: response to corticosteroids (6-month survival about 85%).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="age" label="Age" value="50" min="0" step="1" suffix="years" />
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="albumin" label="Albumin (day 0)" value="2.8" min="0" step="any" />
            <x-calc.select name="albumin_unit" label="Albumin (day 0) unit" :options="['g/dL' => 'g/dL', 'g/L' => 'g/L']" selected="g/dL" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="bili0" label="Bilirubin day 0" value="15" min="0" step="any" />
        <x-calc.select name="bili0_unit" label="Bilirubin day 0 unit" :options="['mg/dL' => 'mg/dL', 'µmol/L' => 'µmol/L']" selected="mg/dL" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="bili7" label="Bilirubin day 7" value="10" min="0" step="any" />
        <x-calc.select name="bili7_unit" label="Bilirubin day 7 unit" :options="['mg/dL' => 'mg/dL', 'µmol/L' => 'µmol/L']" selected="mg/dL" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="pt" label="Prothrombin time" value="18" min="0" step="any" suffix="s" />
        <x-calc.checkbox name="renal" label="Creatinine over 1.3 mg/dL (115 µmol/L)" :checked="false" />
    </div>

    <x-calc.result label="Lille score" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['age' => 50, 'albumin' => 2.8, 'albumin_unit' => 'g/dL', 'bili0' => 15, 'bili0_unit' => 'mg/dL', 'bili7' => 10, 'bili7_unit' => 'mg/dL', 'pt' => 18, 'renal' => false],
        'No response' => ['age' => 55, 'albumin' => 2.5, 'albumin_unit' => 'g/dL', 'bili0' => 20, 'bili0_unit' => 'mg/dL', 'bili7' => 21, 'bili7_unit' => 'mg/dL', 'pt' => 22, 'renal' => true],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'formula' => ['label' => 'Formula'],
            'source' => ['label' => 'Source'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>Lille = e^−R ÷ (1 + e^−R)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
