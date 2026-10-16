<x-calc.page
    title="Atom Economy Calculator - SolveKit"
    description="Free atom economy calculator: percent of reactant mass that ends up in the desired product, from a balanced equation."
    lede="Work out the atom economy of a reaction."
    about="Atom economy is the mass of the desired product divided by the total mass of reactants, both from the balanced equation. The equation is balanced for you. A high atom economy means little waste, a key idea in green chemistry."
    :calc="['engine' => 'chem-stoich', 'tool' => 'atom_economy', 'fields' => ['equation', 'product'], 'data' => ['elements' => app(\App\Services\ChemistryData::class)->elements(['name', 'weight'])]]"
    :how-to="[
        ['name' => 'Enter the equation', 'text' => 'It does not need to be balanced.'],
        ['name' => 'Name the product', 'text' => 'The one you want.'],
    ]"
    :faqs="[
        ['question' => 'What is a good atom economy?', 'answer' => 'Addition reactions reach 100%; substitutions and eliminations are lower.'],
        ['question' => 'Is atom economy the same as yield?', 'answer' => 'No: yield measures what you actually got; atom economy is the theoretical maximum share.'],
        ['question' => 'Why does it matter?', 'answer' => 'Low atom economy means waste even at 100% yield.'],
    ]"
>
    <x-calc.field name="equation" label="Equation" value="C2H5OH = C2H4 + H2O" type="text" help="Use = or ->; it is balanced automatically" />

    <x-calc.field name="product" label="Desired product" value="C2H4" type="text" help="One of the products" />

    <x-calc.result label="Atom economy" />

    <x-calc.options :examples="[
        'Ethanol to ethene' => ['equation' => 'C2H5OH = C2H4 + H2O', 'product' => 'C2H4'],
        'Haber process' => ['equation' => 'N2 + H2 = NH3', 'product' => 'NH3'],
        'Limestone to lime' => ['equation' => 'CaCO3 = CaO + CO2', 'product' => 'CaO'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'product' => ['label' => 'Mass of product'],
            'reactants' => ['label' => 'Mass of reactants'],
            'waste' => ['label' => 'By-products'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>AE = ν M(product) ÷ Σ ν M(reactants) × 100</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
