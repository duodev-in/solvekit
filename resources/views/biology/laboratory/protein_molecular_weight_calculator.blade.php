<x-calc.page
    title="Protein Molecular Weight Calculator - SolveKit"
    description="Free protein molecular weight calculator: kDa from an amino-acid sequence, with the extinction coefficient at 280 nm."
    lede="Work out a protein's molecular weight and extinction coefficient from its sequence."
    about="The molecular weight is the sum of average residue masses plus one water. The extinction coefficient at 280 nm comes from tryptophan (5,500), tyrosine (1,490) and cystine (125) per Pace et al. (1995)."
    :calc="['engine' => 'sequence', 'tool' => 'protein_weight', 'fields' => ['sequence']]"
    :how-to="[
        ['name' => 'Paste the sequence', 'text' => 'One-letter amino-acid codes.'],
        ['name' => 'Read the weight', 'text' => 'In kDa, with ε for A280 measurements.'],
    ]"
    :faqs="[
        ['question' => 'Why is my protein\'s gel band at a different size?', 'answer' => 'SDS-PAGE mobility depends on shape and charge too; the sequence weight is the true mass.'],
        ['question' => 'Does this include modifications?', 'answer' => 'No: glycosylation, phosphorylation and other modifications add mass.'],
        ['question' => 'What is the average amino-acid mass?', 'answer' => 'About 110 Da per residue.'],
    ]"
>
    <x-calc.textarea name="sequence" label="Amino-acid sequence" value="MQIFVKTLTGKTITLEVEPSDTIENVKAKIQDKEGIPPDQQRLIFAGKQLEDGRTLSDYNIQKESTLHLVLRLRGG" placeholder="One-letter codes, e.g. MKT…" rows="4" />

    <x-calc.result label="Molecular weight" />

    <x-calc.options :examples="[
        'Ubiquitin' => ['sequence' => 'MQIFVKTLTGKTITLEVEPSDTIENVKAKIQDKEGIPPDQQRLIFAGKQLEDGRTLSDYNIQKESTLHLVLRLRGG'],
        'Insulin B chain' => ['sequence' => 'FVNQHLCGSHLVEALYLVCGERGFFYTPKT'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'length' => ['label' => 'Length'],
            'epsilon' => ['label' => 'ε at 280 nm'],
            'abs' => ['label' => 'A280 of 1 mg/mL'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>MW = Σ residue masses + 18.02</li>
            <li>ε280 = 5500 × W + 1490 × Y + 125 × cystines</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
