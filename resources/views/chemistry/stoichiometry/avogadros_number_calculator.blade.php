<x-calc.page
    title="Avogadro's Number Calculator - SolveKit"
    description="Free Avogadro's number calculator: convert moles to particles and particles to moles, with mass from a formula."
    lede="Convert between moles and particles with Avogadro's number."
    about="Avogadro's number Nₐ = 6.022 140 76 × 10²³ per mole is exact by definition since the 2019 SI redefinition. Particles can be atoms, molecules, ions or formula units."
    :calc="['engine' => 'chem-stoich', 'tool' => 'avogadro', 'fields' => ['direction', 'value', 'formula'], 'data' => ['elements' => app(\App\Services\ChemistryData::class)->elements(['name', 'weight'])]]"
    :how-to="[
        ['name' => 'Pick the direction', 'text' => 'Moles to particles or back.'],
        ['name' => 'Add a formula', 'text' => 'Optional, for the mass.'],
    ]"
    :faqs="[
        ['question' => 'What is Avogadro\'s number?', 'answer' => '6.022 140 76 × 10²³ per mole, exactly.'],
        ['question' => 'How many molecules are in a mole of water?', 'answer' => '6.022 × 10²³, weighing 18.015 g.'],
        ['question' => 'Why was it fixed exactly?', 'answer' => 'Since 2019 the mole is defined by fixing Nₐ.'],
    ]"
>
    <x-calc.segmented name="direction" legend="Convert" :options="['moles' => 'Moles → particles', 'particles' => 'Particles → moles']" selected="moles" />

    <x-calc.field name="value" label="Amount" value="2" min="0" />

    <x-calc.field name="formula" label="Formula (optional)" value="H2O" type="text" help="For the mass" />

    <x-calc.result label="Result" />

    <x-calc.options :examples="[
        '2 mol of water' => ['direction' => 'moles', 'value' => 2, 'formula' => 'H2O'],
        '10²⁴ molecules of CO₂' => ['direction' => 'particles', 'value' => 1e+24, 'formula' => 'CO2'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'moles' => ['label' => 'Moles'],
            'particles' => ['label' => 'Particles'],
            'mass' => ['label' => 'Mass'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>N = n × Nₐ</li>
            <li>Nₐ = 6.022 140 76 × 10²³ mol⁻¹</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
