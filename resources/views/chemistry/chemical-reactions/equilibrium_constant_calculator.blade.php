<x-calc.page
    title="Equilibrium Constant Calculator - SolveKit"
    description="Free equilibrium constant calculator: K from equilibrium concentrations, or from an ICE table with one measured equilibrium amount."
    lede="Work out an equilibrium constant from concentrations or an ICE table."
    about="K is the product of product concentrations raised to their coefficients, divided by the same for the reactants. Pure solids and liquids, marked (s) or (l), are left out. In ICE mode, give the initial concentrations and one measured equilibrium concentration; the change of every species follows from the stoichiometry."
    :calc="['engine' => 'chem-reactions', 'tool' => 'equilibrium_constant', 'fields' => ['mode', 'equation', 'concentrations', 'known_species', 'known_value'], 'data' => ['elements' => app(\App\Services\ChemistryData::class)->elements(['name', 'weight'])]]"
    :how-to="[
        ['name' => 'Enter the equation', 'text' => 'Mark (s) and (l) so they are excluded.'],
        ['name' => 'Enter the concentrations', 'text' => 'Equilibrium values, or initial values for ICE.'],
        ['name' => 'ICE mode', 'text' => 'Add one measured equilibrium concentration.'],
    ]"
    :faqs="[
        ['question' => 'Why are solids and liquids left out?', 'answer' => 'Their activity is 1, so they do not appear in K.'],
        ['question' => 'What does a large K mean?', 'answer' => 'Products are favored at equilibrium.'],
        ['question' => 'What is an ICE table?', 'answer' => 'Initial, Change, Equilibrium: a way to track amounts as a reaction reaches equilibrium.'],
    ]"
>
    <x-calc.segmented name="mode" legend="From" :options="['equilibrium' => 'Equilibrium amounts', 'ice' => 'ICE table']" selected="equilibrium" />

    <x-calc.field name="equation" label="Chemical equation" value="N2(g) + H2(g) = NH3(g)" type="text" help="Mark solids and liquids (s), (l) so they are left out" />

    <x-calc.textarea name="concentrations" label="Concentrations (initial in ICE mode)" value="N2 0.5
H2 1.5
NH3 0.1" help="One per line: formula and concentration in mol/L (or pressure for gases)" rows="4" />

    <div data-show-when="mode:ice" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="known_species" label="Measured species" value="HI" type="text" help="At equilibrium" />
            <x-calc.field name="known_value" label="Its equilibrium concentration" value="1.56" min="0" suffix="M" />
        </div>
    </div>

    <x-calc.result label="Equilibrium constant K" />

    <x-calc.options :examples="[
        'Ammonia equilibrium' => ['mode' => 'equilibrium', 'equation' => 'N2(g) + H2(g) = NH3(g)', 'concentrations' => 'N2 0.5
H2 1.5
NH3 0.1'],
        'HI by ICE table' => ['mode' => 'ice', 'equation' => 'H2(g) + I2(g) = HI(g)', 'concentrations' => 'H2 1
I2 1
HI 0', 'known_species' => 'HI', 'known_value' => 1.56],
        'Limestone decomposition' => ['mode' => 'equilibrium', 'equation' => 'CaCO3(s) = CaO(s) + CO2(g)', 'concentrations' => 'CO2 0.02'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'log' => ['label' => 'log K'],
            'favors' => ['label' => 'Equilibrium favors'],
            'equation' => ['label' => 'Balanced equation'],
        ]" />
        <x-calc.quick-ref heading="Concentrations (I → C → E)" name="ice" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>K = Π [products]^ν ÷ Π [reactants]^ν</li>
            <li>ICE: [X] = [X]₀ + ν x</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
