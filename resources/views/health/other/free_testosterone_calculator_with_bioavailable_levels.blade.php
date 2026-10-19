<x-calc.page
    title="Free Testosterone Calculator — with Bioavailable Levels - SolveKit"
    description="Free testosterone calculator: calculated free and bioavailable testosterone from total testosterone, SHBG and albumin (Vermeulen equation)."
    lede="Calculate free and bioavailable testosterone."
    about="Most testosterone in blood is bound to SHBG or albumin. The Vermeulen equation (1999), recommended by the Endocrine Society when direct measurement is not available, calculates the free fraction from total testosterone, SHBG and albumin, using binding constants of 1 × 10⁹ L/mol for SHBG and 3.6 × 10⁴ L/mol for albumin. Bioavailable testosterone is the free plus albumin-bound part. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-misc', 'tool' => 'free_t', 'fields' => ['tt', 'tt_unit', 'shbg', 'albumin', 'albumin_unit']]"
    :how-to="[
        ['name' => 'Enter total testosterone', 'text' => ''],
        ['name' => 'Enter SHBG and albumin', 'text' => 'Default albumin 4.3 g/dL.'],
    ]"
    :faqs="[
        ['question' => 'What is the free testosterone for 450 ng/dL with SHBG 35 nmol/L?', 'answer' => '311 pmol/L (8.98 ng/dL; 1.99% of total).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="tt" label="Total testosterone" value="450" min="0" step="any" />
        <x-calc.select name="tt_unit" label="Total testosterone unit" :options="['ng/dL' => 'ng/dL', 'nmol/L' => 'nmol/L']" selected="ng/dL" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="shbg" label="SHBG" value="35" min="0" step="any" suffix="nmol/L" />
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="albumin" label="Albumin" value="4.3" min="0" step="any" />
            <x-calc.select name="albumin_unit" label="Albumin unit" :options="['g/dL' => 'g/dL', 'g/L' => 'g/L']" selected="g/dL" />
        </div>
    </div>

    <x-calc.result label="Calculated free testosterone" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['tt' => 450, 'tt_unit' => 'ng/dL', 'shbg' => 35, 'albumin' => 4.3, 'albumin_unit' => 'g/dL'],
        'SI' => ['tt' => 12, 'tt_unit' => 'nmol/L', 'shbg' => 60, 'albumin' => 42, 'albumin_unit' => 'g/L'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'ngdl' => ['label' => 'In ng/dL'],
            'bio' => ['label' => 'Bioavailable'],
            'note' => ['label' => 'Note'],
            'source' => ['label' => 'Source'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>Vermeulen 1999</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
