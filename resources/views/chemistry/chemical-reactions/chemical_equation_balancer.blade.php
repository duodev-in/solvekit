<x-calc.page
    title="Chemical Equation Balancer - SolveKit"
    description="Free chemical equation balancer: balances any equation exactly, including ionic and redox equations, with an atom check."
    lede="Balance any chemical equation, including ions and redox reactions."
    about="The balancer sets up one equation per element (and one for charge) and solves them exactly with whole-number fractions, so the coefficients are always the smallest whole numbers and never rounded. It also tells you when an equation cannot be balanced, or has more than one independent balance because it mixes separate reactions."
    :calc="['engine' => 'chem-reactions', 'tool' => 'balancer', 'fields' => ['equation'], 'data' => ['elements' => app(\App\Services\ChemistryData::class)->elements(['name', 'weight'])]]"
    :how-to="[
        ['name' => 'Type the equation', 'text' => 'Reactants, an arrow or =, then products.'],
        ['name' => 'Write ions with a caret', 'text' => 'Fe^3+, SO4^2-, e- for an electron.'],
    ]"
    :faqs="[
        ['question' => 'How do you balance a chemical equation?', 'answer' => 'Choose coefficients so every element, and the charge, is the same on both sides.'],
        ['question' => 'Can it balance redox equations?', 'answer' => 'Yes, including half-reactions with electrons and ions.'],
        ['question' => 'Why does it say more than one balance?', 'answer' => 'The equation combines two reactions, so coefficients are not unique; split it.'],
    ]"
>
    <x-calc.field name="equation" label="Chemical equation" value="KMnO4 + HCl = KCl + MnCl2 + H2O + Cl2" type="text" help="Use = or ->; ions as Fe^3+, e- for electrons" />

    <x-calc.result label="Balanced equation" />

    <x-calc.options :decimals="false" :examples="[
        'Iron rusting' => ['equation' => 'Fe + O2 = Fe2O3'],
        'Propane combustion' => ['equation' => 'C3H8 + O2 = CO2 + H2O'],
        'Permanganate and HCl' => ['equation' => 'KMnO4 + HCl = KCl + MnCl2 + H2O + Cl2'],
        'Redox in acid' => ['equation' => 'MnO4^- + Fe^2+ + H^+ = Mn^2+ + Fe^3+ + H2O'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'coefficients' => ['label' => 'Coefficients'],
            'mass' => ['label' => 'Mass check'],
            'charge' => ['label' => 'Charge check'],
        ]" />
        <x-calc.quick-ref heading="Atoms on each side" name="atoms" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>element balance: Σ ν × atoms = 0 for each element</li>
            <li>charge balance: Σ ν × charge = 0</li>
            <li>solved exactly (null space)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
