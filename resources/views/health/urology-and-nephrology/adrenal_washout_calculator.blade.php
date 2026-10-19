<x-calc.page
    title="Adrenal Washout Calculator - SolveKit"
    description="Free adrenal washout calculator: absolute and relative contrast washout of an adrenal nodule on CT, to help identify an adenoma."
    lede="Calculate adrenal CT washout."
    about="On adrenal protocol CT, absolute washout = (enhanced − delayed) ÷ (enhanced − unenhanced) × 100, and relative washout = (enhanced − delayed) ÷ enhanced × 100, with the delayed scan at 15 minutes. Absolute washout of 60% or more, or relative 40% or more, suggests a benign adenoma (Caoili 2002). An unenhanced density of 10 HU or less already indicates a lipid-rich adenoma. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-labs', 'tool' => 'adrenal_washout', 'fields' => ['unenhanced', 'enhanced', 'delayed']]"
    :how-to="[
        ['name' => 'Enter the three attenuation values', 'text' => 'In Hounsfield units.'],
    ]"
    :faqs="[
        ['question' => 'What washout gives 20, 90 and 40 HU?', 'answer' => '71% absolute: Consistent with an adenoma (absolute 60% or more, or relative 40% or more).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="unenhanced" label="Unenhanced" value="20" min="-100" step="any" suffix="HU" />
        <x-calc.field name="enhanced" label="Enhanced (60–75 s)" value="90" min="-100" step="any" suffix="HU" />
        <x-calc.field name="delayed" label="Delayed (15 min)" value="40" min="-100" step="any" suffix="HU" />
    </div>

    <x-calc.result label="Absolute washout" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['unenhanced' => 20, 'enhanced' => 90, 'delayed' => 40],
        'Not adenoma' => ['unenhanced' => 35, 'enhanced' => 95, 'delayed' => 80],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'relative' => ['label' => 'Relative washout'],
            'unenhanced' => ['label' => 'Unenhanced density'],
            'source' => ['label' => 'Source'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>APW = (E − D) ÷ (E − U)</li>
            <li>RPW = (E − D) ÷ E</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
