<x-calc.page
    title="Allele Frequency Calculator - SolveKit"
    description="Free allele frequency calculator: p and q from genotype counts, expected Hardy-Weinberg counts and a chi-square test."
    lede="Work out allele frequencies from genotype counts."
    about="Each AA individual carries two A alleles and each Aa one, so p = (2 × AA + Aa) ÷ 2N and q = 1 − p. The calculator also gives the counts expected under Hardy–Weinberg equilibrium and a 1-degree-of-freedom χ² test."
    :calc="['engine' => 'genetics', 'tool' => 'allele_frequency', 'fields' => ['aa_dom', 'het', 'aa_rec']]"
    :how-to="[
        ['name' => 'Count each genotype', 'text' => 'Homozygous dominant, heterozygous and homozygous recessive.'],
        ['name' => 'Read p and q', 'text' => 'With the expected counts and the χ² test.'],
    ]"
    :faqs="[
        ['question' => 'What is an allele frequency?', 'answer' => 'The share of all copies of a gene in a population that are a particular allele.'],
        ['question' => 'Do p and q always add to 1?', 'answer' => 'Yes, with two alleles.'],
        ['question' => 'What does the χ² test show?', 'answer' => 'Whether the genotype counts differ from Hardy–Weinberg expectations at the 5% level.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="aa_dom" label="AA count" value="360" min="0" step="1" />
        <x-calc.field name="het" label="Aa count" value="480" min="0" step="1" />
        <x-calc.field name="aa_rec" label="aa count" value="160" min="0" step="1" />
    </div>

    <x-calc.result label="Allele frequencies" />

    <x-calc.options :examples="[
        'In equilibrium' => ['aa_dom' => 360, 'het' => 480, 'aa_rec' => 160],
        'Heterozygote deficit' => ['aa_dom' => 450, 'het' => 300, 'aa_rec' => 250],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'expected_dom' => ['label' => 'Expected AA'],
            'expected_het' => ['label' => 'Expected Aa'],
            'expected_rec' => ['label' => 'Expected aa'],
            'het_obs' => ['label' => 'Observed heterozygosity'],
            'hwe' => ['label' => 'Hardy–Weinberg test'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>p = (2 × AA + Aa) ÷ 2N</li>
            <li>q = 1 − p</li>
            <li>χ² = Σ (O − E)² ÷ E, 1 df</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
