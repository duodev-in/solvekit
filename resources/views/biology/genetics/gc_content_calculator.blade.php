<x-calc.page
    title="GC Content Calculator - SolveKit"
    description="Free GC content calculator: percent GC, base counts and melting temperature of a DNA or RNA sequence."
    lede="Work out GC content and base counts of a sequence."
    about="GC content is the share of G and C bases. G–C pairs have three hydrogen bonds against two for A–T, so GC-rich DNA melts at a higher temperature. Primers usually aim for 40 to 60% GC. Unknown bases (N) are left out."
    :calc="['engine' => 'sequence', 'tool' => 'gc_content', 'fields' => ['sequence']]"
    :how-to="[
        ['name' => 'Paste a sequence', 'text' => 'DNA or RNA.'],
        ['name' => 'Read GC%', 'text' => 'With base counts and, for oligos, a Tm.'],
    ]"
    :faqs="[
        ['question' => 'What GC content is good for primers?', 'answer' => '40 to 60%.'],
        ['question' => 'Why does GC content affect Tm?', 'answer' => 'G–C pairs are bound by three hydrogen bonds and stack more strongly.'],
        ['question' => 'What is the human genome\'s GC content?', 'answer' => 'About 41%.'],
    ]"
>
    <x-calc.textarea name="sequence" label="DNA or RNA sequence" value="AGCGGATAACAATTTCACACAGGA" placeholder="Paste a sequence (FASTA headers and spaces are ignored)" rows="4" />

    <x-calc.result label="GC content" />

    <x-calc.options :examples="[
        'M13 reverse primer' => ['sequence' => 'AGCGGATAACAATTTCACACAGGA'],
        'GC-rich' => ['sequence' => 'GCGGCCGCGGGCCCGC'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'at' => ['label' => 'AT content'],
            'a' => ['label' => 'A'],
            't' => ['label' => 'T or U'],
            'g' => ['label' => 'G'],
            'c' => ['label' => 'C'],
            'tm' => ['label' => 'Tm estimate'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>GC% = (G + C) ÷ (A + T + G + C) × 100</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
