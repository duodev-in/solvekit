<x-calc.page
    title="Mesh to Micron Converter - SolveKit"
    description="Professional mesh to micron converter for particle size analysis. Convert US standard mesh sizes to microns for industrial screening and filtration applications."
    lede="Convert US sieve mesh numbers to opening size in microns, or find the sieve for a particle size."
    about="Standard US sieve numbers are looked up in the ASTM E11 table of nominal openings. For a mesh count that is not a standard sieve, the opening is estimated as 14,900 ÷ mesh, which ignores wire thickness and is only approximate."
    :calc="['engine' => 'mesh-to-micron']"
    :how-to="[
        ['name' => 'Choose a direction', 'text' => 'Mesh to microns, or microns to the nearest standard sieve.'],
        ['name' => 'Enter the value', 'text' => 'The table on the right shows the neighbouring standard sieves.'],
    ]"
    :faqs="[
        ['question' => 'What does mesh number mean?', 'answer' => 'The number of openings per linear inch of screen. Higher mesh numbers have smaller openings.'],
        ['question' => 'How many microns is a 200 mesh sieve?', 'answer' => 'A US No. 200 sieve has a nominal opening of 75 µm.'],
        ['question' => 'Why is the estimate different from the table?', 'answer' => 'Opening size depends on wire diameter, which the 14,900 ÷ mesh rule of thumb ignores. Standard sieves always use the ASTM E11 value.'],
    ]"
>
    <x-calc.segmented name="direction" legend="Direction" :options="['mesh' => 'Mesh → Microns', 'micron' => 'Microns → Mesh']" selected="mesh" />

    <x-calc.field name="value" label="Value" value="200" min="0" suffix="mesh" suffix-ref="value-suffix" placeholder="Enter a value" />

    <x-calc.result label="Sieve opening" />

    <x-calc.options :examples="[
        'No. 4 (gravel)' => ['value' => 4, 'direction' => 'mesh'],
        'No. 100' => ['value' => 100, 'direction' => 'mesh'],
        '45 µm powder' => ['value' => 45, 'direction' => 'micron'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Opening size in" :rows="[
            'mm' => ['label' => 'Millimeters', 'unit' => 'mm'],
            'in' => ['label' => 'Inches', 'unit' => 'in'],
        ]" />
        <x-calc.quick-ref heading="Nearby standard sieves (ASTM E11)" name="sieves" :columns="2" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>standard sieve: opening from the ASTM E11 table</li>
            <li>other mesh: opening ≈ 14,900 ÷ mesh µm</li>
            <li>1 mm = 1,000 µm · 1 in = 25,400 µm</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
