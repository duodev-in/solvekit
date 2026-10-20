<x-calc.page
    title="Rocket Thrust Calculator - SolveKit"
    description="Free rocket thrust calculator: thrust from mass flow, exhaust velocity and nozzle pressure."
    lede="Find rocket thrust."
    about="Thrust is the momentum of the exhaust per second plus a pressure term at the nozzle exit. At sea level the outside air pushes back, which is why engines make more thrust in vacuum."
    :calc="['engine' => 'ph-astro', 'tool' => 'rocket_thrust', 'fields' => ['mdot', 've', 'pe', 'pa', 'Ae', 'out'], 'unitFields' => ['mdot' => collect(config('units.mass_flow'))->only(['kgs', 'gs', 'kgmin', 'kgh', 'lbs', 'lbmin', 'lbh'])->all(), 've' => collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c'])->all(), 'pe' => collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o'])->all(), 'pa' => collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o'])->all(), 'Ae' => collect(config('units.area'))->only(['m2', 'cm2', 'mm2', 'km2', 'ha', 'ft2', 'in2', 'yd2', 'acre'])->all()], 'data' => ['units' => collect(config('units'))->only(['area', 'energy', 'force', 'length', 'mass', 'mass_flow', 'pressure', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What thrust does the example engine make at sea level?', 'answer' => '811.808 kN.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="mdot" label="Mass flow rate" value="300" min="0" placeholder="Mass flow rate">
            <label for="calc-mdot-unit" class="sr-only">Mass flow rate unit</label>
            <select id="calc-mdot-unit" name="mdot-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass_flow'))->only(['kgs', 'gs', 'kgmin', 'kgh', 'lbs', 'lbmin', 'lbh']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kgs')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="ve" label="Exhaust velocity" value="2800" placeholder="Exhaust velocity">
            <label for="calc-ve-unit" class="sr-only">Exhaust velocity unit</label>
            <select id="calc-ve-unit" name="ve-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ms')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="pe" label="Nozzle exit pressure" value="70" min="0" placeholder="Nozzle exit pressure">
            <label for="calc-pe-unit" class="sr-only">Nozzle exit pressure unit</label>
            <select id="calc-pe-unit" name="pe-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kpa')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="pa" label="Ambient pressure" value="101.325" min="0" placeholder="Ambient pressure">
            <label for="calc-pa-unit" class="sr-only">Ambient pressure unit</label>
            <select id="calc-pa-unit" name="pa-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kpa')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="Ae" label="Nozzle exit area" value="0.9" min="0" placeholder="Nozzle exit area">
            <label for="calc-Ae-unit" class="sr-only">Nozzle exit area unit</label>
            <select id="calc-Ae-unit" name="Ae-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.area'))->only(['m2', 'cm2', 'mm2', 'km2', 'ha', 'ft2', 'in2', 'yd2', 'acre']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'm2')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['n' => 'N', 'kn' => 'kN', 'millinewton' => 'mN', 'meganewton' => 'MN', 'lbf' => 'lbf', 'kgf' => 'kgf', 'dyn' => 'dyn', 'kip' => 'kip']" selected="kn" />
    </div>

    <x-calc.result label="Thrust" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'kn', 'mdot' => 300, 'mdot-unit' => 'kgs', 've' => 2800, 've-unit' => 'ms', 'pe' => 70, 'pe-unit' => 'kpa', 'pa' => 101.325, 'pa-unit' => 'kpa', 'Ae' => 0.9, 'Ae-unit' => 'm2'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'mom' => ['label' => 'Momentum thrust'],
            'press' => ['label' => 'Pressure thrust'],
            'isp' => ['label' => 'Effective specific impulse'],
            'vac' => ['label' => 'Thrust in vacuum'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
