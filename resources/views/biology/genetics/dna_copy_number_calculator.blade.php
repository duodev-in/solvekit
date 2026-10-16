<x-calc.page
    title="DNA Copy Number Calculator - SolveKit"
    description="Free DNA copy number calculator: copies of a plasmid or amplicon from mass and length, and copies per µL."
    lede="Work out how many copies of a DNA molecule are in a mass."
    about="Copies = mass ÷ molecular weight × Avogadro's number. The molecular weight of dsDNA is about 618 g/mol per base pair. This is used for qPCR standards and transfection."
    :calc="['engine' => 'sequence', 'tool' => 'copy_number', 'fields' => ['mass', 'length', 'type', 'volume']]"
    :how-to="[
        ['name' => 'Enter the mass', 'text' => 'In ng.'],
        ['name' => 'Enter the length', 'text' => 'Of the plasmid or amplicon.'],
        ['name' => 'Add a volume', 'text' => 'For copies per µL.'],
    ]"
    :faqs="[
        ['question' => 'How many copies in 1 ng of a 3 kb plasmid?', 'answer' => 'About 3 × 10⁸.'],
        ['question' => 'Why does length matter?', 'answer' => 'Longer molecules weigh more, so fewer copies fit in the same mass.'],
        ['question' => 'Does this work for genomic DNA?', 'answer' => 'Yes, using genome size; 3.3 pg of human DNA is about one haploid genome.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="mass" label="DNA amount" value="10" min="0" suffix="ng" />
        <x-calc.field name="length" label="Length" value="3000" min="0" suffix="bp or nt" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="type" label="Type" :options="['dsdna' => 'dsDNA', 'ssdna' => 'ssDNA', 'rna' => 'RNA']" selected="dsdna" />
        <x-calc.field name="volume" label="Volume (optional)" value="20" min="0" suffix="µL" placeholder="Optional" />
    </div>

    <x-calc.result label="Copy number" />

    <x-calc.options :examples="[
        '10 ng of 3 kb plasmid' => ['mass' => 10, 'length' => 3000, 'type' => 'dsdna', 'volume' => 20],
        '1 ng of 150 bp amplicon' => ['mass' => 1, 'length' => 150, 'type' => 'dsdna', 'volume' => 10],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'per_ul' => ['label' => 'Per µL'],
            'moles' => ['label' => 'Amount'],
            'weight' => ['label' => 'Molecular weight used'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>copies = ng × 10⁻⁹ × 6.022 × 10²³ ÷ MW</li>
            <li>dsDNA MW ≈ 617.96 × bp + 36.04</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
