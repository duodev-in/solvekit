<x-calc.page
    title="Molar Mass Calculator - SolveKit"
    description="Free molar mass calculator: g/mol of any chemical formula, with brackets, hydrates and charges, using IUPAC atomic weights."
    lede="Find the molar mass of any chemical formula."
    about="Molar mass is the sum of the atomic weights of every atom in the formula. It uses the IUPAC (CIAAW) abridged standard atomic weights, and reads brackets such as Ca(OH)₂ and [Cu(NH₃)₄]SO₄, hydrates such as CuSO₄·5H₂O, and charges such as SO₄²⁻."
    :calc="['engine' => 'chem-general', 'tool' => 'molar_mass', 'fields' => ['formula'], 'data' => ['elements' => app(\App\Services\ChemistryData::class)->elements(['name', 'weight'])]]"
    :how-to="[
        ['name' => 'Type the formula', 'text' => 'Capital letter for each element: Co is cobalt, CO is carbon monoxide.'],
        ['name' => 'Read the molar mass', 'text' => 'With each element\'s share.'],
    ]"
    :faqs="[
        ['question' => 'How do I calculate molar mass?', 'answer' => 'Multiply each element\'s atomic weight by its count and add them up.'],
        ['question' => 'What is the molar mass of water?', 'answer' => '18.015 g/mol (2 × 1.008 + 15.999).'],
        ['question' => 'How do I enter a hydrate?', 'answer' => 'Use a dot or asterisk: CuSO4·5H2O or CuSO4*5H2O.'],
    ]"
>
    <x-calc.field name="formula" label="Chemical formula" value="C6H12O6" type="text" help="e.g. H2SO4, Ca(OH)2, CuSO4·5H2O" />

    <x-calc.result label="Molar mass" />

    <x-calc.options :examples="[
        'Glucose' => ['formula' => 'C6H12O6'],
        'Calcium hydroxide' => ['formula' => 'Ca(OH)2'],
        'Copper(II) sulfate pentahydrate' => ['formula' => 'CuSO4·5H2O'],
        'Potassium ferrocyanide' => ['formula' => 'K4[Fe(CN)6]'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'hill' => ['label' => 'Hill formula'],
            'atoms' => ['label' => 'Atoms per formula'],
            'kg' => ['label' => 'In kg/mol'],
        ]" />
        <x-calc.quick-ref heading="By element" name="parts" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>M = Σ count × atomic weight</li>
            <li>atomic weights: IUPAC CIAAW abridged</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
