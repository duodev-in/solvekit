<x-calc.page
    title="Mutation Frequency Calculator - SolveKit"
    description="Free mutation frequency calculator: mutants per viable cell and per million cells from colony counts."
    lede="Work out mutation frequency from mutant and viable cell counts."
    about="Mutation frequency is the share of mutants in a population at one time: mutant colonies on selective plates ÷ viable cells on non-selective plates, each corrected for dilution. It differs from mutation rate, which is per cell division."
    :calc="['engine' => 'genetics', 'tool' => 'mutation_frequency', 'fields' => ['mutants', 'cells']]"
    :how-to="[
        ['name' => 'Count mutants', 'text' => 'Colonies on selective plates, scaled to per mL.'],
        ['name' => 'Count viable cells', 'text' => 'Colonies on non-selective plates, scaled to per mL.'],
    ]"
    :faqs="[
        ['question' => 'Is mutation frequency the same as mutation rate?', 'answer' => 'No: frequency is the share of mutants now; rate is mutations per cell per division.'],
        ['question' => 'Why can frequency vary so much between cultures?', 'answer' => 'An early mutation leaves many mutant descendants (a jackpot).'],
        ['question' => 'What is a typical spontaneous frequency?', 'answer' => 'About 10⁻⁸ to 10⁻⁶ per gene in bacteria.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="mutants" label="Mutant colonies (per mL)" value="25" min="0" />
        <x-calc.field name="cells" label="Viable cells (per mL)" value="500000000" min="0" />
    </div>

    <x-calc.result label="Mutation frequency" />

    <x-calc.options :examples="[
        '25 in 5 × 10⁸' => ['mutants' => 25, 'cells' => 500000000],
        '3 in 10⁹' => ['mutants' => 3, 'cells' => 1000000000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'per_million' => ['label' => 'Per million cells'],
            'one_in' => ['label' => 'One mutant in'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>f = mutants ÷ viable cells</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
