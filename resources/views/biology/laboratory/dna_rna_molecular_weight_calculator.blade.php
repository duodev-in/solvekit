<x-calc.page
    title="DNA and RNA Molecular Weight Calculator - SolveKit"
    description="Free DNA and RNA molecular weight calculator: g/mol from a sequence or length for dsDNA, ssDNA and RNA."
    lede="Work out the molecular weight of DNA or RNA from its sequence or length."
    about="From a sequence the weight is the sum of the nucleotide masses. From a length it uses average masses: 617.96 g/mol per base pair for dsDNA, 308.97 per base for ssDNA and 320.5 per base for RNA, plus the ends."
    :calc="['engine' => 'sequence', 'tool' => 'nucleic_weight', 'fields' => ['mode', 'type', 'sequence', 'length']]"
    :how-to="[
        ['name' => 'Choose sequence or length', 'text' => 'Sequence is exact; length uses averages.'],
        ['name' => 'Pick the type', 'text' => 'dsDNA, ssDNA or RNA.'],
    ]"
    :faqs="[
        ['question' => 'What is the weight of 1 kb of dsDNA?', 'answer' => 'About 618 kDa (618,000 g/mol).'],
        ['question' => 'How many pmol in 1 µg of a 1 kb fragment?', 'answer' => 'About 1.6 pmol.'],
        ['question' => 'Does this include a 5′ phosphate?', 'answer' => 'No, the sequence weight assumes a 5′ hydroxyl as in synthetic oligos.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.segmented name="mode" legend="From" :options="['sequence' => 'Sequence', 'length' => 'Length']" selected="sequence" />
        <x-calc.select name="type" label="Type" :options="['dsdna' => 'dsDNA', 'ssdna' => 'ssDNA', 'rna' => 'RNA']" selected="dsdna" />
    </div>

    <div data-show-when="mode:sequence">
        <x-calc.textarea name="sequence" label="DNA or RNA sequence" value="ATGGCCATTGTAATGGGCCGCTGAAAGGGTGCCCGATAG" placeholder="Paste a sequence (FASTA headers and spaces are ignored)" rows="4" />
    </div>

    <div data-show-when="mode:length" hidden>
        <x-calc.field name="length" label="Length" value="1000" min="0" suffix="bp or nt" />
    </div>

    <x-calc.result label="Molecular weight" />

    <x-calc.options :examples="[
        '1 kb dsDNA' => ['mode' => 'length', 'type' => 'dsdna', 'length' => 1000],
        '20-mer primer' => ['mode' => 'sequence', 'type' => 'ssdna', 'sequence' => 'TAATACGACTCACTATAGGG'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'kda' => ['label' => 'In kDa'],
            'per_ug' => ['label' => 'Amount in 1 µg'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>dsDNA ≈ 617.96 × bp + 36.04</li>
            <li>ssDNA ≈ 308.97 × nt + 18.02</li>
            <li>RNA ≈ 320.5 × nt + 159</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
