<x-calc.page
    title="Testosterone to Estradiol Ratio Calculator - SolveKit"
    description="Free testosterone to estradiol ratio calculator: the T/E2 ratio in conventional units and as a molar ratio."
    lede="Calculate the testosterone-to-estradiol ratio."
    about="The T/E2 ratio is reported in research on male infertility, ageing and obesity, usually as testosterone (ng/dL) ÷ estradiol (pg/mL). There is no agreed reference range, so no diagnosis is given; a specialist interprets it with the individual results. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-misc', 'tool' => 'te2', 'fields' => ['tt', 'tt_unit', 'e2', 'e2_unit']]"
    :how-to="[
        ['name' => 'Enter testosterone', 'text' => ''],
        ['name' => 'Enter estradiol', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the T/E2 ratio for 450 ng/dL and 25 pg/mL?', 'answer' => '18.0 (Testosterone ng/dL ÷ estradiol pg/mL; molar ratio 170).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="tt" label="Testosterone" value="450" min="0" step="any" />
        <x-calc.select name="tt_unit" label="Testosterone unit" :options="['ng/dL' => 'ng/dL', 'nmol/L' => 'nmol/L']" selected="ng/dL" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="e2" label="Estradiol" value="25" min="0" step="any" />
        <x-calc.select name="e2_unit" label="Estradiol unit" :options="['pg/mL' => 'pg/mL', 'pmol/L' => 'pmol/L']" selected="pg/mL" />
    </div>

    <x-calc.result label="Testosterone-to-estradiol ratio" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['tt' => 450, 'tt_unit' => 'ng/dL', 'e2' => 25, 'e2_unit' => 'pg/mL'],
        'SI' => ['tt' => 15, 'tt_unit' => 'nmol/L', 'e2' => 110, 'e2_unit' => 'pmol/L'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'molar' => ['label' => 'Molar ratio'],
            'note' => ['label' => 'Note'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>T (ng/dL) ÷ E2 (pg/mL)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
