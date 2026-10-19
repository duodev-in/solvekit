<x-calc.page
    title="Progesterone to Estrogen Ratio Calculator - SolveKit"
    description="Free progesterone to estrogen ratio calculator: the progesterone-to-estradiol (P/E2) ratio in matching units and as a molar ratio."
    lede="Calculate the progesterone-to-estradiol ratio."
    about="The P/E2 ratio is sometimes quoted in fertility care and hormone discussions, but it has no validated cut-off for diagnosis, and levels change a lot through the menstrual cycle. This page converts both hormones to the same units so the ratio is consistent: progesterone (pg/mL) ÷ estradiol (pg/mL), and nmol/L ÷ nmol/L. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-misc', 'tool' => 'pe2', 'fields' => ['prog', 'prog_unit', 'e2', 'e2_unit']]"
    :how-to="[
        ['name' => 'Enter progesterone', 'text' => ''],
        ['name' => 'Enter estradiol', 'text' => 'From the same blood sample.'],
    ]"
    :faqs="[
        ['question' => 'What is the ratio for progesterone 12 ng/mL and estradiol 150 pg/mL?', 'answer' => '80 (Both in pg/mL; molar ratio 69).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="prog" label="Progesterone" value="12" min="0" step="any" />
        <x-calc.select name="prog_unit" label="Progesterone unit" :options="['ng/mL' => 'ng/mL', 'nmol/L' => 'nmol/L']" selected="ng/mL" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="e2" label="Estradiol" value="150" min="0" step="any" />
        <x-calc.select name="e2_unit" label="Estradiol unit" :options="['pg/mL' => 'pg/mL', 'pmol/L' => 'pmol/L']" selected="pg/mL" />
    </div>

    <x-calc.result label="Progesterone-to-estradiol ratio" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['prog' => 12, 'prog_unit' => 'ng/mL', 'e2' => 150, 'e2_unit' => 'pg/mL'],
        'SI' => ['prog' => 40, 'prog_unit' => 'nmol/L', 'e2' => 600, 'e2_unit' => 'pmol/L'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'conventional' => ['label' => 'ng/mL ÷ pg/mL'],
            'molar' => ['label' => 'Molar ratio'],
            'note' => ['label' => 'Note'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>P (pg/mL) ÷ E2 (pg/mL)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
