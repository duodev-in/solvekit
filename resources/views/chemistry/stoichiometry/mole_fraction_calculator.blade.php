<x-calc.page
    title="Mole Fraction Calculator - SolveKit"
    description="Free mole fraction calculator: mole fraction, mole percent and mass fraction of each component in a mixture."
    lede="Work out the mole fraction of each component in a mixture."
    about="The mole fraction of a component is its moles divided by the total moles; all fractions add up to 1. Enter each component as a formula with an amount in grams or moles, one per line."
    :calc="['engine' => 'chem-stoich', 'tool' => 'mole_fraction', 'fields' => ['components'], 'data' => ['elements' => app(\App\Services\ChemistryData::class)->elements(['name', 'weight'])]]"
    :how-to="[
        ['name' => 'Enter each component', 'text' => 'Formula, amount and unit, e.g. H2O 90 g.'],
    ]"
    :faqs="[
        ['question' => 'What is mole fraction?', 'answer' => 'Moles of one component ÷ total moles in the mixture.'],
        ['question' => 'Does it have units?', 'answer' => 'No, it is a ratio between 0 and 1.'],
        ['question' => 'Where is it used?', 'answer' => 'In Raoult\'s law, Dalton\'s law and phase diagrams.'],
    ]"
>
    <x-calc.textarea name="components" label="Formula and amount, one per line" value="H2O 90 g
C2H5OH 10 g" help="Units: g, mg, kg, mol or mmol" rows="4" />

    <x-calc.result label="Mole fractions" />

    <x-calc.options :decimals="false" :examples="[
        '10% ethanol by mass' => ['components' => 'H2O 90 g
C2H5OH 10 g'],
        'Air (main gases)' => ['components' => 'N2 0.78084 mol
O2 0.20946 mol
Ar 0.00934 mol'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'total' => ['label' => 'Total moles'],
            'mass' => ['label' => 'Total mass'],
        ]" />
        <x-calc.quick-ref heading="Each component" name="parts" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>xᵢ = nᵢ ÷ Σ n</li>
            <li>mol% = x × 100</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
