<x-calc.page
    title="A1c Calculator – Hemoglobin A1c to Average Blood Sugar - SolveKit"
    description="Free A1c calculator: convert HbA1c to estimated average blood sugar or average glucose to A1c, with the ADA normal, prediabetes and diabetes ranges."
    lede="Convert between A1c and average glucose."
    about="HbA1c reflects average blood glucose over about 3 months. ADAG equation: average glucose = 28.7 × A1c − 46.7 (mg/dL). ADA: below 5.7% normal, 5.7–6.4% prediabetes, 6.5% or more diabetes (confirmed by repeat testing). For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-diet', 'tool' => 'a1c', 'fields' => ['mode', 'a1c', 'a1c_unit', 'avg', 'avg_unit']]"
    :how-to="[
        ['name' => 'Choose the direction', 'text' => ''],
        ['name' => 'Enter the value', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What average glucose is an A1c of 6%?', 'answer' => '125 mg/dL.'],
        ['question' => 'What A1c is an average of 154 mg/dL?', 'answer' => '7.0%.'],
    ]"
>
    <x-calc.segmented name="mode" legend="Convert" :options="['from_a1c' => 'A1c to average glucose', 'from_glucose' => 'Average glucose to A1c']" selected="from_a1c" />

    <div data-show-when="mode:from_a1c">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="a1c" label="HbA1c" value="6" min="3" max="20" step="any" />
            <x-calc.select name="a1c_unit" label="Unit" :options="['%' => '%', 'mmol/mol' => 'mmol/mol']" selected="%" />
        </div>
    </div>

    <div data-show-when="mode:from_glucose" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="avg" label="Average glucose" value="154" min="0" step="any" />
            <x-calc.select name="avg_unit" label="Average glucose unit" :options="['mg/dL' => 'mg/dL', 'mmol/L' => 'mmol/L']" selected="mg/dL" />
        </div>
    </div>

    <x-calc.result label="Estimated average glucose" />

    <x-calc.options :decimals="false" :examples="[
        '6%' => ['mode' => 'from_a1c', 'a1c' => 6, 'a1c_unit' => '%', 'avg' => 154, 'avg_unit' => 'mg/dL'],
        'From 154' => ['mode' => 'from_glucose', 'a1c' => 6, 'a1c_unit' => '%', 'avg' => 154, 'avg_unit' => 'mg/dL'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'eag' => ['label' => 'Average glucose'],
            'ifcc' => ['label' => 'IFCC'],
            'band' => ['label' => 'Band'],
            'target' => ['label' => 'Target'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>eAG = 28.7 × A1c − 46.7</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
