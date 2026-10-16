<x-calc.page
    title="Moles to Atoms Converter - SolveKit"
    description="Free moles to atoms converter: number of atoms in a given amount of an element or compound, and back."
    lede="Convert moles to atoms, or atoms to moles."
    about="Atoms = moles × Avogadro's number × atoms per formula unit. One mole of water holds 6.022 × 10²³ molecules but three times as many atoms."
    :calc="['engine' => 'chem-stoich', 'tool' => 'moles_atoms', 'fields' => ['direction', 'value', 'formula'], 'data' => ['elements' => app(\App\Services\ChemistryData::class)->elements(['name', 'weight'])]]"
    :how-to="[
        ['name' => 'Pick the direction', 'text' => 'Moles to atoms or back.'],
        ['name' => 'Add a formula', 'text' => 'For compounds, so all atoms are counted.'],
    ]"
    :faqs="[
        ['question' => 'How many atoms in a mole?', 'answer' => '6.022 × 10²³ for an element; more for compounds.'],
        ['question' => 'How many atoms in 1 mol of water?', 'answer' => '1.807 × 10²⁴ (3 per molecule).'],
        ['question' => 'How do I count atoms in a formula?', 'answer' => 'Add the subscripts: H₂O has 3.'],
    ]"
>
    <x-calc.segmented name="direction" legend="Convert" :options="['moles' => 'Moles → atoms', 'atoms' => 'Atoms → moles']" selected="moles" />

    <x-calc.field name="value" label="Amount" value="1" min="0" />

    <x-calc.field name="formula" label="Formula (optional)" value="H2O" type="text" help="Leave empty for one element" />

    <x-calc.result label="Result" />

    <x-calc.options :examples="[
        '1 mol water' => ['direction' => 'moles', 'value' => 1, 'formula' => 'H2O'],
        '2 mol iron' => ['direction' => 'moles', 'value' => 2, 'formula' => 'Fe'],
        '10²⁴ atoms of carbon' => ['direction' => 'atoms', 'value' => 1e+24, 'formula' => 'C'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'molecules' => ['label' => 'Formula units'],
            'atoms' => ['label' => 'Atoms'],
            'mass' => ['label' => 'Mass'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>atoms = n × Nₐ × atoms per formula unit</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
