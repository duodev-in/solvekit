<x-calc.page
    title="Heat of Combustion Calculator - SolveKit"
    description="Free heat of combustion calculator: enthalpy of combustion of a fuel from formation enthalpies, with higher and lower heating values, or from bomb calorimetry."
    lede="Work out a fuel's heat of combustion."
    about="Complete combustion gives CO₂, H₂O, SO₂ and N₂. By Hess's law, ΔHc = Σ ΔfH°(products) − ΔfH°(fuel), with standard values from the data table. The higher heating value counts water as liquid; the lower as vapor. If your fuel is not in the table, type its ΔfH°. In bomb mode, q = C × ΔT gives the heat released per gram at constant volume."
    :calc="['engine' => 'chem-thermo', 'tool' => 'combustion_heat', 'fields' => ['mode', 'fuel', 'phase', 'formation', 'calorimeter', 'delta_t', 'sample'], 'data' => ['elements' => app(\App\Services\ChemistryData::class)->elements(['name', 'weight']), 'thermo' => config('chemistry_data.thermo')]]"
    :how-to="[
        ['name' => 'Enter the fuel', 'text' => 'Formula and phase.'],
        ['name' => 'Or use a bomb calorimeter', 'text' => 'Constant, temperature rise and mass.'],
    ]"
    :faqs="[
        ['question' => 'What is the heat of combustion of methane?', 'answer' => 'About −890 kJ/mol (55.5 kJ/g) as the higher heating value.'],
        ['question' => 'What is the difference between HHV and LHV?', 'answer' => 'HHV includes the heat released when the water vapor condenses.'],
        ['question' => 'Why is ΔH negative?', 'answer' => 'Combustion releases heat; by convention released heat is negative.'],
    ]"
>
    <x-calc.segmented name="mode" legend="From" :options="['formula' => 'Formation enthalpies', 'bomb' => 'Bomb calorimeter']" selected="formula" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="fuel" label="Fuel formula" value="CH4" type="text" help="C, H, O, N and S only" />
        <div data-show-when="mode:formula">
            <x-calc.select name="phase" label="Fuel phase" :options="['g' => 'Gas', 'l' => 'Liquid', 's' => 'Solid']" selected="g" />
        </div>
    </div>

    <div data-show-when="mode:formula">
        <x-calc.field name="formation" label="Fuel ΔfH° (optional)" value="" suffix="kJ/mol" placeholder="From the table" />
    </div>

    <div data-show-when="mode:bomb" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
            <x-calc.field name="calorimeter" label="Calorimeter constant" value="10.2" min="0" suffix="kJ/°C" />
            <x-calc.field name="delta_t" label="Temperature rise" value="2.5" suffix="°C" />
            <x-calc.field name="sample" label="Sample mass" value="0.8" min="0" suffix="g" />
        </div>
    </div>

    <x-calc.result label="Heat of combustion" />

    <x-calc.options :examples="[
        'Methane' => ['mode' => 'formula', 'fuel' => 'CH4', 'phase' => 'g', 'formation' => ''],
        'Ethanol' => ['mode' => 'formula', 'fuel' => 'C2H5OH', 'phase' => 'l', 'formation' => ''],
        'Octane (your ΔfH°)' => ['mode' => 'formula', 'fuel' => 'C8H18', 'phase' => 'l', 'formation' => -250.1],
        'Bomb calorimeter' => ['mode' => 'bomb', 'fuel' => 'C6H12O6', 'calorimeter' => 10.2, 'delta_t' => 2.5, 'sample' => 1.6],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'molar' => ['label' => 'Per gram'],
            'lhv' => ['label' => 'Lower heating value'],
            'equation' => ['label' => 'Combustion'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>ΔHc = Σ ΔfH°(products) − ΔfH°(fuel)</li>
            <li>bomb: q = C × ΔT</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
