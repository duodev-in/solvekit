<x-calc.page
    title="Pearl Index Calculator - SolveKit"
    description="Free Pearl index calculator: contraceptive failure rate as pregnancies per 100 woman-years from a study's pregnancies, women and months of use."
    lede="Calculate the Pearl index."
    about="The Pearl index (Raymond Pearl, 1933) = number of pregnancies × 1,200 ÷ total months of exposure (or × 1,300 ÷ cycles). An index of 1 means 1 pregnancy per 100 women using the method for a year. It falls with longer studies, as the most fertile users conceive early, so life-table rates are preferred for comparisons. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-pregnancy', 'tool' => 'pearl', 'fields' => ['pregnancies', 'women', 'months']]"
    :how-to="[
        ['name' => 'Enter pregnancies', 'text' => ''],
        ['name' => 'Enter women and months', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the Pearl index for 3 pregnancies in 500 women over 12 months?', 'answer' => '0.60.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="pregnancies" label="Pregnancies" value="3" min="0" step="1" />
        <x-calc.field name="women" label="Women in the study" value="500" min="1" step="1" />
        <x-calc.field name="months" label="Months of use each" value="12" min="1" step="any" suffix="months" />
    </div>

    <x-calc.result label="Pearl index" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['pregnancies' => 3, 'women' => 500, 'months' => 12],
        'Condom study' => ['pregnancies' => 40, 'women' => 400, 'months' => 6],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'formula' => ['label' => 'Formula'],
            'note' => ['label' => 'Note'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>PI = pregnancies × 1,200 ÷ months</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
