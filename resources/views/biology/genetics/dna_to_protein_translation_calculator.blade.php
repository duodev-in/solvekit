<x-calc.page
    title="DNA to Protein Translation Calculator - SolveKit"
    description="Free DNA to protein translation tool: translate DNA or mRNA in all six reading frames with the standard genetic code."
    lede="Translate DNA or mRNA into protein in any of the six reading frames."
    about="Each three-base codon codes for one amino acid under the standard genetic code (NCBI table 1); * marks a stop codon. Frames +1 to +3 start at bases 1 to 3; frames −1 to −3 read the reverse complement."
    :calc="['engine' => 'sequence', 'tool' => 'translate', 'fields' => ['sequence', 'frame']]"
    :how-to="[
        ['name' => 'Paste DNA or mRNA', 'text' => 'T or U both work.'],
        ['name' => 'Pick a frame', 'text' => 'All six are shown on the right.'],
    ]"
    :faqs="[
        ['question' => 'What does * mean?', 'answer' => 'A stop codon (TAA, TAG or TGA).'],
        ['question' => 'How do I find the open reading frame?', 'answer' => 'Look for the frame with a long stretch from M (ATG) without *.'],
        ['question' => 'Which genetic code is used?', 'answer' => 'The standard code; mitochondria and some organisms differ.'],
    ]"
>
    <x-calc.textarea name="sequence" label="DNA or RNA sequence" value="ATGGCCATTGTAATGGGCCGCTGAAAGGGTGCCCGATAG" placeholder="Paste a sequence (FASTA headers and spaces are ignored)" rows="4" />

    <x-calc.select name="frame" label="Reading frame" :options="['0' => '+1', '1' => '+2', '2' => '+3', '3' => '−1', '4' => '−2', '5' => '−3']" selected="0" />

    <x-calc.result label="Protein" />

    <x-calc.options :decimals="false" :examples="[
        'Short ORF' => ['sequence' => 'ATGGCCATTGTAATGGGCCGCTGAAAGGGTGCCCGATAG', 'frame' => '0'],
        'Reverse frame' => ['sequence' => 'CTATCGGGCACCCTTTCAGCGGCCCATTACAATGGCCAT', 'frame' => '3'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="All six frames" :grow="true" :rows="[
            'f0' => ['label' => 'Frame +1'],
            'f1' => ['label' => 'Frame +2'],
            'f2' => ['label' => 'Frame +3'],
            'f3' => ['label' => 'Frame −1'],
            'f4' => ['label' => 'Frame −2'],
            'f5' => ['label' => 'Frame −3'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>codon → amino acid (standard code)</li>
            <li>frames −1 to −3 use the reverse complement</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
