<x-calc.page
    title="Net Ionic Equation Calculator - SolveKit"
    description="Free net ionic equation calculator: complete ionic equation, spectator ions and net ionic equation for reactions in water."
    lede="Write the complete and net ionic equations for a reaction in water."
    about="Strong electrolytes (soluble salts by the solubility rules, strong acids and strong bases) are split into ions; precipitates, water, gases and weak electrolytes stay whole. Ions that appear unchanged on both sides are spectators and are removed. This covers precipitation, acid–base and gas-forming reactions; redox reactions and complex ions are outside its scope."
    :calc="['engine' => 'chem-reactions', 'tool' => 'net_ionic', 'fields' => ['equation'], 'data' => ['elements' => app(\App\Services\ChemistryData::class)->elements(['name', 'weight'])]]"
    :how-to="[
        ['name' => 'Enter the molecular equation', 'text' => 'It is balanced for you.'],
        ['name' => 'Read the ionic equations', 'text' => 'Spectator ions are listed.'],
    ]"
    :faqs="[
        ['question' => 'What is a net ionic equation?', 'answer' => 'The reaction with spectator ions removed, showing only what changes.'],
        ['question' => 'Which compounds split into ions?', 'answer' => 'Soluble ionic compounds, strong acids and strong bases.'],
        ['question' => 'What if nothing is left?', 'answer' => 'If every ion is a spectator, no reaction takes place.'],
    ]"
>
    <x-calc.field name="equation" label="Chemical equation" value="AgNO3 + NaCl = AgCl + NaNO3" type="text" help="The molecular equation; phases are optional" />

    <x-calc.result label="Net ionic equation" />

    <x-calc.options :decimals="false" :examples="[
        'Silver chloride precipitate' => ['equation' => 'AgNO3 + NaCl = AgCl + NaNO3'],
        'Neutralization' => ['equation' => 'HCl + NaOH = NaCl + H2O'],
        'Carbonate and acid' => ['equation' => 'Na2CO3 + HCl = NaCl + H2O + CO2'],
        'Lead iodide' => ['equation' => 'Pb(NO3)2 + KI = PbI2 + KNO3'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'molecular' => ['label' => 'Balanced molecular equation'],
            'complete' => ['label' => 'Complete ionic equation'],
            'spectators' => ['label' => 'Spectator ions'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>split strong electrolytes into ions</li>
            <li>cancel ions common to both sides</li>
            <li>divide by the common factor</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
