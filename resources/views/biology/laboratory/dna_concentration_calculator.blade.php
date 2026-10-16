<x-calc.page
    title="DNA Concentration Calculator - SolveKit"
    description="Free DNA concentration calculator: µg/mL of dsDNA, ssDNA or RNA from A260, with yield and A260/A280 purity."
    lede="Work out DNA or RNA concentration and purity from absorbance."
    about="An A260 of 1.0 (1 cm path) is about 50 µg/mL of double-stranded DNA, 33 µg/mL of single-stranded DNA or 40 µg/mL of RNA. An A260/A280 ratio of about 1.8 suggests pure DNA and about 2.0 pure RNA."
    :calc="['engine' => 'lab', 'tool' => 'dna_concentration', 'fields' => ['type', 'a260', 'a280', 'dilution', 'volume']]"
    :how-to="[
        ['name' => 'Pick the type', 'text' => 'dsDNA, ssDNA or RNA.'],
        ['name' => 'Enter the readings', 'text' => 'A260 and, for purity, A280.'],
        ['name' => 'Enter the dilution', 'text' => '1 if you measured undiluted.'],
    ]"
    :faqs="[
        ['question' => 'What A260/A280 ratio is pure?', 'answer' => 'About 1.8 for DNA and 2.0 for RNA.'],
        ['question' => 'Why is a low ratio a problem?', 'answer' => 'Proteins absorb at 280 nm, so a ratio well below 1.8 suggests protein or phenol contamination.'],
        ['question' => 'Is A260 reliable for small amounts?', 'answer' => 'Below about 10 ng/µL use a dye-based assay such as Qubit or PicoGreen.'],
    ]"
>
    <x-calc.select name="type" label="Nucleic acid" :options="['dsdna' => 'dsDNA', 'ssdna' => 'ssDNA', 'rna' => 'RNA']" selected="dsdna" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="a260" label="A260" value="0.5" min="0" />
        <x-calc.field name="a280" label="A280 (optional)" value="0.27" min="0" placeholder="Optional" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="dilution" label="Dilution factor" value="10" min="0" />
        <x-calc.field name="volume" label="Sample volume (optional)" value="50" min="0" suffix="µL" placeholder="Optional" />
    </div>

    <x-calc.result label="Concentration" />

    <x-calc.options :examples="[
        'Plasmid 1:10' => ['type' => 'dsdna', 'a260' => 0.5, 'a280' => 0.27, 'dilution' => 10],
        'RNA 1:50' => ['type' => 'rna', 'a260' => 0.21, 'a280' => 0.1, 'dilution' => 50],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'ng' => ['label' => 'Same as'],
            'yield' => ['label' => 'Total yield'],
            'purity' => ['label' => 'A260/A280'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>dsDNA µg/mL = A260 × 50 × dilution</li>
            <li>ssDNA ×33 · RNA ×40</li>
            <li>purity = A260 ÷ A280</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
