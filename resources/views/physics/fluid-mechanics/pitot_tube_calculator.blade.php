<x-calc.page
    title="Pitot Tube Calculator - SolveKit"
    description="Free pitot tube calculator: flow speed from dynamic pressure or a manometer reading."
    lede="Find speed from a pitot tube."
    about="A pitot tube measures stagnation minus static pressure, the dynamic pressure ½ρv². Aircraft airspeed indicators work this way."
    :calc="['engine' => 'ph-fluid', 'tool' => 'pitot', 'fields' => ['mode', 'dP', 'h', 'rho', 'out'], 'unitFields' => ['dP' => collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o'])->all(), 'h' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'rho' => collect(config('units.density'))->only(['kgm3', 'gcm3', 'lbft3', 'lbin3', 'lbgal'])->all()], 'data' => ['units' => collect(config('units'))->only(['density', 'energy', 'force', 'length', 'mass', 'pressure', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What speed gives 245 Pa in air?', 'answer' => '20 m/s.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="mode" label="Reading" :options="['dp' => 'Dynamic pressure', 'mano' => 'Water manometer height']" selected="dp" />
        <div data-show-when="mode:dp">
            <x-calc.field name="dP" label="Dynamic pressure" value="245" min="0" placeholder="Dynamic pressure">
                <label for="calc-dP-unit" class="sr-only">Dynamic pressure unit</label>
                <select id="calc-dP-unit" name="dP-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'pa')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:mano">
            <x-calc.field name="h" label="Manometer height" value="25" placeholder="Manometer height">
                <label for="calc-h-unit" class="sr-only">Manometer height unit</label>
                <select id="calc-h-unit" name="h-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <x-calc.field name="rho" label="Fluid density" value="1.225" min="0" placeholder="Fluid density">
            <label for="calc-rho-unit" class="sr-only">Fluid density unit</label>
            <select id="calc-rho-unit" name="rho-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.density'))->only(['kgm3', 'gcm3', 'lbft3', 'lbin3', 'lbgal']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kgm3')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['ms' => 'm/s', 'cms' => 'cm/s', 'kmh' => 'km/h', 'mph' => 'mph', 'fts' => 'ft/s', 'knot' => 'kn', 'kms' => 'km/s', 'c' => 'c']" selected="ms" />
    </div>

    <x-calc.result label="Flow speed" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'ms', 'mode' => 'dp', 'dP' => 245, 'dP-unit' => 'pa', 'h' => 25, 'h-unit' => 'mm', 'rho' => 1.225, 'rho-unit' => 'kgm3'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'kmh' => ['label' => 'In km/h'],
            'q' => ['label' => 'Dynamic pressure used'],
            'note' => ['label' => 'Limit'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
