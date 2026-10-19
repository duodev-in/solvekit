<x-calc.page
    title="QUICKI Calculator - SolveKit"
    description="Free QUICKI calculator: the quantitative insulin sensitivity check index from fasting glucose and insulin."
    lede="Calculate QUICKI insulin sensitivity."
    about="QUICKI = 1 ÷ (log₁₀ fasting insulin µU/mL + log₁₀ fasting glucose mg/dL) (Katz et al. 2000). Lower values mean more insulin resistance; Katz reported about 0.37 in non-obese, 0.33 in obese and 0.30 in diabetic adults. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-diet', 'tool' => 'quicki', 'fields' => ['glucose', 'glucose_unit', 'insulin', 'insulin_unit']]"
    :how-to="[
        ['name' => 'Enter fasting glucose and insulin', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is QUICKI for glucose 95 mg/dL and insulin 10 µU/mL?', 'answer' => '0.336.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="glucose" label="Fasting glucose" value="95" min="0" step="any" />
        <x-calc.select name="glucose_unit" label="Fasting glucose unit" :options="['mg/dL' => 'mg/dL', 'mmol/L' => 'mmol/L']" selected="mg/dL" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="insulin" label="Fasting insulin" value="10" min="0" step="any" />
        <x-calc.select name="insulin_unit" label="Fasting insulin unit" :options="['µU/mL' => 'µU/mL', 'pmol/L' => 'pmol/L']" selected="µU/mL" />
    </div>

    <x-calc.result label="QUICKI" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['glucose' => 95, 'glucose_unit' => 'mg/dL', 'insulin' => 10, 'insulin_unit' => 'µU/mL'],
        'Low' => ['glucose' => 110, 'glucose_unit' => 'mg/dL', 'insulin' => 25, 'insulin_unit' => 'µU/mL'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'formula' => ['label' => 'Formula'],
            'reference' => ['label' => 'Reference values'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>QUICKI = 1 ÷ (log I + log G)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
