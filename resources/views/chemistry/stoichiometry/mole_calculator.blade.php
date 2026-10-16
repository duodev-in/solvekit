<x-calc.page
    title="Mole Calculator - SolveKit"
    description="Free mole calculator: moles from mass, number of particles, gas volume at STP or solution concentration and volume."
    lede="Find the number of moles from any quantity."
    about="The mole links mass, particles, gas volume and solution amount: n = m ÷ M = N ÷ Nₐ = V ÷ Vm = c × V. Gas volume uses the ideal molar volume at IUPAC STP (22.711 L at 0 °C and 100 kPa) or the older 22.414 L at 1 atm."
    :calc="['engine' => 'chem-stoich', 'tool' => 'mole', 'fields' => ['mode', 'formula', 'mass', 'particles', 'gas_volume', 'stp', 'concentration', 'solution_volume'], 'unitFields' => ['mass' => collect(config('units.mass'))->only(['g', 'mg', 'kg'])->all(), 'solution_volume' => collect(config('units.volume'))->only(['ml', 'l'])->all()], 'data' => ['elements' => app(\App\Services\ChemistryData::class)->elements(['name', 'weight'])]]"
    :how-to="[
        ['name' => 'Pick what you know', 'text' => 'Mass, particles, gas volume or solution.'],
        ['name' => 'Enter the formula', 'text' => 'To convert to and from mass.'],
    ]"
    :faqs="[
        ['question' => 'What is the molar volume of a gas?', 'answer' => '22.711 L at IUPAC STP (0 °C, 100 kPa), or 22.414 L at 0 °C and 1 atm.'],
        ['question' => 'How many moles in 44 g of CO₂?', 'answer' => 'About 1 mol: 44 g ÷ 44.009 g/mol = 0.9998 mol.'],
        ['question' => 'How do I find moles in a solution?', 'answer' => 'Concentration × volume in liters.'],
    ]"
>
    <x-calc.segmented name="mode" legend="From" :options="['mass' => 'Mass', 'particles' => 'Particles', 'gas' => 'Gas volume', 'solution' => 'Solution']" selected="mass" />

    <x-calc.field name="formula" label="Formula" value="CO2" type="text" help="Needed for mass" />

    <div data-show-when="mode:mass">
        <x-calc.field name="mass" label="Mass" value="44" min="0" placeholder="Mass">
            <label for="calc-mass-unit" class="sr-only">Mass unit</label>
            <select id="calc-mass-unit" name="mass-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['g', 'mg', 'kg']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'g')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div data-show-when="mode:particles" hidden>
        <x-calc.field name="particles" label="Particles" value="6.022e+23" min="0" />
    </div>

    <div data-show-when="mode:gas" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="gas_volume" label="Gas volume at STP" value="22.71" min="0" suffix="L" />
            <x-calc.select name="stp" label="STP definition" :options="['iupac' => 'IUPAC: 0 °C, 100 kPa', 'atm' => 'Older: 0 °C, 1 atm']" selected="iupac" />
        </div>
    </div>

    <div data-show-when="mode:solution" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="concentration" label="Concentration" value="0.5" min="0" suffix="mol/L" />
            <x-calc.field name="solution_volume" label="Volume" value="250" min="0" placeholder="Volume">
                <label for="calc-solution_volume-unit" class="sr-only">Volume unit</label>
                <select id="calc-solution_volume-unit" name="solution_volume-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.volume'))->only(['ml', 'l']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'ml')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
    </div>

    <x-calc.result label="Amount of substance" />

    <x-calc.options :examples="[
        '44 g CO₂' => ['mode' => 'mass', 'formula' => 'CO2', 'mass' => 44, 'mass-unit' => 'g'],
        '22.71 L gas' => ['mode' => 'gas', 'formula' => 'CO2', 'gas_volume' => 22.71, 'stp' => 'iupac'],
        '250 mL of 0.5 M' => ['mode' => 'solution', 'formula' => 'NaCl', 'concentration' => 0.5, 'solution_volume' => 250, 'solution_volume-unit' => 'ml'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'mass' => ['label' => 'Mass'],
            'particles' => ['label' => 'Particles'],
            'gas' => ['label' => 'Gas volume at STP'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>n = m ÷ M = N ÷ Nₐ = V ÷ Vm = c × V</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
