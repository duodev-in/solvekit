<x-calc.page
    title="Mutation Rate Calculator - SolveKit"
    description="Free mutation rate calculator: mutations per cell per division from a Luria-Delbrück fluctuation test using the p0 method."
    lede="Estimate the mutation rate from a fluctuation test (p₀ method)."
    about="In a Luria–Delbrück fluctuation test many parallel cultures are plated on selective medium. The share of cultures with no mutants, p₀, gives the mean number of mutations per culture m = −ln p₀, and the rate is m ÷ cells per culture. The p₀ method works best when p₀ is between about 0.1 and 0.7."
    :calc="['engine' => 'genetics', 'tool' => 'mutation_rate', 'fields' => ['cultures', 'without', 'cells']]"
    :how-to="[
        ['name' => 'Run parallel cultures', 'text' => 'Many small cultures from a few cells each.'],
        ['name' => 'Count empty plates', 'text' => 'Cultures that gave no mutant colonies.'],
        ['name' => 'Enter cells per culture', 'text' => 'The final viable count.'],
    ]"
    :faqs="[
        ['question' => 'Why use the p₀ method?', 'answer' => 'It only needs to know whether each culture had mutants, so jackpots do not distort it.'],
        ['question' => 'What if every culture has mutants?', 'answer' => 'Use fewer cells per culture, or another method such as MSS maximum likelihood.'],
        ['question' => 'Who devised the test?', 'answer' => 'Luria and Delbrück in 1943, showing mutations arise before selection.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="cultures" label="Cultures tested" value="20" min="1" step="1" />
        <x-calc.field name="without" label="Cultures with no mutants" value="8" min="0" step="1" />
    </div>

    <x-calc.field name="cells" label="Cells per culture (final)" value="200000000" min="0" />

    <x-calc.result label="Mutation rate" />

    <x-calc.options :examples="[
        '8 of 20 empty' => ['cultures' => 20, 'without' => 8, 'cells' => 200000000],
        '30 of 48 empty' => ['cultures' => 48, 'without' => 30, 'cells' => 100000000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'm' => ['label' => 'Mutations per culture m'],
            'p0' => ['label' => 'Share without mutants p₀'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>p₀ = cultures without mutants ÷ cultures</li>
            <li>m = −ln p₀</li>
            <li>μ = m ÷ N</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
