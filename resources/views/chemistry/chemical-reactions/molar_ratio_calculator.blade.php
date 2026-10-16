<x-calc.page
    title="Molar Ratio Calculator - SolveKit"
    description="Free molar ratio calculator: mole ratio between two species in a balanced equation, and the amount of one from the other."
    lede="Find the mole ratio between two substances in a reaction."
    about="The mole ratio comes straight from the coefficients of the balanced equation. Give an amount of the first species to work out how much of the second reacts or forms."
    :calc="['engine' => 'chem-reactions', 'tool' => 'molar_ratio', 'fields' => ['equation', 'species_a', 'species_b', 'amount', 'amount_unit'], 'data' => ['elements' => app(\App\Services\ChemistryData::class)->elements(['name', 'weight'])]]"
    :how-to="[
        ['name' => 'Enter the equation', 'text' => 'It is balanced for you.'],
        ['name' => 'Pick two species', 'text' => 'Then an amount if you like.'],
    ]"
    :faqs="[
        ['question' => 'What is a mole ratio?', 'answer' => 'The ratio of coefficients between two substances in a balanced equation.'],
        ['question' => 'How much NH₃ comes from 28 g of N₂?', 'answer' => '2 mol, or 34.06 g.'],
        ['question' => 'Do I use grams in the ratio?', 'answer' => 'No, the ratio is in moles; convert grams first.'],
    ]"
>
    <x-calc.field name="equation" label="Chemical equation" value="N2 + H2 = NH3" type="text" help="Use = or ->; it is balanced for you" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="species_a" label="First species" value="N2" type="text" help="From the equation" />
        <x-calc.field name="species_b" label="Second species" value="NH3" type="text" help="From the equation" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="amount" label="Amount of first (optional)" value="28" min="0" placeholder="Optional" />
        <x-calc.segmented name="amount_unit" legend="In" :options="['g' => 'grams', 'mol' => 'moles']" selected="g" />
    </div>

    <x-calc.result label="Mole ratio" />

    <x-calc.options :examples="[
        'N₂ to NH₃' => ['equation' => 'N2 + H2 = NH3', 'species_a' => 'N2', 'species_b' => 'NH3', 'amount' => 28, 'amount_unit' => 'g'],
        'Glucose to CO₂' => ['equation' => 'C6H12O6 + O2 = CO2 + H2O', 'species_a' => 'C6H12O6', 'species_b' => 'CO2', 'amount' => 180, 'amount_unit' => 'g'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'mass' => ['label' => 'Mass ratio'],
            'amount' => ['label' => 'Amount of second'],
            'equation' => ['label' => 'Balanced equation'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>ratio = coefficient B ÷ coefficient A</li>
            <li>n(B) = n(A) × ratio</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
