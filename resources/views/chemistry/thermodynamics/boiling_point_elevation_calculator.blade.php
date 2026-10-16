<x-calc.page
    title="Boiling Point Elevation Calculator - SolveKit"
    description="Free boiling point elevation calculator: ΔTb = i Kb m for a solute in water or another solvent."
    lede="Work out how much a solute raises the boiling point."
    about="Dissolved particles raise the boiling point by ΔTb = i × Kb × m, where m is molality and i the van 't Hoff factor (about 2 for NaCl, 3 for CaCl₂, 1 for sugar). Kb values are from Atkins' Physical Chemistry. The formula is exact for dilute ideal solutions."
    :calc="['engine' => 'chem-thermo', 'tool' => 'colligative', 'fields' => ['solvent', 'mode', 'formula', 'solute_mass', 'moles', 'solvent_mass', 'vant_hoff'], 'unitFields' => ['solute_mass' => collect(config('units.mass'))->only(['g', 'mg', 'kg'])->all(), 'solvent_mass' => collect(config('units.mass'))->only(['g', 'mg', 'kg'])->all()], 'data' => ['kind' => 'boiling', 'solvents' => config('chemistry_data.solvents'), 'elements' => app(\App\Services\ChemistryData::class)->elements(['name', 'weight'])]]"
    :how-to="[
        ['name' => 'Pick the solvent', 'text' => 'Water is the default.'],
        ['name' => 'Enter the solute', 'text' => 'Mass with formula, or moles.'],
        ['name' => 'Set the van \'t Hoff factor', 'text' => 'Particles per formula unit.'],
    ]"
    :faqs="[
        ['question' => 'How much does salt raise the boiling point of water?', 'answer' => '58 g NaCl in 1 kg of water raises it by about 1 °C.'],
        ['question' => 'What is the van \'t Hoff factor?', 'answer' => 'The number of particles each formula unit gives in solution.'],
        ['question' => 'Why does it depend on particles, not identity?', 'answer' => 'Boiling point elevation is a colligative property.'],
    ]"
>
    <x-calc.select name="solvent" label="Solvent" :options="collect(config('chemistry_data.solvents'))->filter(fn ($s) => isset($s['kb']))->map(fn ($s) => $s['name'].' (Kb '.$s['kb'].')')->all()" selected="water" />

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
        <x-calc.field name="solvent_mass" label="Solvent mass" value="1" min="0" placeholder="Solvent mass">
            <label for="calc-solvent_mass-unit" class="sr-only">Solvent mass unit</label>
            <select id="calc-solvent_mass-unit" name="solvent_mass-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['g', 'mg', 'kg']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="vant_hoff" label="van 't Hoff factor i" value="2" min="0" help="1 for sugar, 2 for NaCl" />
    </div>

    <x-calc.result label="Boiling point elevation" />

    <x-calc.options :examples="[
        '1 mol NaCl in 1 kg water' => ['solvent' => 'water', 'mode' => 'mass', 'formula' => 'NaCl', 'solute_mass' => 58.44, 'solute_mass-unit' => 'g', 'solvent_mass' => 1, 'solvent_mass-unit' => 'kg', 'vant_hoff' => 2],
        'Sugar in water' => ['solvent' => 'water', 'mode' => 'mass', 'formula' => 'C12H22O11', 'solute_mass' => 342.3, 'solute_mass-unit' => 'g', 'solvent_mass' => 1, 'solvent_mass-unit' => 'kg', 'vant_hoff' => 1],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'new_point' => ['label' => 'New boiling point'],
            'molality' => ['label' => 'Molality'],
            'constant' => ['label' => 'Kb used'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>ΔTb = i × Kb × m</li>
            <li>m = mol solute ÷ kg solvent</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
