<x-calc.page
    title="MCA Calculator - SolveKit"
    description="Free MCA Doppler calculator: middle cerebral artery peak systolic velocity as multiples of the median for gestational age, to screen for fetal anaemia (Mari 2000)."
    lede="Convert MCA-PSV to multiples of the median."
    about="Mari et al. (N Engl J Med 2000) showed that fetal anaemia raises blood flow speed in the middle cerebral artery. Median MCA-PSV = e^(2.31 + 0.046 × weeks) cm/s; over 1.5 multiples of the median (MoM) suggests moderate or severe anaemia and leads specialists to consider fetal blood sampling. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-pregnancy', 'tool' => 'mca', 'fields' => ['psv', 'weeks']]"
    :how-to="[
        ['name' => 'Enter the PSV', 'text' => ''],
        ['name' => 'Enter gestational age', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is 45 cm/s at 28 weeks?', 'answer' => '1.23 MoM: Under 1.29 MoM: anaemia unlikely.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="psv" label="MCA peak systolic velocity" value="45" min="0" step="any" suffix="cm/s" />
        <x-calc.field name="weeks" label="Gestational age" value="28" min="18" max="40" step="any" suffix="weeks" />
    </div>

    <x-calc.result label="MCA-PSV multiples of the median" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['psv' => 45, 'weeks' => 28],
        'High' => ['psv' => 70, 'weeks' => 28],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'median' => ['label' => 'Median'],
            'threshold' => ['label' => '1.5 MoM'],
            'source' => ['label' => 'Source'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>median = e^(2.31 + 0.046 GA)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
