<x-calc.page
    title="Reaction Quotient Calculator - SolveKit"
    description="Free reaction quotient calculator: Q from current concentrations and which way the reaction will shift compared with K."
    lede="Work out the reaction quotient Q and which way a reaction will go."
    about="Q has the same form as K but uses the current concentrations. If Q < K the reaction moves forward to make more products; if Q > K it moves back; if Q = K it is at equilibrium. Pure solids and liquids are left out."
    :calc="['engine' => 'chem-reactions', 'tool' => 'reaction_quotient', 'fields' => ['equation', 'concentrations', 'k'], 'data' => ['elements' => app(\App\Services\ChemistryData::class)->elements(['name', 'weight'])]]"
    :how-to="[
        ['name' => 'Enter the equation', 'text' => 'Phases optional; mark (s) and (l).'],
        ['name' => 'Enter the current concentrations', 'text' => 'One per line.'],
        ['name' => 'Enter K', 'text' => 'To see the direction.'],
    ]"
    :faqs="[
        ['question' => 'What is the difference between Q and K?', 'answer' => 'K uses equilibrium concentrations; Q uses the concentrations right now.'],
        ['question' => 'What does Q < K mean?', 'answer' => 'The reaction will shift towards products.'],
        ['question' => 'Is Q always positive?', 'answer' => 'Yes, as long as every species in the expression is present.'],
    ]"
>
    <x-calc.field name="equation" label="Chemical equation" value="N2(g) + H2(g) = NH3(g)" type="text" help="Use = or ->; it is balanced for you" />

    <x-calc.textarea name="concentrations" label="Current concentrations" value="N2 0.5
H2 1.5
NH3 0.1" help="One per line: formula and concentration in mol/L (or pressure for gases)" rows="4" />

    <x-calc.field name="k" label="Equilibrium constant K" value="0.5" min="0" placeholder="To compare" />

    <x-calc.result label="Reaction quotient Q" />

    <x-calc.options :examples="[
        'Ammonia, K = 0.5' => ['equation' => 'N2(g) + H2(g) = NH3(g)', 'concentrations' => 'N2 0.5
H2 1.5
NH3 0.1', 'k' => 0.5],
        'HI mixture, K = 50' => ['equation' => 'H2(g) + I2(g) = HI(g)', 'concentrations' => 'H2 0.1
I2 0.1
HI 1.5', 'k' => 50],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'direction' => ['label' => 'Direction'],
            'ratio' => ['label' => 'Q ÷ K'],
            'equation' => ['label' => 'Balanced equation'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>Q = Π [products]^ν ÷ Π [reactants]^ν</li>
            <li>Q < K forward; Q > K backward</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
