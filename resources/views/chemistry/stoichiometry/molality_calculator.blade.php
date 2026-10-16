<x-calc.page
    title="Molality Calculator - SolveKit"
    description="Free molality calculator: mol/kg of a solution from solute mass or moles and solvent mass, with mole fraction and molarity."
    lede="Work out the molality of a solution."
    about="Molality is moles of solute per kilogram of solvent. Unlike molarity, it does not change with temperature because it uses mass, not volume. With the solution density, the molarity follows too."
    :calc="['engine' => 'chem-stoich', 'tool' => 'molality', 'fields' => ['mode', 'formula', 'solute_mass', 'moles', 'solvent', 'water_solvent', 'density'], 'unitFields' => ['solute_mass' => collect(config('units.mass'))->only(['g', 'mg', 'kg'])->all(), 'solvent' => collect(config('units.mass'))->only(['g', 'mg', 'kg'])->all()], 'data' => ['elements' => app(\App\Services\ChemistryData::class)->elements(['name', 'weight'])]]"
    :how-to="[
        ['name' => 'Enter the solute', 'text' => 'Mass with formula, or moles.'],
        ['name' => 'Enter the solvent mass', 'text' => 'Not the solution volume.'],
    ]"
    :faqs="[
        ['question' => 'What is the difference between molality and molarity?', 'answer' => 'Molality is per kg of solvent; molarity is per liter of solution.'],
        ['question' => 'Why use molality?', 'answer' => 'It stays the same when temperature changes, so it is used for boiling and freezing point calculations.'],
        ['question' => 'What is 1 molal NaCl?', 'answer' => '58.44 g NaCl in 1 kg of water.'],
    ]"
>
    <x-calc.segmented name="mode" legend="Solute given as" :options="['mass' => 'Mass', 'moles' => 'Moles']" selected="mass" />

    <div data-show-when="mode:mass">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="formula" label="Solute formula" value="NaCl" type="text" help="e.g. H2SO4, Ca(OH)2, CuSO4·5H2O" />
            <x-calc.field name="solute_mass" label="Solute mass" value="58.44" min="0" placeholder="Solute mass">
                <label for="calc-solute_mass-unit" class="sr-only">Solute mass unit</label>
                <select id="calc-solute_mass-unit" name="solute_mass-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.mass'))->only(['g', 'mg', 'kg']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'g')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
    </div>

    <div data-show-when="mode:moles" hidden>
        <x-calc.field name="moles" label="Solute moles" value="1" min="0" suffix="mol" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="solvent" label="Solvent mass" value="1" min="0" placeholder="Solvent mass">
            <label for="calc-solvent-unit" class="sr-only">Solvent mass unit</label>
            <select id="calc-solvent-unit" name="solvent-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['g', 'mg', 'kg']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.segmented name="water_solvent" legend="Solvent is water" :options="['yes' => 'Yes', 'no' => 'No']" selected="yes" />
    </div>

    <div data-show-when="mode:mass">
        <x-calc.field name="density" label="Solution density (optional)" value="1.04" min="0" suffix="g/mL" placeholder="Optional" />
    </div>

    <x-calc.result label="Molality" />

    <x-calc.options :examples="[
        '1 m NaCl' => ['mode' => 'mass', 'formula' => 'NaCl', 'solute_mass' => 58.44, 'solute_mass-unit' => 'g', 'solvent' => 1, 'solvent-unit' => 'kg', 'water_solvent' => 'yes', 'density' => 1.04],
        'Sugar in water' => ['mode' => 'mass', 'formula' => 'C12H22O11', 'solute_mass' => 34.2, 'solute_mass-unit' => 'g', 'solvent' => 200, 'solvent-unit' => 'g', 'water_solvent' => 'yes', 'density' => ''],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'fraction' => ['label' => 'Mole fraction of solute'],
            'molarity' => ['label' => 'Molarity'],
            'mmol' => ['label' => 'In mmol/kg'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>b = n solute ÷ kg solvent</li>
            <li>molarity = n ÷ (solution mass ÷ density)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
