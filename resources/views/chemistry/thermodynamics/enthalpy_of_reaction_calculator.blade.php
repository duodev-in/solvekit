<x-calc.page
    title="Enthalpy of Reaction Calculator - SolveKit"
    description="Free enthalpy of reaction calculator: standard ΔH° of a reaction by Hess's law from formation enthalpies, with ΔS° and ΔG°."
    lede="Work out a reaction's standard enthalpy change from formation enthalpies."
    about="By Hess's law, ΔH°rxn = Σ ν ΔfH°(products) − Σ ν ΔfH°(reactants). The equation is balanced for you and each species is looked up by formula and phase among 311 substances (NBS/CRC values at 298.15 K). ΔS° and ΔG° come from the same table."
    :calc="['engine' => 'chem-thermo', 'tool' => 'enthalpy_reaction', 'fields' => ['equation'], 'data' => ['elements' => app(\App\Services\ChemistryData::class)->elements(['name', 'weight']), 'thermo' => config('chemistry_data.thermo')]]"
    :how-to="[
        ['name' => 'Enter the equation with phases', 'text' => 'E.g. H2O(l) or H2O(g); they differ by 44 kJ/mol.'],
    ]"
    :faqs="[
        ['question' => 'What is Hess\'s law?', 'answer' => 'Enthalpy is a state function, so ΔH can be built from formation enthalpies.'],
        ['question' => 'Why must phases be given?', 'answer' => 'Formation enthalpies depend on phase, e.g. water gas versus liquid.'],
        ['question' => 'What does negative ΔH mean?', 'answer' => 'The reaction releases heat (exothermic).'],
    ]"
>
    <x-calc.field name="equation" label="Chemical equation" value="CH4(g) + O2(g) = CO2(g) + H2O(l)" type="text" help="Phases are required: (s), (l), (g) or (aq)" />

    <x-calc.result label="Enthalpy of reaction" />

    <x-calc.options :examples="[
        'Methane combustion' => ['equation' => 'CH4(g) + O2(g) = CO2(g) + H2O(l)'],
        'Ammonia synthesis' => ['equation' => 'N2(g) + H2(g) = NH3(g)'],
        'Thermite' => ['equation' => 'Al(s) + Fe2O3(s) = Al2O3(s) + Fe(s)'],
        'Glucose respiration' => ['equation' => 'C6H12O6(s) + O2(g) = CO2(g) + H2O(l)'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            's' => ['label' => 'ΔS°'],
            'g' => ['label' => 'ΔG°'],
            'k' => ['label' => 'K at 25 °C'],
        ]" />
        <x-calc.quick-ref heading="Terms" name="terms" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>ΔH° = Σ ν ΔfH°(products) − Σ ν ΔfH°(reactants)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
