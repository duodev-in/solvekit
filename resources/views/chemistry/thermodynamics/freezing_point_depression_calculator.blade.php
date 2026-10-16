<x-calc.page
    title="Freezing Point Depression Calculator - SolveKit"
    description="Free freezing point depression calculator: ΔTf = i Kf m for a solute in water or another solvent."
    lede="Work out how much a solute lowers the freezing point."
    about="Dissolved particles lower the freezing point by ΔTf = i × Kf × m, where m is molality and i the van 't Hoff factor. Kf values are from Atkins' Physical Chemistry; camphor's large Kf makes it useful for finding molar masses. The formula holds for dilute solutions."
    :calc="['engine' => 'chem-thermo', 'tool' => 'colligative', 'fields' => ['solvent', 'mode', 'formula', 'solute_mass', 'moles', 'solvent_mass', 'vant_hoff'], 'unitFields' => ['solute_mass' => collect(config('units.mass'))->only(['g', 'mg', 'kg'])->all(), 'solvent_mass' => collect(config('units.mass'))->only(['g', 'mg', 'kg'])->all()], 'data' => ['kind' => 'freezing', 'solvents' => config('chemistry_data.solvents'), 'elements' => app(\App\Services\ChemistryData::class)->elements(['name', 'weight'])]]"
    :how-to="[
        ['name' => 'Pick the solvent', 'text' => 'Water is the default.'],
        ['name' => 'Enter the solute', 'text' => 'Mass with formula, or moles.'],
        ['name' => 'Set the van \'t Hoff factor', 'text' => 'Particles per formula unit.'],
    ]"
    :faqs="[
        ['question' => 'How does antifreeze work?', 'answer' => 'Ethylene glycol lowers water\'s freezing point: 1 mol per kg lowers it by 1.86 °C.'],
        ['question' => 'Why does road salt melt ice?', 'answer' => 'NaCl gives two ions, lowering the freezing point twice as much per mole.'],
        ['question' => 'Is this exact for concentrated solutions?', 'answer' => 'No, real solutions deviate at high concentration.'],
    ]"
>
    <x-calc.select name="solvent" label="Solvent" :options="collect(config('chemistry_data.solvents'))->filter(fn ($s) => isset($s['kf']))->map(fn ($s) => $s['name'].' (Kf '.$s['kf'].')')->all()" selected="water" />

    <x-calc.segmented name="mode" legend="Solute given as" :options="['mass' => 'Mass', 'moles' => 'Moles']" selected="mass" />

    <div data-show-when="mode:mass">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="formula" label="Solute formula" value="C2H6O2" type="text" help="e.g. H2SO4, Ca(OH)2, CuSO4·5H2O" />
            <x-calc.field name="solute_mass" label="Solute mass" value="62.07" min="0" placeholder="Solute mass">
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
        <x-calc.field name="vant_hoff" label="van 't Hoff factor i" value="1" min="0" help="1 for ethylene glycol, 2 for NaCl" />
    </div>

    <x-calc.result label="Freezing point depression" />

    <x-calc.options :examples="[
        'Ethylene glycol in water' => ['solvent' => 'water', 'mode' => 'mass', 'formula' => 'C2H6O2', 'solute_mass' => 62.07, 'solute_mass-unit' => 'g', 'solvent_mass' => 1, 'solvent_mass-unit' => 'kg', 'vant_hoff' => 1],
        'Road salt' => ['solvent' => 'water', 'mode' => 'mass', 'formula' => 'NaCl', 'solute_mass' => 100, 'solute_mass-unit' => 'g', 'solvent_mass' => 1, 'solvent_mass-unit' => 'kg', 'vant_hoff' => 2],
        'Camphor method' => ['solvent' => 'camphor', 'mode' => 'moles', 'moles' => 0.01, 'solvent_mass' => 20, 'solvent_mass-unit' => 'g', 'vant_hoff' => 1],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'new_point' => ['label' => 'New freezing point'],
            'molality' => ['label' => 'Molality'],
            'constant' => ['label' => 'Kf used'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>ΔTf = i × Kf × m</li>
            <li>m = mol solute ÷ kg solvent</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
