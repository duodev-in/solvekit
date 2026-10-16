<x-calc.page
    title="Reverse Complement Calculator - SolveKit"
    description="Free reverse complement tool: reverse complement, complement and reverse of a DNA or RNA sequence."
    lede="Get the reverse complement of a DNA or RNA sequence."
    about="Each base pairs with its partner (A–T or A–U, C–G), and the strand is read in the opposite direction, so the reverse complement is the other strand written 5′ to 3′. N stays N."
    :calc="['engine' => 'sequence', 'tool' => 'reverse_complement', 'fields' => ['sequence']]"
    :how-to="[
        ['name' => 'Paste a sequence', 'text' => 'DNA or RNA.'],
        ['name' => 'Copy the result', 'text' => 'Written 5′ to 3′.'],
    ]"
    :faqs="[
        ['question' => 'What is a reverse complement?', 'answer' => 'The sequence of the opposite strand read 5′ to 3′.'],
        ['question' => 'When do I need it?', 'answer' => 'For reverse primers, probes and reading the other strand.'],
        ['question' => 'Does it handle RNA?', 'answer' => 'Yes, U pairs with A.'],
    ]"
>
    <x-calc.textarea name="sequence" label="DNA or RNA sequence" value="ATGCGTACGTTAGC" placeholder="Paste a sequence (FASTA headers and spaces are ignored)" rows="4" />

    <x-calc.result label="Reverse complement" />

    <x-calc.options :decimals="false" :examples="[
        'Short DNA' => ['sequence' => 'ATGCGTACGTTAGC'],
        'RNA' => ['sequence' => 'AUGGCUACGUAA'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'complement' => ['label' => 'Complement'],
            'reverse' => ['label' => 'Reverse'],
            'length' => ['label' => 'Length'],
            'gc' => ['label' => 'GC content'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>A ↔ T (U), C ↔ G</li>
            <li>read in reverse</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
