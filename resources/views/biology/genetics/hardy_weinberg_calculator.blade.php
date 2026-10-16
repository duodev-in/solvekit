<x-calc.page
    title="Hardy–Weinberg Equilibrium Calculator - SolveKit"
    description="Free Hardy-Weinberg calculator: genotype frequencies p², 2pq and q² from p, q or the share of recessive individuals, with carrier frequency."
    lede="Work out genotype frequencies and carriers under Hardy–Weinberg equilibrium."
    about="In a large, randomly mating population with no selection, mutation or migration, genotype frequencies stay at p², 2pq and q². Knowing the share of recessive individuals (q²) gives q, and from it the carrier frequency 2pq."
    :calc="['engine' => 'genetics', 'tool' => 'hardy_weinberg', 'fields' => ['mode', 'recessive', 'p', 'q', 'population']]"
    :how-to="[
        ['name' => 'Choose a starting value', 'text' => 'Often the share of people showing a recessive trait.'],
        ['name' => 'Add a population size', 'text' => 'To see expected numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the Hardy–Weinberg equation?', 'answer' => 'p² + 2pq + q² = 1, with p + q = 1.'],
        ['question' => 'How do I find carriers of a recessive disease?', 'answer' => 'Take q = √(share affected), then carriers = 2pq. For 1 in 2,500 affected, about 1 in 26 are carriers.'],
        ['question' => 'What breaks equilibrium?', 'answer' => 'Selection, mutation, migration, small populations and non-random mating.'],
    ]"
>
    <x-calc.segmented name="mode" legend="Start from" :options="['recessive' => 'Recessive share q²', 'p' => 'p', 'q' => 'q']" selected="recessive" />

    <div data-show-when="mode:recessive">
        <x-calc.field name="recessive" label="Recessive individuals" value="4" min="0" max="100" suffix="%" />
    </div>

    <div data-show-when="mode:p" hidden>
        <x-calc.field name="p" label="Dominant allele frequency p" value="0.7" min="0" max="1" />
    </div>

    <div data-show-when="mode:q" hidden>
        <x-calc.field name="q" label="Recessive allele frequency q" value="0.3" min="0" max="1" />
    </div>

    <x-calc.field name="population" label="Population size (optional)" value="1000" min="0" step="1" placeholder="Optional" />

    <x-calc.result label="p² : 2pq : q²" />

    <x-calc.options :examples="[
        '1 in 2,500 affected' => ['mode' => 'recessive', 'recessive' => 0.04, 'population' => 10000],
        'p = 0.6' => ['mode' => 'p', 'p' => 0.6, 'population' => 1000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'dom' => ['label' => 'Homozygous dominant p²'],
            'het' => ['label' => 'Carriers 2pq'],
            'rec' => ['label' => 'Homozygous recessive q²'],
            'carriers' => ['label' => 'Carrier frequency'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>p² + 2pq + q² = 1</li>
            <li>q = √(q²), p = 1 − q</li>
            <li>carriers = 2pq</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
