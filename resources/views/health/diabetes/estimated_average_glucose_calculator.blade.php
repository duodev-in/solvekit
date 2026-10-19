<x-calc.page
    title="Estimated Average Glucose Calculator - SolveKit"
    description="Free eAG calculator: estimated average glucose in mg/dL and mmol/L from an HbA1c result, with the IFCC value."
    lede="Turn A1c into average glucose."
    about="The ADAG study (Nathan et al. 2008) linked HbA1c to average glucose: eAG (mg/dL) = 28.7 × A1c − 46.7. IFCC units: mmol/mol = (A1c% − 2.15) × 10.929. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-diet', 'tool' => 'eag', 'fields' => ['a1c', 'a1c_unit']]"
    :how-to="[
        ['name' => 'Enter the A1c', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What average glucose is an A1c of 7%?', 'answer' => '154 mg/dL.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="a1c" label="HbA1c" value="7" min="3" max="20" step="any" />
        <x-calc.select name="a1c_unit" label="Unit" :options="['%' => '% (NGSP)', 'mmol/mol' => 'mmol/mol (IFCC)']" selected="%" />
    </div>

    <x-calc.result label="Estimated average glucose" />

    <x-calc.options :decimals="false" :examples="[
        '7%' => ['a1c' => 7, 'a1c_unit' => '%'],
        '53 mmol/mol' => ['a1c' => 53, 'a1c_unit' => 'mmol/mol'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'eag' => ['label' => 'eAG'],
            'ifcc' => ['label' => 'IFCC'],
            'band' => ['label' => 'Band'],
            'ci' => ['label' => 'Range'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>eAG = 28.7 × A1c − 46.7</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
