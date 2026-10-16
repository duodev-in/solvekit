<x-calc.page
    title="DNA to mRNA Converter - SolveKit"
    description="Free DNA to mRNA converter: transcribe a coding or template strand into mRNA, with codons and the protein."
    lede="Transcribe DNA into mRNA and read its codons."
    about="mRNA has the same sequence as the coding (sense) strand with U in place of T. From the template (antisense) strand it is the reverse complement. The protein uses the standard genetic code from the first base."
    :calc="['engine' => 'sequence', 'tool' => 'transcribe', 'fields' => ['sequence', 'strand']]"
    :how-to="[
        ['name' => 'Paste the DNA', 'text' => '5′ to 3′.'],
        ['name' => 'Pick the strand', 'text' => 'Coding (sense) or template (antisense).'],
    ]"
    :faqs="[
        ['question' => 'Which strand is the mRNA copied from?', 'answer' => 'The template strand, so the mRNA matches the coding strand.'],
        ['question' => 'Why U instead of T?', 'answer' => 'RNA uses uracil in place of thymine.'],
        ['question' => 'Does this splice out introns?', 'answer' => 'No, it transcribes the whole sequence.'],
    ]"
>
    <x-calc.textarea name="sequence" label="DNA sequence" value="ATGGCCATTGTAATGGGCCGCTGAAAGGGTGCCCGATAG" placeholder="Paste a sequence (FASTA headers and spaces are ignored)" rows="4" />

    <x-calc.segmented name="strand" legend="This is the" :options="['coding' => 'Coding strand', 'template' => 'Template strand']" selected="coding" />

    <x-calc.result label="mRNA" />

    <x-calc.options :decimals="false" :examples="[
        'Coding strand' => ['sequence' => 'ATGGCCATTGTAATGGGCCGCTGAAAGGGTGCCCGATAG', 'strand' => 'coding'],
        'Template strand' => ['sequence' => 'CTATCGGGCACCCTTTCAGCGGCCCATTACAATGGCCAT', 'strand' => 'template'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'codons' => ['label' => 'Codons'],
            'protein' => ['label' => 'Protein'],
            'length' => ['label' => 'Length'],
            'gc' => ['label' => 'GC content'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>coding strand: mRNA = DNA with T → U</li>
            <li>template strand: mRNA = reverse complement with T → U</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
