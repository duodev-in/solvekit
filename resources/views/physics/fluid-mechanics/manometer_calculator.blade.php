<x-calc.page
    title="Manometer Calculator - SolveKit"
    description="Free manometer calculator: pressure difference from a U-tube reading with water, mercury or oil."
    lede="Read a manometer."
    about="A U-tube manometer balances pressure against a liquid column: ΔP = (ρ_m − ρ_f)gh."
    :calc="['engine' => 'ph-fluid', 'tool' => 'manometer', 'fields' => ['gauge', 'rhom', 'proc', 'rhof', 'h', 'out'], 'unitFields' => ['rhom' => collect(config('units.density'))->only(['kgm3', 'gcm3', 'lbft3', 'lbin3', 'lbgal'])->all(), 'rhof' => collect(config('units.density'))->only(['kgm3', 'gcm3', 'lbft3', 'lbin3', 'lbgal'])->all(), 'h' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['density', 'energy', 'force', 'length', 'mass', 'pressure', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What does 100 mm of water show?', 'answer' => '978.9 Pa.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="gauge" label="Manometer fluid" :options="['water' => 'Water (998 kg/m³)', 'mercury' => 'Mercury (13,534 kg/m³)', 'oil' => 'Red gauge oil (SG 0.826)', 'custom' => 'Other']" selected="water" />
        <div data-show-when="gauge:custom">
            <x-calc.field name="rhom" label="Manometer fluid density" value="1000" min="0" placeholder="Manometer fluid density">
                <label for="calc-rhom-unit" class="sr-only">Manometer fluid density unit</label>
                <select id="calc-rhom-unit" name="rhom-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.density'))->only(['kgm3', 'gcm3', 'lbft3', 'lbin3', 'lbgal']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kgm3')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <x-calc.select name="proc" label="Process fluid above it" :options="['air' => 'Air or gas (ignored)', 'water' => 'Water', 'custom' => 'Other']" selected="air" />
        <div data-show-when="proc:custom">
            <x-calc.field name="rhof" label="Process fluid density" value="998" min="0" placeholder="Process fluid density">
                <label for="calc-rhof-unit" class="sr-only">Process fluid density unit</label>
                <select id="calc-rhof-unit" name="rhof-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.density'))->only(['kgm3', 'gcm3', 'lbft3', 'lbin3', 'lbgal']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kgm3')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <x-calc.field name="h" label="Height difference" value="100" placeholder="Height difference">
            <label for="calc-h-unit" class="sr-only">Height difference unit</label>
            <select id="calc-h-unit" name="h-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['pa' => 'Pa', 'kpa' => 'kPa', 'mpa' => 'MPa', 'gpa' => 'GPa', 'hpa' => 'hPa', 'bar' => 'bar', 'mbar' => 'mbar', 'atm' => 'atm', 'psi' => 'psi', 'ksi' => 'ksi', 'torr' => 'Torr', 'mmhg' => 'mmHg', 'inhg' => 'inHg', 'inh2o' => 'inH₂O']" selected="pa" />
    </div>

    <x-calc.result label="Pressure difference" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'pa', 'gauge' => 'water', 'rhom' => 1000, 'rhom-unit' => 'kgm3', 'proc' => 'air', 'rhof' => 998, 'rhof-unit' => 'kgm3', 'h' => 100, 'h-unit' => 'mm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'kpa' => ['label' => 'In kPa'],
            'inh2o' => ['label' => 'In inches of water'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
