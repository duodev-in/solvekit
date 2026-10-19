<x-calc.page
    title="Fish Oil Calculator - SolveKit"
    description="Free fish oil calculator: EPA + DHA per day from your supplement label, compared with EFSA, AHA and FDA reference amounts."
    lede="Check the EPA and DHA in your fish oil."
    about="Labels list EPA and DHA per serving (often less than the “1,000 mg fish oil” on the front). EFSA suggests 250 mg EPA + DHA a day for healthy adults; the AHA suggests about 1 g a day for people with heart disease under medical care; the FDA considers up to 5 g a day from supplements safe. This is label arithmetic, not a prescription. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-diet', 'tool' => 'fish_oil', 'fields' => ['epa', 'dha', 'servings']]"
    :how-to="[
        ['name' => 'Copy EPA and DHA from the label', 'text' => ''],
        ['name' => 'Enter servings a day', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How much EPA + DHA do two capsules of 180 + 120 mg give?', 'answer' => '600 mg.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="epa" label="EPA per serving" value="180" min="0" step="any" suffix="mg" />
        <x-calc.field name="dha" label="DHA per serving" value="120" min="0" step="any" suffix="mg" />
        <x-calc.field name="servings" label="Servings a day" value="2" min="0" step="1" />
    </div>

    <x-calc.result label="EPA + DHA a day" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['epa' => 180, 'dha' => 120, 'servings' => 2],
        'Concentrate' => ['epa' => 650, 'dha' => 450, 'servings' => 1],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'efsa' => ['label' => 'EFSA'],
            'aha' => ['label' => 'AHA'],
            'fda' => ['label' => 'FDA'],
            'food' => ['label' => 'From food'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>EPA + DHA × servings</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
