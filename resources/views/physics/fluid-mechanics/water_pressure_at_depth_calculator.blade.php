<x-calc.page
    title="Water Pressure at Depth Calculator - SolveKit"
    description="Free water pressure at depth calculator: absolute and gauge pressure in fresh or sea water."
    lede="Find water pressure at depth."
    about="Every 10 m of sea water adds about one atmosphere of pressure."
    :calc="['engine' => 'ph-fluid', 'tool' => 'water_depth_pressure', 'fields' => ['h', 'water', 'P0', 'out'], 'unitFields' => ['h' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'P0' => collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'pressure', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the pressure 10 m under the sea?', 'answer' => '2.01843 bar.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="h" label="Depth" value="10" placeholder="Depth">
            <label for="calc-h-unit" class="sr-only">Depth unit</label>
            <select id="calc-h-unit" name="h-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="water" label="Water" :options="['fresh' => 'Fresh (998 kg/m³)', 'sea' => 'Sea (1,025 kg/m³)']" selected="sea" />
        <x-calc.field name="P0" label="Air pressure at the surface" value="101.325" min="0" placeholder="Air pressure at the surface">
            <label for="calc-P0-unit" class="sr-only">Air pressure at the surface unit</label>
            <select id="calc-P0-unit" name="P0-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kpa')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['pa' => 'Pa', 'kpa' => 'kPa', 'mpa' => 'MPa', 'gpa' => 'GPa', 'hpa' => 'hPa', 'bar' => 'bar', 'mbar' => 'mbar', 'atm' => 'atm', 'psi' => 'psi', 'ksi' => 'ksi', 'torr' => 'Torr', 'mmhg' => 'mmHg', 'inhg' => 'inHg', 'inh2o' => 'inH₂O']" selected="bar" />
    </div>

    <x-calc.result label="Absolute pressure" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'bar', 'h' => 10, 'h-unit' => 'm', 'water' => 'sea', 'P0' => 101.325, 'P0-unit' => 'kpa'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'gauge' => ['label' => 'Gauge pressure'],
            'atm' => ['label' => 'In atmospheres'],
            'psi' => ['label' => 'In psi'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
